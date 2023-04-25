<?php

namespace Lotus\Modules\Post;

use Lotus\Shared\Facade\DB;
use Lotus\Shared\Helper;

final class PostRepository
{
	/**
	 * Method get page from template and lang
	 * 
	 * @param string $template
	 * @param null|string $lang
	 * 
	 * @return object
	 */
	public function get_page(string $template, ?string $lang)
	{
		$table = DB::tables();
		$page = DB::selectOne(
			"SELECT ID id, post_name slug, meta.meta_value lang, post_title, post_date, post_content FROM {$table->posts} post 
                LEFT JOIN {$table->postmeta} meta ON meta.post_id = post.ID AND meta.meta_key = 'post_lang' WHERE post.ID IN (
                	SELECT post_id FROM {$table->postmeta} WHERE meta_key = '_wp_page_template' AND meta_value = :template
            	) AND post_type = 'page' AND post_status = 'publish' AND meta.meta_value = :lang",
			[":template" => "templates/$template.php", ":lang" => $lang]
		);

		$data = (object) array_merge(
			(array) $page,
			(array) $this->get_meta($page->id)
		);
		$data->post_content = Helper::autowrap($page->post_content);

		return $data;
	}

	/**
	 * Methos get posts by type and lang
	 * 
	 * @param string $template
	 * @param null|string $lang
	 * 
	 * @return array
	 */
	public function get_posts(string $type, string $lang)
	{
		$posts = DB::select(
			"SELECT 
				p.ID as id, 
				p.post_title as title, 
				p.post_name as slug, 
				mt.meta_value as lang, 
				p.post_content, 
				p.post_date, 
				(select guid from lotus_wp_posts where ID = pic.meta_value) picture 
			FROM lotus_wp_posts p
			LEFT JOIN lotus_wp_postmeta mt 
				ON mt.post_id = p.ID 
				AND mt.meta_key = 'post_lang' 
			LEFT JOIN lotus_wp_postmeta pic 
				ON pic.post_id = p.ID 
				AND pic.meta_key = '_thumbnail_id'
			WHERE p.post_type = :p_type 
				AND p.post_status = 'publish' 
				AND mt.meta_value = :lang",
			[
				":p_type" => $type,
				":lang" => $lang
			]
		);

		foreach ($posts as $key => $post) {
			$post->post_content = Helper::autowrap($post->post_content);
			$post->thumbnail    = Helper::image_uri($post->picture);
			$data[] = (array) array_merge(
				(array) $post,
				(array) $this->get_meta($post->id)
			);
		}

		return $data;
	}

	/**
	 * Methos get post by type, slug and lang
	 * 
	 * @param string $type
	 * @param string $slug
	 * @param null|string $lang
	 * 
	 * @return object
	 */
	public function get_post(string $type, string $slug, string $lang)
	{
		$table = DB::tables();
		$post  = DB::selectOne(
			"SELECT ps.ID as id, ps.post_title as title, ps.post_name as slug, pm.meta_value as lang, ps.post_content, ps.post_date as `date`, (select guid from lotus_wp_posts where ID = pic.meta_value) picture FROM `{$table->posts}` ps 
				LEFT JOIN `{$table->postmeta}` pm ON pm.post_id = ps.ID AND pm.meta_key = 'post_lang' 
				LEFT JOIN `{$table->postmeta}` pic ON pic.post_id = ps.ID AND pic.meta_key = '_thumbnail_id'
			WHERE ps.post_type = :p_type AND ps.post_status = 'publish' AND ps.post_name = :slug AND pm.meta_value = :lang",
			[":p_type" => $type, ":slug" => $slug, ":lang" => $lang]
		);

		$post->post_content = Helper::autowrap($post->post_content);
		$post->picture      = Helper::image_uri($post->picture);

		$data = (object) array_merge(
			(array) $post,
			(array) $this->get_meta($post->id)
		);

		return $data;
	}

