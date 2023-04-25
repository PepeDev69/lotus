<?php

namespace Lotus\Modules\Product;

use Lotus\Shared\Helper;
use WP_REST_Request as Request;
use WP_REST_Response as Response;

final class ProductController
{
	/**
	 * @var \Lotus\Modules\Product\ProductRepository
	 */
	private $repository;

	/**
	 * @param \Lotus\Modules\Product\ProductRepository $repository
	 */
	public function __construct(ProductRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index(Request $request)
	{
		$category = (string) $request->get_param('category');
		$lang     = (string) $request->get_param('lang');
		$limit    = (int) $request->get_param('limit') ?? 0;
		try {
			$products = $this->repository->all($category, $limit, $lang);
			return $products;
		} catch (\Exception $th) {
			return $th->getMessage();
		}
	}

	public function find(Request $request)
	{
		$params = (object) $request->get_params();
		try {
			if (!isset($params->lang) || !isset($params->slug)) {
				return ["Not found"];
			}
			$product = $this->repository->find($params->slug, $params->lang);
			if (!empty($product))
				$product->meta_seo = Helper::meta_seo($product->id, 'post', $params->seo);
			return new Response($product, 200);
		} catch (\Exception $th) {
			return new Response([
				"status" 	=> "Internal Server Error",
				"message"	=> $th->getMessage()
			], 500);
		}
	}

	public function verifyProduct(Request $request)
	{
		$id  = (int) $request->get_param('id');
		$qty = (int) $request->get_param('qty');
		try {
			$response = $this->repository->verifyProductStock($id, $qty);
			return $response;
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function paginateProduct($request)
	{
		$cat  = (string) $request->get_param('category');
		$type = (string) $request->get_param('type') ?? 'products';
		$lang = (string) $request->get_param('lang');
		$step = (int) $request->get_param('step') ?: 5;
		$page = (int) $request->get_param('page');

		$product = $this->repository->paginate($type, $cat, $lang, $page, $step);
		return new Response($product);
	}
}
