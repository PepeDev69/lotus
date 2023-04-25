<?php

namespace Lotus\Shared\Container;

class Container
{
	private $bindings = [];

	private static $instance = null;

	public function get(string $service)
	{
		try {
			return $this->resolve($service);
		} catch (\Throwable $th) {
			throw new \Exception($th->getMessage(), $th->getCode());
		}
	}

	public function make(string $abstract)
	{
		return $this->get($abstract);
	}

	public function resolve(string $service)
	{
		if (isset($this->bindings[$service])) {
			return $this->bindings[$service]($this);
		}

		return $this->build($service);
	}

	private function build(string $abstract)
	{
		$reflector = new \ReflectionClass($abstract);
		$dependencies = $this->buildDependencies($reflector);
		return $reflector->newInstanceArgs($dependencies);
	}

	private function buildDependencies(\ReflectionClass $reflection)
	{
		if (!$contructor = $reflection->getConstructor()) {
			return [];
		}

		$dependencies = $contructor->getParameters();

		return array_map(function ($deps) {
			if (!$type = $deps->getType()) {
				throw new  \RuntimeException();
			}
			return $this->build($type);
		}, $dependencies);
	}

	public static function instance()
	{
		if (is_null(static::$instance)) {
			static::$instance = new static;
		}
		return static::$instance;
	}

	/**
	 * Disable clone Container
	 */
	private function __clone()
	{
	}
}
