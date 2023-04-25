<?php

namespace Lotus\Modules\Bookly\Config;

use Lotus\Shared\Response;

final class ConfigController
{
	private $repository;

	public function __construct(ConfigRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index(): Response
	{
		$config = $this->repository->find();
		return new Response($config);
	}

	public function create($request): Response
	{
		$time_zone  = $request->get_param('time_zone');
		$time_space = $request->get_param('time_space');

		$success = $this->repository->create();

		return new Response([]);
	}

	public function update($request): Response
	{
		$time_zone  = $request->get_param('time_zone');
		$time_space = $request->get_param('time_space');

		$success = $this->repository->update();

		return new Response([]);
	}
}
