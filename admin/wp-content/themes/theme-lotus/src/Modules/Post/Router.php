<?php

namespace Lotus\Modules\Post;

use Lotus\Shared\Server;

final class Router
{
	private const NAMESPACE = 'api';

	final function register_rest_routes()
	{
		register_rest_route(Router::NAMESPACE, 'page', [
			"methods"  => Server::GET,
			"callback" => [app()->make(PostController::class), 'get_page'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'post', [
			"methods"  => Server::GET,
			"callback" => [app()->make(PostController::class), 'get_post'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'post-tech', [
			"methods"  => Server::GET,
			"callback" => [app()->make(PostController::class), 'get_post_tech'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'posts', [
			"methods"  => Server::GET,
			"callback" => [app()->make(PostController::class), 'get_posts'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'terms', [
			"methods"  => Server::GET,
			"callback" => [app()->make(PostController::class), 'get_terms'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'sub-categories', [
			"methods"  => Server::GET,
			"callback" => [app()->make(PostController::class), 'get_subcategories'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'terms/first', [
			"methods"  => Server::GET,
			"callback" => [app()->make(PostController::class), 'get_first_category'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'common', [
			"methods"   => Server::GET,
			"callback"  => [app()->make(PostController::class), 'get_common_post'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'site-meta', [
			"methods" 	=> Server::GET,
			"callback"  => [app()->make(PostController::class), 'get_site_meta'],
			"permision_callback" => "__return_true"
		]);

		register_rest_route(Router::NAMESPACE, 'get-menu', [
			"methods" 	=> Server::GET,
			"callback"  => [app()->make(PostController::class), 'get_menu'],
			"permision_callback" => "__return_true"
		]);
	}
}
