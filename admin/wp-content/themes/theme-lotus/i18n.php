<?php

class Setup_Theme_Language
{
	/**
	 * @var array<string, string>
	 */
	private $locales;

	/**
	 * @var string
	 */
	private $locales_key = "theme_locales";

	/**
	 * @var wpdb 
	 */
	private $wpdb;

	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;

		add_action('load-post.php', [$this, 'lang_post_meta_setup']);
		add_action('load-post-new.php', [$this, 'lang_post_meta_setup']);
		add_action('save_post', [$this, 'update_languages']);

		add_filter('manage_posts_columns', [$this, 'add_post_column']);
		add_filter('manage_pages_columns', [$this, 'add_post_column']);
		add_action('manage_posts_custom_column', [$this, 'post_column']);
		add_action('manage_pages_custom_column', [$this, 'post_column']);

		add_action('admin_menu', [$this, 'language_admin']);

		add_action('product_cat_add_form_fields', [$this, 'display_term_meta_box']);
		add_action('product_cat_edit_form_fields', [$this, 'display_term_edit_meta_box']);

		add_action('created_product_cat', [$this, 'create_term_lang']);
		add_action('edited_product_cat', [$this, 'update_term_lang']);

		add_filter('manage_product_cat_custom_column', [$this, 'term_column'], 10, 3);
		add_filter('manage_edit-product_cat_columns', [$this, 'add_term_column']);

		add_action('admin_head', function () { ?>
<style>
.wp-list-table [class*="column-language_"] {
   width: 2em;
   box-sizing: content-box;
   vertical-align: middle;
}

td.column-description.description p {
   max-height: 5.4ch;
   overflow: hidden;
   text-overflow: ellipsis;
}
</style>
<?php });


