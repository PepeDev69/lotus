<?php

namespace Lotus\Modules\Product;

use Lotus\Shared\Server;

final class Router
{
	private const NAMESPACE = 'api/shop';

	final public function register_rest_routes()
	{
		register_rest_route(Router::NAMESPACE, 'products', [
			"methods"	=> Server::GET,
			"callback"	=> [app()->make(ProductController::class), 'index'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'product', [
			"methods"	=> Server::GET,
			"callback"	=> [app()->make(ProductController::class), 'find'],
			"permisision_callback" => '__return_true'
		]);

		register_rest_route(Router::NAMESPACE, 'product/verify/(?<id>[0-9]+)', [
			"methods"	=> Server::POST,
			"callback"	=> [app()->make(ProductController::class), 'verifyProduct'],
			"permisision_callback" => '__return_true'
		]);

		register_rest_route(Router::NAMESPACE, 'product/paginate', [
			"methods"	=> Server::GET,
			"callback"	=> [app()->make(ProductController::class), 'paginateProduct'],
			"permisision_callback" => '__return_true'
		]);
	}
}