	/**
	 * Methos get post by type, slug and lang
	 * 
	 * @param string $type
	 * @param string $slug
	 * @param null|string $lang
	 * 
	 * @return object
	 */
	public function get_post_tech(string $lang)
	{
		$table = DB::tables();

		// $pages;

		// if ($lang === 'en') {
		// 	$pages = DB::select(
		// 		"SELECT ID AS id, post_name AS slug, meta.meta_value AS lang, post_title, post_date, post_content
		// 			FROM {$table->posts} post ORDER BY id ASC
		// 			LEFT JOIN {$table->postmeta} meta ON meta.post_id = post.ID AND meta.meta_key = 'post_lang'
		// 			WHERE post.ID IN (
		// 				SELECT post_id FROM {$table->postmeta} WHERE meta_key = '_wp_page_template' AND meta_value
		// 				IN ('templates/acupulse.php', 'templates/legend-pro.php', 'templates/rejuvenation.php')
		// 			) AND post_type = 'page' AND post_status = 'publish' AND meta.meta_value = :lang",
		// 		[":lang" => $lang]
		// 	);
		// } else {
		// 	$pages = DB::select(
		// 		"SELECT ID AS id, post_name AS slug, meta.meta_value AS lang, post_title, post_date, post_content FROM {$table->posts} post 
		// 			LEFT JOIN {$table->postmeta} meta ON meta.post_id = post.ID AND meta.meta_key = 'post_lang' WHERE post.ID IN (
		// 				SELECT post_id FROM {$table->postmeta} WHERE meta_key = '_wp_page_template' AND meta_value IN ('templates/acupulse.php', 'templates/legend-pro.php', 'templates/rejuvenation.php')
		// 			) AND post_type = 'page' AND post_status = 'publish' AND meta.meta_value = :lang",
		// 		[":lang" => $lang]
		// 	);
		// }

		$pages = DB::select(
			"SELECT ID AS id, post_name AS slug, meta.meta_value AS lang, post_title, post_date, post_content FROM {$table->posts} post 
                LEFT JOIN {$table->postmeta} meta ON meta.post_id = post.ID AND meta.meta_key = 'post_lang' WHERE post.ID IN (
                	SELECT post_id FROM {$table->postmeta} WHERE meta_key = '_wp_page_template' AND meta_value IN ('templates/acupulse.php', 'templates/legend-pro.php', 'templates/rejuvenation.php')
            	) AND post_type = 'page' AND post_status = 'publish' AND meta.meta_value = :lang",
			[":lang" => $lang]
		);

		foreach ($pages as $page) {
			$data[] = (object) array_merge(
				(array) $page,
				['picture' => get_field('home_picture', $page->id)],
				['home_content' => get_field('tech_home_content', $page->id)]
			);
		}

		return $data;
	}

	/**
	 * Methos get post by type, slug and lang
	 * 
	 * @param string $term
	 * @param null|string $lang
	 * @param int $limit
	 * 
	 * @return array
	 */
	public function find_term(string $term, string $lang, int $limit)
	{
		$table = DB::tables();
		$LIMIT = (bool) $limit ? "LIMIT {$limit}" : "";
		$terms = DB::select(
			"SELECT tr.term_id, tr.name, tr.slug, tr.term_order, tx.description, tx.taxonomy, tx.count, th.meta_value AS thumb FROM {$table->terms} tr 
				INNER JOIN {$table->term_taxonomy} tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 AND tx.parent != 0
				LEFT JOIN {$table->terms} parent ON parent.term_id = tx.parent
				LEFT JOIN {$table->termmeta} tm ON tm.term_id = tr.term_id and tm.meta_key = '__term_lang'
				LEFT JOIN {$table->termmeta} th ON th.term_id = tr.term_id AND th.meta_key = 'thumbnail_id'
			WHERE tm.meta_value = :lang AND parent.slug = :term ORDER BY tr.term_order ASC {$LIMIT}",
			[":term" => $term, ":lang" => $lang]
		);

		foreach ($terms as $term) {
			$term->thumbnail = wp_get_attachment_url((int) $term->thumb);
			$response[] = (array) array_merge(
				(array) $term,
				(array) get_fields("{$term->taxonomy}_{$term->term_id}")
			);
		}

		return $response;
	}

	public function find_subcategories(string $parent, string $lang)
	{
		$categories = DB::select(
			"SELECT tr.term_id id, tr.name, tr.slug, tx.description, (select guid from lotus_wp_posts where ID = mt.meta_value) picture, tx.count from lotus_wp_terms tr 
				inner join lotus_wp_term_taxonomy tx on tx.term_id = tr.term_id 
				inner join lotus_wp_termmeta mt on mt.term_id = tr.term_id and mt.meta_key = 'thumbnail_id' 
			where tx.parent = (
				select str.term_id from lotus_wp_terms str inner join lotus_wp_termmeta tem on tem.term_id = str.term_id and tem.meta_key = '__term_lang'
				where str.slug = :parent and tem.meta_value = :lang limit 1
			)",
			[':parent' => $parent, ':lang' => $lang]
		);

		array_walk($categories, function (&$value) {
			$value->picture = Helper::image_uri($value->picture);
		});

		return $categories;
	}

