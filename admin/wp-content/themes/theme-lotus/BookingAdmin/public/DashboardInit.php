<?php

final class InitDashboard
{
	public function __construct()
	{
		if (isset($_GET['page']) && $_GET['page'] == 'bookly-admin') {
			add_action('admin_init', [$this, 'init_dashboard'], 40);
		}
	}

	public function init_dashboard()
	{
		global $wp_rewrite;
		set_current_screen();
		echo $wp_rewrite->rules;
		include_once __DIR__ . "/view-dashboard.php";
		exit();
	}
}

return new InitDashboard();
