<?php

class Env
{
	/**
	 * The directory for load .env file
	 * 
	 * @var string
	 */
	protected $path;

	/**
	 * The file name 
	 * 
	 * @var string
	 */
	protected $filename = '.env';

	/** 
	 * List of env saved
	 * 
	 * @var string[]
	 */
	protected static $envs = [];

	public function createFrom(string $path) 
	{
		$this->path = $path;

		return $this;
	}

	public function load()
	{
		if (!is_readable($this->path())) {
			throw new \RuntimeException('Env file is not readable', 200);
		}

		$lines = file($this->path(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach ($lines as $line) {
			// Ignore comments
			if (strpos(trim($line), '#') === 0) {
				continue;
			}

			[$name, $value] = explode('=', $line, 2);
			$name = trim($name);
			$value = trim($value);

			if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
				putenv(sprintf('%s=%s', $name, $value));
				$_ENV[$name] = $value;
				$_SERVER[$name] = $value;
				self::$envs[$name] = $value;
			}
		}

		return $this;
	}

	public function path()
	{
		return $this->path . DIRECTORY_SEPARATOR . $this->filename;
	}

	public function config(array $config)
	{
		$this->filename = $config['file'];
	}

	/**
	 * @param string|int $key
	 * @return string|int
	 */
	public static function get($key, $default = null)
	{
		return array_key_exists($key, static::all()) ? static::all()[$key] : $default;
	}

	public static function all()
	{
		return array_merge($_ENV, $_SERVER);
	}

	public static function registered()
	{
		return self::$envs;
	}
}

/**
 * @param string|int $key
 * @param string|int $default
 * 
 * @return string|int
 */
function env($key, $default = NULL)
{
	return Env::get($key, $default);
}

/**
 * 
 * @return string[]|int[]
 */
function allEnvs()
{
	return Env::registered();
}
