<?php

if (!function_exists('app')) {
	/**
	 * @return Lotus\Shared\Container\Container
	 */
	function app($abstract = null, array $args = [])
	{
		if (is_null($abstract)) {
			return Lotus\Shared\Container\Container::instance();
		}
		return Lotus\Shared\Container\Container::instance()->make($abstract);
	}
}

if (!function_exists('scheme_url')) {
	function scheme_url($id, $type = 'post')
	{
		$slug = str_replace(home_url(), '', $type === 'post' ? get_permalink($id) : get_term_link($id));
		return rtrim($slug, '/') ?: '/';
	}
}

if (!function_exists('image_uri')) {
	function image_uri($uri)
	{
		if (!$uri) {
			return '';
		}
		return preg_replace('/^(http:\/\/|https:\/\/).*\/wp-content/', base_uri('wp-content'), $uri);
	}
}

if (!function_exists('base_uri')) {
	function base_uri($uri = '')
	{
		if (empty($uri)) {
			return site_url();
		}
		return site_url('/' . $uri);
	}
}
