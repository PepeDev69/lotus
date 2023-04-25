<?php

include_once(__DIR__ . "/lotus_bootstrap.php");
include_once(__DIR__ . "/i18n.php");
// include_once(__DIR__ . "/i18n/__index.php");
include_once(__DIR__ . "/BookingAdmin/public/admin.php");

final class Core_Theme_Functions
{
	public function __construct()
	{
		add_action('after_setup_theme', [$this, 'register_menus']);
		add_action('after_setup_theme', [$this, 'add_theme_supports']);
		add_action('admin_init', [$this, 'remove_theme_supports']);
		add_action('init', [$this, 'acf_option_page']);
		add_filter('rest_url', [$this, 'resolve_rest_url']);
		add_filter('wp_unique_post_slug', [$this, 'resolve_post_slug'], 11, 6);
		/**
		 * !For this filter to work you must set to false in wp-includes/taxonomy.php line 3217 
		 * ?  from `if ( $empty_slug || ( $parent !== (int) $term['parent']) )` to `if ( $empty_slug || !( $ parent !== (int) $term['parent']) )`
		 */
		add_filter('wp_unique_term_slug', [$this, 'resolve_term_slug'], 10, 3);

		add_action('woocommerce_product_options_pricing', [$this, 'product_extra_price']);
		add_action('save_post', [$this, 'save_price_on_post_save']);

		add_action('admin_menu', function () {
			remove_menu_page('edit-comments.php');
		});

		add_action('woocommerce_update_product', [$this, 'sync_on_product_save'], 10, 1);
		add_action('wpcf7_after_save', [$this, 'inject_scrapped_form'], 10, 1);
	}

	public function inject_scrapped_form($instance)
	{
		$html = do_shortcode('[contact-form-7 id="' . $instance->id . '"]');
		$clean_html = preg_replace('/<div style="display: none;">.*?<\/div>/is', '', $html);
		$DOCUMENT = new \DOMDocument();
		$DOCUMENT->loadHTML($clean_html);
		$DOCUMENT->encoding = "UTF-8";
		$label = $DOCUMENT->getElementsByTagName('label');
		$placeholder = $DOCUMENT->getElementsByTagName('input');
		$submit = $DOCUMENT->getElementById('submit');

		$fields = (object)[];
		foreach ($placeholder as $key => $element) {
			$name = $element->getAttribute('name');
			$clean_name = str_replace('-', '_', $name);
			$fields->{$clean_name} = (object)[
				"name" => $name,
				"placeholder" => utf8_decode($element->getAttribute('placeholder')),
			];
			if (count($label) !== 0) {
				$fields->{$clean_name}->label = utf8_decode($label[$key]->textContent);
			}
		}

		$fields->submit = (object)[
			"url" => site_url("/index.php/wp-json/contact-form-7/v1/contact-forms/{$instance->id}/feedback"),
			"label" => utf8_decode($submit->textContent)
		];

		$fields->messages = get_post_meta($instance->id, '_messages', true);

		$form_key = "__form_serializable";
		if (!get_post_meta($instance->id, $form_key)) {
			add_post_meta($instance->id, $form_key, json_encode($fields, JSON_UNESCAPED_UNICODE), true);
		} else {
			update_post_meta($instance->id, $form_key, json_encode($fields, JSON_UNESCAPED_UNICODE));
		}
	}

	public function resolve_rest_url($url)
	{
		return str_replace(home_url(), site_url() . '/index.php', $url);
	}

	public function resolve_post_slug($slug, $ID, $status, $type, $parent, $original)
	{
		global $wpdb;
		$query = $wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$original}' AND post_type = '{$type}' AND post_status = '{$status}'");

		if (count($wpdb->get_col($query)) > 2) {
			return $slug;
		}
		return $original;
	}

	public function resolve_term_slug($slug, $term, $original)
	{
		return $original;
	}

	public function register_menus()
	{
		register_nav_menus(
			array(
				'primary' => __('Primary Menu'),
			)
		);
	}

	public function remove_theme_supports()
	{
		remove_post_type_support('page', 'editor');
		remove_post_type_support('post', 'comments');
		remove_post_type_support('page', 'comments');
	}

	public function add_theme_supports()
	{
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support('menus');
	}

	public function acf_option_page()
	{
		acf_add_options_page(array(
			'page_title'    => 'Configuración General',
			'menu_title'    => 'Configuraciones',
			'menu_slug'     => 'theme-general-settings',
			'capability'    => 'edit_posts',
			'redirect'      =>  false,
			'position'      => '2.1',
			'icon_url'      => 'dashicons-admin-settings',
			'post_id'       => 'option'
		));

		acf_add_options_page(array(
			'page_title'    => 'Site Metadata',
			'menu_title'    => 'Site metadata',
			'menu_slug'     => 'site-meta-settings',
			'capability'    => 'edit_posts',
			'redirect'      =>  false,
			'position'      => '2.0',
			'icon_url'      => 'dashicons-media-archive',
			'post_id'       => 'site-meta'
		));

		$languages = array('es', 'en');
		foreach ($languages as $lang) {
			acf_add_options_page(array(
				'page_title' => 'Site Options (' . strtoupper($lang) . ')',
				'menu_title' => __('Site Options (' . strtoupper($lang) . ')', 'taxes'),
				'menu_slug'  => "site-options-${lang}",
				'post_id'    => "option-{$lang}"
			));
		}
	}

	public function product_extra_price()
	{
		woocommerce_wp_text_input([
			'id' => '_partial_price',
			'class' => 'short wc_input_price',
			'label' =>  __('Partial price ($)', 'woocommerce'),
			'description' =>  __('Partial payment of the appointment'),
			'placeholder' =>  '50'
		]);
	}

	public function save_price_on_post_save($product_id)
	{
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return;
		if (isset($_POST['_partial_price']) && is_numeric($_POST['_partial_price'])) {
			update_post_meta($product_id, '_partial_price', $_POST['_partial_price']);
		} else delete_post_meta($product_id, '_partial_price');
	}

	public function sync_on_product_save($product_id)
	{
		global $wpdb;
		$product = (object) wc_get_product($product_id)->get_data();
		$with_variant = $wpdb->get_row(
			"SELECT ID FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'product' AND post_name = '{$product->slug}' AND ID != {$product->id}"
		);

		if (!empty($with_variant)) {
			$gallery = implode(',', $product->gallery_image_ids);
			$partial_price = get_post_meta($product_id, '_partial_price', true);
			$wpdb->query($wpdb->prepare(
				"UPDATE {$wpdb->postmeta} SET meta_value = (
					CASE meta_key
						WHEN '_price' THEN '{$product->price}'
						WHEN '_regular_price' THEN '{$product->regular_price}'
						WHEN '_sale_price' THEN '{$product->sale_price}' 
						WHEN '_partial_price' THEN '{$partial_price}'
						WHEN '_manage_stock' THEN '{$product->manage_stock}'
						WHEN '_stock_status' THEN '{$product->stock_status}'
						WHEN '_stock' THEN '{$product->stock_quantity}'
						WHEN '_thumbnail_id' THEN '{$product->image_id}'
						WHEN '_product_image_gallery' THEN '{$gallery}'
						ELSE meta_value 
					END
				) WHERE post_id IN ( SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$product->slug}' AND post_type = 'product' AND post_status = 'publish' )"
			));
		}
	}
}

new Core_Theme_Functions();