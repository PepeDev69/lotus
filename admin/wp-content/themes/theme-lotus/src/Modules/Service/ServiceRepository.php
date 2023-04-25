<?php


namespace Lotus\Modules\Service;

use Lotus\Shared\Facade\DB;
use Lotus\Shared\Helper;

final class ServiceRepository
{
	public function find(string $slug, string $lang)
	{
		$service = DB::selectOne(
			"SELECT p.ID id, p.post_title name, p.post_name slug, p.post_content content, mt.meta, (select `guid` from lotus_wp_posts where ID = ptc.meta_value) picture, json_arrayagg(x.guid) gallery FROM lotus_wp_posts p 
				LEFT JOIN lotus_wp_postmeta pt ON pt.post_id = p.ID AND pt.meta_key = 'post_lang'
				LEFT JOIN lotus_wp_postmeta ptr on ptr.post_id = p.ID and ptr.meta_key = '_product_image_gallery'
				LEFT JOIN (SELECT guid, ID FROM lotus_wp_posts GROUP BY ID) x ON find_in_set(x.ID, ptr.meta_value)
				LEFT JOIN lotus_wp_postmeta ptc ON ptc.post_id = p.ID AND ptc.meta_key = '_thumbnail_id'
				LEFT JOIN ( 
					SELECT met.post_id, JSON_OBJECTAGG(SUBSTRING(met.meta_key, 2) , met.meta_value) meta FROM lotus_wp_postmeta met WHERE met.meta_key 
					IN ('_regular_price', '_sale_price', '_product_image_gallery', '_thumbnail_id', '_price', '_partial_price') GROUP BY 1
				) mt 
			ON mt.post_id = p.ID WHERE p.post_name = :slug AND pt.meta_value = :lang GROUP BY 1,2,3,4,5,6",
			[
				":slug" => $slug,
				":lang" => $lang
			]
		);

		if (empty($service)) return false;

		$service->gallery = array_map(function ($item) {
			return Helper::image_uri($item);
		}, json_decode($service->gallery));

		$service->content = Helper::autowrap($service->content);
		$service->picture = Helper::image_uri($service->picture);
		$service_meta     = $service->meta;

		$response = (object) array_merge(
			(array) Helper::except($service, ['meta']),
			(array) json_decode($service_meta),
			(array) get_fields($service->id)
		);

		return $response;
	}

	public function all(string $category, string $lang, int $limit)
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

		$services = DB::select(
			"SELECT p.ID as id, p.post_title as name, pmt.meta_value as price, p.post_name as slug, p.post_date as `date`, (select guid from lotus_wp_posts where ID = pt.meta_value) picture FROM lotus_wp_posts p 
				LEFT JOIN lotus_wp_postmeta pmt ON pmt.post_id = p.ID AND pmt.meta_key = '_regular_price' 
				left join lotus_wp_postmeta pt on pt.post_id = p.ID and pt.meta_key = '_thumbnail_id'
			WHERE p.ID IN (
				SELECT object_id FROM lotus_wp_term_relationships WHERE term_taxonomy_id in (
					SELECT tr.term_id FROM lotus_wp_terms tr 
						INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 AND tx.parent != 0
						LEFT JOIN lotus_wp_terms trs ON trs.term_id = tx.parent
						LEFT JOIN lotus_wp_termmeta tm ON tm.term_id = tr.term_id AND tm.meta_key = '__term_lang' 
					WHERE trs.slug = 'services' $categoryQuery AND tm.meta_value = :lang
				)
			) AND p.post_status = 'publish' AND p.post_type = 'product' ORDER BY p.menu_order $limitedQuery",
			$parameters
		);

		foreach ($services as $key => $service) {
			$service->picture = Helper::image_uri($service->picture);
		}

