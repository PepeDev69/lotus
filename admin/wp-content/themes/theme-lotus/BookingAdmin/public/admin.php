<?php
require_once(__DIR__ . '/helper.php');

define('BOOKLY_DIR', __FILE__);

class Bookly_Admin
{
	public function __construct()
	{
		add_action('admin_menu', [$this, 'create_admin_menu']);
		add_action('admin_menu', [$this, 'linked_admin_menu']);
	}

	public function create_admin_menu()
	{
		$dashboard = include_once(__DIR__ . "/DashboardInit.php");

		add_menu_page(
			__('Bookly Admin Page', 'bookly'),
			__('Bookly', 'bookly'),
			'manage_options',
			'bookly',
			[$this, 'handle_admin_page'],
			'dashicons-rest-api',
			26
		);

		add_submenu_page(
			'bookly',
			'Dashboard',
			'Dashboard',
			'manage_options',
			'bookly-admin',
			[$dashboard, 'init_dashboard'],
		);
	}

	public function linked_admin_menu()
	{
		global $menu;
		// $menu['26.34976'][2] = site_url('/wp-content/bookly');
	}

	public function handle_admin_page()
	{
		include_once(__DIR__ . "/view-admin.php");
	}
}

function print_data()
{
	$data = json_encode([
		"REST_URL"	=> rest_url('/api/bookly'),
		"NONCE"		=> wp_create_nonce('wp_rest'),
		"SITE_URL"  => site_url('/wp-admin/admin.php?page=bookly')
	]);
	return "<script type=\"application/json\" id=\"__bookly__data\">{$data}</script>";
}

new Bookly_Admin();
