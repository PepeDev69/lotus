<?php

namespace Lotus\Modules\Product;

use Lotus\Shared\Facade\DB;
use Lotus\Shared\Helper;

final class ProductRepository
{
	public function find(string $slug, string $lang)
	{
		$product = DB::selectOne(
			"SELECT p.ID id, p.post_title name, p.post_name slug, p.post_content content, mt.meta, (select `guid` from lotus_wp_posts where ID = ptc.meta_value) picture, json_arrayagg(x.guid) gallery FROM lotus_wp_posts p 
				LEFT JOIN lotus_wp_postmeta pt ON pt.post_id = p.ID AND pt.meta_key = 'post_lang'
				LEFT JOIN lotus_wp_postmeta ptr on ptr.post_id = p.ID and ptr.meta_key = '_product_image_gallery'
				LEFT JOIN (SELECT guid, ID FROM lotus_wp_posts GROUP BY ID) x ON find_in_set(x.ID, ptr.meta_value)
				LEFT JOIN lotus_wp_postmeta ptc ON ptc.post_id = p.ID AND ptc.meta_key = '_thumbnail_id'
				LEFT JOIN ( 
					SELECT met.post_id, JSON_OBJECTAGG(SUBSTRING(met.meta_key, 2) , met.meta_value) AS meta FROM lotus_wp_postmeta met WHERE met.meta_key 
					IN ('_regular_price', '_partial_price', '_sale_price', '_manage_stock', '_stock', '_stock_status', '_price', '_partial_price') GROUP BY 1
				) mt ON mt.post_id = p.ID WHERE p.post_name = :slug AND pt.meta_value = :lang GROUP BY 1,2,3,4,5,6",
			[":slug" => $slug, ":lang" => $lang]
		);

		$product->gallery = array_map(function ($item) {
			return Helper::image_uri($item);
		}, json_decode($product->gallery));

		$product->content = Helper::autowrap($product->content);
		$product->picture = Helper::image_uri($product->picture);
		$product_meta     = $product->meta;

		$response = (object) array_merge(
			(array) Helper::except($product, ['meta']),
			(array) json_decode($product_meta),
			(array) get_fields($product->id)
		);

		return $response;
	}

	public function all(string $category, int $limit, string $lang)
	{
		$parameters = [
			':lang' => $lang,
		];

		$categoryQuery = '';
		if (!empty($category)) {
			$categoryQuery = " AND tr.slug = :category";
			$parameters[':category'] = $category;
		}
		$limitedQuery = '';
		if (is_numeric($limit) && $limit !== 0) {
			$limitedQuery = "LIMIT :limited";
			$parameters[':limited'] = $limit;
		}


		$products = DB::select(
			"SELECT p.ID as id, p.post_title as name, pmt.meta_value as price, p.post_name as slug, p.post_date as `date`, (select guid from lotus_wp_posts where ID = pt.meta_value) thumbnail FROM lotus_wp_posts p 
				LEFT JOIN lotus_wp_postmeta pmt ON pmt.post_id = p.ID AND pmt.meta_key = '_regular_price' 
				LEFT JOIN lotus_wp_postmeta pt ON pt.post_id = p.ID AND pt.meta_key = '_thumbnail_id'
			WHERE p.ID IN (
				SELECT object_id FROM lotus_wp_term_relationships WHERE term_taxonomy_id in (
					SELECT tr.term_id FROM lotus_wp_terms tr 
						INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 AND tx.parent != 0
						LEFT JOIN lotus_wp_terms trs ON trs.term_id = tx.parent
						LEFT JOIN lotus_wp_termmeta tm ON tm.term_id = tr.term_id AND tm.meta_key = '__term_lang' 
					WHERE trs.slug = 'products' $categoryQuery AND tm.meta_value = :lang
				)
			) AND p.post_status = 'publish' AND p.post_type = 'product' ORDER BY p.menu_order $limitedQuery",
			$parameters
		);

		foreach ($products as $key => $product) {
			$product->thumbnail = Helper::image_uri($product->thumbnail);
		}

		return $products;
	}

