<?php

namespace Lotus\Modules\Service;

use Lotus\Shared\Helper;
use WP_REST_Request as Request;
use WP_REST_Response as Response;

final class ServiceController
{
	/**
	 * The service repository instance
	 * 
	 * @var \Lotus\Modules\Service\ServiceRepository
	 */
	private $repository;

	public function __construct(ServiceRepository $repository)
	{
		$this->repository = $repository;
	}

	/** 
	 * @method Return all services stored in database
	 */
	public function index(Request $request)
	{
		$category = (string) $request->get_param('category');
		$lang     = (string) $request->get_param('lang');
		$limit    = (int) $request->get_param('limit') ?? 0;

		try {
			$services = $this->repository->all($category, $lang, $limit);
			return new Response($services);
		} catch (\Exception $th) {
			return $th->getMessage();
		}
	}

	/**
	 * @method Return one service with aditional data
	 */
	public function find(Request $request)
	{
		$slug = (string) $request->get_param('slug');
		$lang = (string) $request->get_param('lang');
		$seo  = (string) $request->get_param('seo') ?? 'deny';

		try {
			$service = $this->repository->find($slug, $lang);
			if (false === $service) {
				return new Response(['status' => 'Service Not Found'], 404);
			}
			$service->meta_seo = Helper::meta_seo($service->id, 'post', $seo);
			return new Response($service, 200);
		} catch (\Exception $th) {
			return new Response([
				"status" 	=> "Internal Server Error",
				"code"	    => $th->getCode()
			], 500);
		}
	}

	public function get_category(Request $request)
	{
		$slug = (string) $request->get_param('slug');
		$type = (string) $request->get_param('type') ?? 'services';
		$lang = (string) $request->get_param('lang');
		$subcategory = (string) $request->get_param('subcategory');

		$category = $this->repository->findCategory($type, $slug, $lang, $subcategory);

		return new Response($category);
	}

	public function findServicesOnly(Request $request)
	{
		$lang = (string) $request->get_param('lang') ?: 'es';
		$services = $this->repository->findServicesOnly('es');
		return new Response($services);
	}

	public function pickServicesForSelect(Request $request)
	{
		$lang = (string) $request->get_param('lang') ?: 'es';
		$services = $this->repository->findServicesForSelect('es');
		return new Response($services);
	}
}