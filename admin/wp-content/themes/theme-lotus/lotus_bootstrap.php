<?php

include_once(__DIR__ . "/vendor/autoload.php");

add_action('rest_api_init', [\Lotus\Modules\Post\Router::class, 'register_rest_routes']);
add_action('rest_api_init', [\Lotus\Modules\Product\Router::class, 'register_rest_routes']);
add_action('rest_api_init', [\Lotus\Modules\Service\Router::class, 'register_rest_routes']);
add_action('rest_api_init', [\Lotus\Modules\Bookly\Router::class, 'register_rest_routes']);
add_action('rest_api_init', [\Lotus\Modules\Order\Router::class, 'register_rest_routes']);
