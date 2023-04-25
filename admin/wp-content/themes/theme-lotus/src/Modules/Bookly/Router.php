<?php

namespace Lotus\Modules\Bookly;

use Lotus\Shared\Http;
use Lotus\Modules\Bookly\User\UserController;
use Lotus\Modules\Bookly\Schedule\ScheduleController;
use Lotus\Modules\Bookly\Config\ConfigController;
use Lotus\Modules\Bookly\Customer\CustomerController;
use Lotus\Shared\Facade\DB;

final class Router
{
	private const NAMESPACE = 'api/bookly';

	final function register_rest_routes()
	{
		register_rest_route(Router::NAMESPACE, 'doctor', [
			"methods"	=> Http::GET,
			"callback"	=> [app()->make(UserController::class), 'index'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'doctor/create', [
			"methods"	=> Http::POST,
			"callback"	=> [app()->make(UserController::class), 'create'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'doctor/update/(?<id>[0-9]+)', [
			"methods"	=> Http::POST,
			"callback"	=> [app()->make(UserController::class), 'update'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'doctor/delete/(?<id>[0-9]+)', [
			"methods"	=> Http::DELETE,
			"callback"	=> [app()->make(UserController::class), 'delete'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'doctor/find/(?<id>[0-9]+)', [
			"methods"	=> Http::GET,
			"callback"	=> [app()->make(UserController::class), 'find'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'doctor/availables/(?<date>.*)', [
			"methods"	=> Http::GET,
			"callback"	=> [app()->make(UserController::class), 'searchAvailables'],
			"permission_callback" => "__return_true"
		]);

		// ===============================================================

		register_rest_route(Router::NAMESPACE, 'schedule', [
			"methods"  => Http::GET,
			"callback" => [app()->make(ScheduleController::class), 'index'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'schedule/create', [
			"methods"  => Http::POST,
			"callback" => [app()->make(ScheduleController::class), 'create'],
			"permission_callback" => '__return_true'
		]);

		register_rest_route(Router::NAMESPACE, 'schedule/update/(?<id>[0-9]+)', [
			"methods"  => Http::PUT,
			"callback" => [app()->make(ScheduleController::class), 'update'],
			"permission_callback" => '__return_true'
		]);

		register_rest_route(Router::NAMESPACE, 'schedule/delete/(?<id>[0-9]+)', [
			"methods"  => Http::DELETE,
			"callback" => [app()->make(ScheduleController::class), 'delete'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'schedule/find/(?<id>[0-9]+)', [
			"methods"  => Http::GET,
			"callback" => [app()->make(ScheduleController::class), 'find'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'schedule/find-by-date/(?<date>.*)', [
			"methods"  => Http::GET,
			"callback" => [app()->make(ScheduleController::class), 'findScheduleByDate'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'schedule/find-by-doctor/(?<doctor>.*)', [
			"methods"  => Http::GET,
			"callback" => [app()->make(ScheduleController::class), 'findScheduleByDoctor'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'schedule/search', [
			"methods"  => Http::GET,
			"callback" => [app()->make(ScheduleController::class), 'search'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'schedule/search-available', [
			"methods"  => Http::GET,
			"callback" => [app()->make(ScheduleController::class), 'searchAvailableByDate'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'schedule/date-range/(?<date>.*)', [
			"methods"  => Http::GET,
			"callback" => [app()->make(ScheduleController::class), 'dateRange'],
			"permission_callback" => "__return_true"
		]);

		// =======================================================================

		register_rest_route(Router::NAMESPACE, 'customer', [
			"methods"  => Http::GET,
			"callback" => [app()->make(CustomerController::class), 'index'],
			"permission_callback" => "__return_true"
		]);

		// ====== general fethcing

		register_rest_route(Router::NAMESPACE, 'config', [
			"methods"  => Http::GET,
			"callback" => [app()->make(ConfigController::class), 'index'],
			"permission_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'test', [
			"methods"  => Http::GET,
			"callback" => function () {
				return DB::table('doctor')
					->select("*", "CONCAT(first_name, ' ', last_name) as fullname")
					->get();
			},
			"permission_callback" => "__return_true"
		]);
	}

	final public function middleware($request)
	{
		return true;
	}
}
