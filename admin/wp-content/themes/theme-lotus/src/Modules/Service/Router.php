<?php

namespace Lotus\Modules\Service;

use Lotus\Shared\Providers\TwilioSMSManager;
use Lotus\Shared\Server;

final class Router
{
	private const NAMESPACE = "api/shop";

	final public function register_rest_routes()
	{
		register_rest_route(Router::NAMESPACE, 'services', [
			"methods"	=> Server::GET,
			"callback"	=> [app()->make(ServiceController::class), 'index'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'service', [
			"methods"	=> Server::GET,
			"callback"	=> [app()->make(ServiceController::class), 'find'],
			"permisision_callback" => '__return_true'
		]);

		register_rest_route(Router::NAMESPACE, 'category', [
			"methods"	=> Server::GET,
			"callback"	=> [app()->make(ServiceController::class), 'get_category'],
			"permisision_callback" => '__return_true'
		]);

		register_rest_route('api/bookly', 'services', [
			"methods"	=> Server::GET,
			"callback"	=> [app()->make(ServiceController::class), 'pickServicesForSelect'],
			"permisision_callback" => '__return_true'
		]);

		register_rest_route('api/bookly', 'services/all', [
			"methods"	=> Server::GET,
			"callback"	=> [app()->make(ServiceController::class), 'findServicesOnly'],
			"permisision_callback" => '__return_true'
		]);
	}
}
