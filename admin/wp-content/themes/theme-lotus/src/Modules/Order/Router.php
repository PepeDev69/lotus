<?php

namespace Lotus\Modules\Order;

use Lotus\Shared\Server;

final class Router
{
	private const NAMESPACE = 'api/order';

	final function register_rest_routes()
	{
		register_rest_route(Router::NAMESPACE, 'create', [
			"methods"  => Server::POST,
			"callback" => [app()->make(OrderController::class), 'create_order'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'verify', [
			"methods"  => Server::POST,
			"callback" => [app()->make(OrderController::class), 'verify_order'],
			"permision_callback" => "__return_true"
		]);
	}
}