	public function find_first_category(string $parent, string $lang)
	{
		$data = DB::selectOne(
			"SELECT tr.term_id, tr.name, tr.slug FROM lotus_wp_terms tr 
				INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' 
				INNER JOIN lotus_wp_termmeta ltm ON ltm.term_id = tx.term_id AND ltm.meta_key = '__term_lang' AND ltm.meta_value = :lang
				WHERE tx.parent IN (SELECT tx.term_id FROM lotus_wp_terms tr 
					INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' 
					INNER JOIN lotus_wp_termmeta ltm ON ltm.term_id = tx.term_id AND ltm.meta_key = '__term_lang' AND ltm.meta_value = :lang_s
					where tr.slug = :slug
				) ORDER BY tr.term_order LIMIT 1",
			[":lang" => $lang, ":lang_s" => $lang, ":slug" => $parent]
		);
		return $data;
	}

	public function get_common_post(string $post)
	{
		return $this->get_meta($post);
	}

	public function get_menu(string $lang)
	{
		$menu = DB::select("call sp_get_total_menu(?)", [$lang]);
		$products = DB::select(
			"SELECT ct.term_id id, JSON_ARRAYAGG(JSON_OBJECT('id', p.ID, 'title', p.post_title, 'slug', p.post_name, 'xorder', p.menu_order)) as posts FROM lotus_wp_posts p
				JOIN lotus_wp_term_relationships cpp ON cpp.object_id = p.ID JOIN lotus_wp_terms ct ON ct.term_id = cpp.term_taxonomy_id
				INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = ct.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 and tx.parent <> 0
				INNER JOIN lotus_wp_terms parent ON parent.term_id = tx.parent
				INNER JOIN lotus_wp_termmeta meta on meta.term_id = ct.term_id and meta.meta_key = '__term_lang' 
			WHERE p.post_status = 'publish' and meta.meta_value = ? and not parent.slug = 'services' group by 1",
			[$lang]
		);

		$posts = [];
		foreach ($products as $key => $product) {
			$products = json_decode($product->posts);
			array_walk($products, function (&$value) {
				$value->url = scheme_url($value->id);
			});
			usort($products, function ($a, $b) {
				return $a->xorder > $b->xorder;
			});

			$posts[$product->id] = $products;
		}

		function build_tree($items, $parent_id = 0, $nested = [])
		{
			$branch = [];
			foreach ($items as &$item) {
				if ((int) $item->parent === $parent_id) {
					$model = (object) [
						"id" 	 => (int) $item->id,
						"label"  => $item->label,
						"ref"	 => slugify($item->ref),
						"slug" 	 => $item->slug,
						"url"    => make_uri($item),
						"parent" => (int) $item->parent,
					];

					$children = build_tree($items, (int) $item->id, $nested);
					if ($children) {
						$model->children = $children;
					}
					if (isset($nested["{$model->id}"])) {
						$model->children = $nested["{$model->id}"];
					}
					$branch[] = $model;
				}
			}

			return $branch;
		}

		function make_uri($item)
		{
			if ($item->type === 'post_type') {
				return scheme_url($item->id);
			}
			if ($item->type === 'term') {
				return scheme_url((int) $item->id, 'term');
			}
			return $item->meta_url;
		}

		function slugify($text, string $divider = '-')
		{
			$text = preg_replace('~[^\pL\d]+~u', $divider, $text);
			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
			$text = preg_replace('~[^-\w]+~', '', $text);
			$text = trim($text, $divider);
			$text = preg_replace('~-+~', $divider, $text);
			$text = strtolower($text);
			if (empty($text)) {
				return 'n-a';
			}
			return $text;
		}

		return build_tree($menu, 0, $posts);
	}

	public function get_form(int $id)
	{
		$form = DB::selectOne("SELECT meta_value FROM `lotus_wp_postmeta` WHERE meta_key = '__form_serializable' AND post_id = ?", [$id]);

		return json_decode($form->meta_value);
	}

	public function find_site_meta()
	{
		$meta = $this->get_meta('site-meta');
		$meta_extra = (object) [
			"title"  => "Test title",
			"description" => 'Test description',
		];

		$meta = (object) array_merge(
			(array) $meta_extra,
			(array) $meta
		);
		return $meta;
	}

	public function get_meta($id)
	{
		return get_fields($id)
			? (object) get_fields($id)
			: (object) [];
	}
}