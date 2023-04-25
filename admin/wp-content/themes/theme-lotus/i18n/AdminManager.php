<?php

define("LANGUAGE_URI", __DIR__ . '.');

final class Language_Manager
{

	public $locales;
	private $locales_key = "theme_locales";
	public $wpdb;

	public function __construct($wpdb)
	{
		$this->wpdb = $wpdb;
		$this->query_default_locales();

		// === WORDPRESS HOOKS AND FILTERS ===
		add_action('admin_enqueue_scripts', [$this, 'enqueuing_admin_scripts']);
	}

	public function query_default_locales()
	{
		$temp = $this->wpdb->get_row($this->wpdb->prepare("SELECT option_value FROM {$this->wpdb->options} WHERE option_name = %s LIMIT 1", $this->locales_key));
		if (!empty($temp)) {
			$this->locales = unserialize($temp->option_value);
			$GLOBALS['locales'] = $this->locales;
		}
	}

	public function enqueuing_admin_scripts()
	{
		wp_enqueue_style('admin-lang-style', get_stylesheet_directory_uri() . '/i18n/assets/lang-style.css', [], fileatime(LANGUAGE_URI . "/assets/lang-style.css"));
		wp_enqueue_script('admin-lang-script', get_stylesheet_directory_uri() . '/i18n/assets/lang-script.js', [], fileatime(LANGUAGE_URI . "/assets/lang-script.js"));
	}
}

global $wpdb;

new Language_Manager($wpdb);