		$temp = $wpdb->get_row($wpdb->prepare("SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", $this->locales_key));
		if ($temp) {
			$this->locales = unserialize($temp->option_value);
			$GLOBALS['locales'] = $this->locales;
			$GLOBALS['locales_code'] = array_map(function ($k) {
				return $k['code'];
			}, $this->locales);
		}
	}

	public function add_post_column($columns)
	{
		return $this->add_column($columns, 'date');
	}

	public function add_term_column($columns)
	{
		return $this->add_column($columns, 'posts');
	}

	public function lang_post_meta_setup()
	{
		add_meta_box(
			'pll_lang',
			__('Languages', 'lotus'),
			array($this, 'display_meta_box'),
			null,
			'side',
			'high'
		);
	}


	public function display_meta_box($post)
	{ ?>
<?php wp_nonce_field(basename(__FILE__), 'lang_nonce'); ?>
<div>
   <p class="post-attributes-label-wrapper" style="margin-bottom: 1em;">
      <strong><label for="post_lang"><?php _e("Select language", 'lotus'); ?></label></strong>
   </p>
   <div>
      <select name="post_lang" id="post_lang">
         <option value=""> --- LANGUAGE --- </option>
         <?php
					$value = get_post_meta($post->ID, 'post_lang', true);
					foreach ($this->locales as $lang) { ?>
         <option value="<?php echo $lang['code'] ?>" <?php selected($value, $lang['code']) ?>>
            <?php echo $lang['name'] ?>
         </option>
         <?php } ?>
      </select>
   </div>
   <div>
      <?php
				$data = $this->wpdb->get_row($this->wpdb->prepare('SELECT ID id, post_name from lotus_wp_posts where post_name = %s and ID != %d', [$post->post_name, $post->ID]));
				?>
      <h3>
         Sibling
         <a
            href="<?php echo admin_url('post.php?post=' . $data->id . '&action=edit') ?>"><?php echo $data->post_name ?></a>
      </h3>
   </div>
</div>
<?php
	}

	private function update_meta_value($post_id, $meta_key)
	{
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if (!isset($_POST['lang_nonce'])) return;
		if (!current_user_can('edit_post')) return;

		$meta_value = get_post_meta($post_id, $meta_key, true);
		$new_meta_value = (isset($_POST[$meta_key]) ? htmlspecialchars($_POST[$meta_key]) : '');

		if (empty($meta_value) && $new_meta_value) {
			add_post_meta($post_id, $meta_key, $new_meta_value, true);
		} else if (($new_meta_value !== $meta_value) && !empty($new_meta_value)) {
			update_post_meta($post_id, $meta_key, $new_meta_value);
		} else if (!$new_meta_value) {
			delete_post_meta($post_id, $meta_key);
		}
	}

	public function update_languages($post_id)
	{
		$this->update_meta_value($post_id, 'post_lang');
	}

	public function create_term_lang($term_id)
	{
		if (isset($_POST['term_lang']) && $_POST['term_lang'] != '') {
			$value = sanitize_title($_POST['term_lang']);
			add_term_meta($term_id, '__term_lang', $value, true);
		}
	}

	public function update_term_lang($term_id)
	{
		if (isset($_POST['term_lang']) && $_POST['term_lang'] != '') {
			$value = sanitize_title($_POST['term_lang']);
			update_term_meta($term_id, '__term_lang', $value);
		}
	}

	public function display_term_meta_box()
	{ ?>
<?php wp_nonce_field(basename(__FILE__), 'term_meta_text_nonce'); ?>
<div class="form-field term-meta-text-wrap">
   <label for="term-meta-text"><?php _e('Language', 'lotus'); ?></label>
   <select name="term_lang" id="term_lang">
      <option value=""> --- LANGUAGE --- </option>
      <?php
				foreach ($this->locales as $lang) { ?>
      <option value="<?php echo $lang['code'] ?>">
         <?php echo $lang['name'] ?>
      </option>
      <?php } ?>
   </select>
</div>
<?php
	}

	public function post_column($column)
	{
		global $post;
		$lang = get_post_meta($post->ID, 'post_lang', true);

		if (!$lang) {
			return;
		}

		$this->show_locales($column, $lang);
	}

	public function show_locales($column, $lang)
	{
		if (!in_array($column, ["language_" . $lang]) && in_array($column, ["language_es", "language_en"])) {
			printf("--");
		}

		if (in_array($column, ['language_' . $lang])) {
			$post_lang = ["flag" => ""];
			foreach ($this->locales as $langg) {
				if ($langg['code'] === $lang) {
					$post_lang['flag'] = $langg['flag'];
				} else continue;
			}
			printf(
				'<span class="pll_column_flag" style=""><span class="screen-reader-text">%1$s</span>%2$s</span>',
				esc_html(sprintf(__('This item is in %s', 'polylang'), $lang)),
				$post_lang["flag"]
			);
		}
	}

	public function term_column($content, $column_name, $term_id)
	{

		$lang = get_term_meta(absint($term_id), '__term_lang', true);

		if (!str_contains($column_name, "language_{$lang}") && preg_match_all("/language_es|language_en/", $column_name)) {
			$content .= "--";
		}

		if (str_contains($column_name, "language_{$lang}") && !empty($lang)) {
			$post_lang = ["flag" => ""];
			foreach ($this->locales as $langg) {
				if ($langg['code'] === $lang) {
					$post_lang['flag'] = $langg['flag'];
				} else continue;
			}

			$content .= sprintf(
				'<span class="pll_column_flag" style=""><span class="screen-reader-text">%1$s</span>%2$s</span>',
				esc_html(sprintf(__('This item is in %s', 'polylang'), $lang)),
				$post_lang["flag"]
			);
		}

		return $content;
	}

	public function display_term_edit_meta_box($term)
	{
		$_value = get_term_meta($term->term_id, '__term_lang', true);
		$value = sanitize_text_field($_value);
	?>
<tr class="form-field term-meta-text-wrap">
   <th scope="row"><label for="term-meta-text"><?php _e('Language', 'lotus'); ?></label></th>
   <td>
      <?php wp_nonce_field(basename(__FILE__), 'term_meta_text_nonce'); ?>
      <select name="term_lang" id="term_lang">
         <option value=""> --- LANGUAGE --- </option>
         <?php foreach ($this->locales as $lang) { ?>
         <option value="<?php echo $lang['code'] ?>" <?php selected($value, $lang['code']) ?>>
            <?php echo $lang['name'] ?>
         </option>
         <?php } ?>
      </select>
   </td>
</tr>
<?php
	}

	public function language_admin()
	{
		add_menu_page(
			'Page Language Configuration',
			'Languages',
			'administrator',
			__FILE__,
			[$this, 'language_configuration'],
			"dashicons-translation
        "
		);
	}

	public function language_configuration()
	{ ?>
<div class="wrap">
   <h1>Languages </h1>
   <div id="col-container">
      <div id="col-right">
         <div class="col-wrap">
            <div class="tablenav top"></div>
            Hola Mundillo
         </div>
      </div>
      <div id="col-left">
         <div class="col-wrap">
            <h2>Add new language</h2>
            <form method="post" action="options.php">
               <?php settings_fields('my-cool-plugin-settings-group'); ?>
               <?php do_settings_sections('my-cool-plugin-settings-group'); ?>
               <select name="lang-option" id="">
                  <?php
								foreach ($this->locales as $lang) { ?>
                  <option value="<?php echo $lang['code'] ?>">
                     <span><?php echo $lang['name'] ?></span>
                  </option>
                  <?php }
								?>
               </select>
               <?php submit_button(); ?>
            </form>
         </div>
      </div>
   </div>
</div>
<?php
	}

	public function add_column($columns, $before)
	{
		if ($n = array_search($before, array_keys($columns))) {
			$end = array_slice($columns, $n);
			$columns = array_slice($columns, 0, $n);
		}

		foreach ($this->locales as $lang) {
			$columns['language_' . $lang['code']] =  $lang['flag'] . '<span class="screen-reader-text">' . esc_html($lang['name']) . '</span>';
		}

		return isset($end) ? array_merge($columns, $end) : $columns;
	}

	public function update_post_with_locale()
	{
		global $wpdb;

		$without_locale = $wpdb->get_results($wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts}"
		));

		$query = $wpdb->prepare(
			"INSERT INTO {$wpdb->postmeta} (post_id, meta_key, meta_value)
				SELECT ID, 'post_lang', 'es' FROM {$wpdb->posts} WHERE ID NOT IN ( 
					SELECT post_id FROM {$wpdb->postmeta} p WHERE p.meta_key = 'post_lang'
			) AND post_type AND ('post', 'page', 'product') AND post_status = 'publish'"
		);
	}
}

new Setup_Theme_Language();