	public function paginate(string $parent, string $category, string $lang, int $page, int $perPage)
	{
		$total = DB::selectOne(
			"SELECT count FROM lotus_wp_terms tr INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' 
				INNER JOIN lotus_wp_termmeta mt ON mt.term_id = tr.term_id AND mt.meta_key = '__term_lang' 
			WHERE tr.slug = :term AND mt.meta_value = :lang",
			[
				':term' => $category,
				':lang' => $lang
			]
		)->count;

		[$pages, $count, $start, $next, $prev, $from, $to] = $this->calc_pagination((int) $total, $page, $perPage);

		$data = DB::select(
			"SELECT p.ID id, p.post_title name, pmt.meta_value price, pr.meta_value `partial`, p.post_name slug, p.post_date `date`, :parent, (select `guid` from lotus_wp_posts where ID = pt.meta_value) thumbnail FROM lotus_wp_posts p 
				LEFT JOIN lotus_wp_postmeta pmt ON pmt.post_id = p.ID AND pmt.meta_key = '_regular_price' 
				LEFT JOIN lotus_wp_postmeta pr ON pr.post_id = p.ID AND pr.meta_key = '_partial_price'
				LEFT JOIN lotus_wp_postmeta pt ON pt.post_id = p.ID AND pt.meta_key = '_thumbnail_id'
				WHERE p.ID IN (
					SELECT object_id FROM lotus_wp_term_relationships WHERE term_taxonomy_id = (
						SELECT tr.term_id FROM lotus_wp_terms tr INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 AND tx.parent <> 0
							INNER JOIN lotus_wp_termmeta mt ON mt.term_id = tr.term_id AND mt.meta_key = '__term_lang' 
						WHERE tr.slug = :category AND mt.meta_value = :lang limit 1
					)
				) AND p.post_status = 'publish' AND p.post_type = 'product' ORDER BY p.menu_order LIMIT :start, :each",
			[
				":parent"   => $parent,
				":category" => $category,
				":lang"     => $lang,
				":start"    => $start,
				":each"     => $perPage
			]
		);

		foreach ($data as $item) {
			$item->thumbnail = Helper::image_uri($item->thumbnail);
		}

		return compact('count', 'pages', 'next', 'prev', 'page', 'from', 'to', 'data');
	}

	public function verifyProductStock(int $id, int $qty)
	{
		$table = DB::tables();
		$product = DB::selectOne(
			"SELECT p.ID as `id`, p.post_title as name, mt.data FROM $table->posts p LEFT JOIN ( 
				SELECT JSON_OBJECTAGG(SUBSTRING(meta_key, 2), meta_value) AS data , post_id FROM $table->postmeta WHERE meta_key IN ('_stock_status', '_stock', '_manage_stock') GROUP BY post_id
			) mt ON mt.post_id = p.ID WHERE p.ID = ?",
			[$id]
		);

		$product = (object) array_merge(
			(array) $product,
			(array) json_decode($product->data),
		);

		if ((int) $product->stock < (int) $qty) {
			return [
				'status' => false,
				'data'   => "Product '$product->name' out of stock. Available only $product->stock units"
			];
		}
		return [
			'status' => true
		];
	}

	public function verifyProductStockList(array $products)
	{
		$busy_products = "";
		foreach ($products as $product) {
			$_product = wc_get_product((int) $product['id']);
			if ($_product->get_stock_quantity() < intval($product['quantity'])) {
				$product_count = $_product->get_stock_quantity();
				$busy_products .= "Product {$_product->name} out of stock. Available only {$product_count} in stock \n ";
			}
		}
		if (strlen($busy_products) > 0) {
			return [
				"status"  => false,
				"data"    => $busy_products
			];
		}
		return [
			"status"  => true
		];
	}

	private function calc_pagination(int $total, int $page, int $perPage)
	{
		$totalPages = ceil((int) $total / $perPage);
		$startPage = ($page === 0 ? 1 : $page - 1) * $perPage;

		$nextPage = $page == $totalPages ? null : $page + 1;
		$prevPage = $page == 1 ? null : $page - 1;

		$from  = $startPage + 1;
		$to    = ($startPage + $perPage) > $total ? $total : ($startPage + $perPage);

		return [$totalPages, $total, $startPage, $nextPage, $prevPage, $from, $to];
	}
}