		return $services;
	}

	// !disable current category with `where not tr.slug  = :slug_omit`
	public function findCategory(string $parent, string $slug, ?string $lang, ?string $subcategory)

	{
		$term;

		if ($subcategory === 'true') {
			$term = DB::selectOne(
				"SELECT tr.term_id, tr.name, tr.slug, tx.description, tx.taxonomy, tx.count, (select guid from lotus_wp_posts where ID = th.meta_value) thumbnail, meta.siblings FROM lotus_wp_terms tr 
					INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 AND tx.parent != 0
					LEFT JOIN lotus_wp_termmeta tm ON tm.term_id = tr.term_id and tm.meta_key = '__term_lang'
					LEFT JOIN lotus_wp_termmeta th ON th.term_id = tr.term_id AND th.meta_key = 'thumbnail_id'
					JOIN (
						SELECT JSON_ARRAYAGG(JSON_OBJECT('id', tr.term_id, 'name', tr.name, 'slug', tr.slug, 'count', tx.count)) as siblings from lotus_wp_terms tr 
						join lotus_wp_term_taxonomy tx on tx.term_id = tr.term_id where tx.parent = (
						select tx.parent from lotus_wp_terms lwt
							join lotus_wp_term_taxonomy tx on tx.term_id = lwt.term_id and tx.taxonomy = 'product_cat'
							left join lotus_wp_termmeta meta on meta.term_id = lwt.term_id and meta.meta_key = '__term_lang'
						where lwt.slug = :slug and meta.meta_value = :lang
							) 
					) meta
				WHERE tm.meta_value = :lang2 AND tr.slug = :slug2",
				[
					":slug"    => $slug,
					":lang"    => $lang,
					":lang2"    => $lang,
					":slug2"    => $slug,
				]
			);
		} else {
			$term = DB::selectOne(
				"SELECT tr.term_id, tr.name, tr.slug, tx.description, tx.taxonomy, tx.count, (select guid from lotus_wp_posts where ID = th.meta_value) thumbnail, meta.siblings FROM lotus_wp_terms tr 
				INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 AND tx.parent != 0
				LEFT JOIN lotus_wp_termmeta tm ON tm.term_id = tr.term_id and tm.meta_key = '__term_lang'
				LEFT JOIN lotus_wp_termmeta th ON th.term_id = tr.term_id AND th.meta_key = 'thumbnail_id'
				JOIN (
					SELECT JSON_ARRAYAGG(JSON_OBJECT('id', tr.term_id, 'name', tr.name, 'slug', tr.slug, 'count', tx.count)) as siblings from lotus_wp_terms tr 
						inner join lotus_wp_term_taxonomy tx on tr.term_id  = tx.term_id and tx.taxonomy = 'product_cat' and tx.parent = (
							select tr.term_id from lotus_wp_terms tr left join lotus_wp_termmeta mt on tr.term_id = mt.term_id and meta_key = '__term_lang'
							where slug = :parent and mt.meta_value = :lg_omit 
						) 
				) meta
				WHERE tm.meta_value = :lang AND tr.slug = :slug",
				[
					":parent"  => $parent,
					":slug"    => $slug,
					":lang"    => $lang,
					":lg_omit" => $lang
				]
			);
		}

		$response = (object) array_merge(
			(array) get_fields("{$term->taxonomy}_{$term->term_id}"),
			(array) $term
		);
		$response->siblings  = json_decode($term->siblings);

		return $response;
	}

	public function findServicesOnly(string $lang)
	{
		$services = DB::select(
			"SELECT p.ID as id, p.post_title as name, pmt.meta_value as price, pr.meta_value as `partial`, p.post_name as slug, p.post_date as `date`, (select guid from lotus_wp_posts where ID = pt.meta_value) picture FROM lotus_wp_posts p 
				LEFT JOIN lotus_wp_postmeta pmt ON pmt.post_id = p.ID AND pmt.meta_key = '_regular_price' 
				LEFT JOIN lotus_wp_postmeta pr ON pr.post_id = p.ID AND pr.meta_key = '_partial_price'
				left join lotus_wp_postmeta pt on pt.post_id = p.ID and pt.meta_key = '_thumbnail_id'
			WHERE p.ID IN (
				SELECT object_id FROM lotus_wp_term_relationships WHERE term_taxonomy_id in (
					SELECT tr.term_id FROM lotus_wp_terms tr 
						INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 AND tx.parent != 0
						LEFT JOIN lotus_wp_terms trs ON trs.term_id = tx.parent
						LEFT JOIN lotus_wp_termmeta tm ON tm.term_id = tr.term_id AND tm.meta_key = '__term_lang' 
					WHERE trs.slug = 'services' AND tm.meta_value = 'es'
				)
			) AND p.post_status = 'publish' AND p.post_type = 'product' ORDER BY p.menu_order"
		);

		foreach ($services as $key => $service) {
			$service->picture = Helper::image_uri($service->picture);
		}

		return $services;
	}

	public function findServicesForSelect(string $lang)
	{
		return DB::select(
			"SELECT p.ID as id, p.post_title as label FROM lotus_wp_posts p WHERE p.ID IN (
				SELECT object_id FROM lotus_wp_term_relationships WHERE term_taxonomy_id in (
					SELECT tr.term_id FROM lotus_wp_terms tr 
						INNER JOIN lotus_wp_term_taxonomy tx ON tx.term_id = tr.term_id AND tx.taxonomy = 'product_cat' AND tx.count > 0 AND tx.parent != 0
						LEFT JOIN lotus_wp_terms trs ON trs.term_id = tx.parent
						LEFT JOIN lotus_wp_termmeta tm ON tm.term_id = tr.term_id AND tm.meta_key = '__term_lang' 
					WHERE trs.slug = 'services' AND tm.meta_value = 'es'
				)
			) AND p.post_status = 'publish' AND p.post_type = 'product' ORDER BY p.menu_order"
		);
	}
}
