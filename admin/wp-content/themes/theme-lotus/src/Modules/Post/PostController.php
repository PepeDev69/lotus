<?php

namespace Lotus\Modules\Post;

use Lotus\Shared\Exception\BadRequestException;
use Lotus\Shared\Helper;
use WP_REST_Response as Response;
use WP_REST_Request as Request;

final class PostController
{
	/**
	 * @var \Lotus\Modules\Post\PostRepository
	 */
	private $repository;

	public function __construct(PostRepository $repository)
	{
		$this->repository = $repository;
	}

	public function get_page(Request $request)
	{
		$template = (string) $request['template'];
		$lang     = (string) $request['lang'];
		$seo      = (string) $request['seo'] ?? 'deny';
		try {
			if (is_null($lang) || is_null($template)) {
				throw new BadRequestException();
			}

			$post = $this->repository->get_page($template, $lang);
			$post->meta_seo = Helper::meta_seo($post->id, 'post', $seo);
			if (isset($post->contact_form)) {
				$post->form = $this->repository->get_form($post->contact_form->ID);
				unset($post->contact_form);
			}
			return new Response($post, 200);
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"message" => $th->getMessage()
			], 500);
		}
	}

	// ==========  Get Post By Slug  ================

	public function get_post(Request $request)
	{
		$slug = (string) $request['slug'];
		$type = (string) $request['type'];
		$lang = (string) $request['lang'];
		$seo  = (string) $request['seo'] ?? 'deny';

		try {
			if (is_null($lang) && is_null($slug)  || is_null($type)) {
				throw new BadRequestException();
			}

			$post = $this->repository->get_post($type, $slug, $lang);

			if (!empty($post))
				$post->meta_seo = Helper::meta_seo($post->id, 'post', $seo);

			return new Response($post, 200);
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"message" => $th->getMessage()
			], 500);
		}
	}

	// ==========  Get posts by post_type =========

	public function get_posts(Request $request)
	{
		$type = (string) $request['type'] ?? 'post';
		$lang = (string) $request['lang'];
		try {

			if (is_null($type) || is_null($lang)) {
				return new Response([
					"status"  => "404 Not Found",
					"message" => "Type and lang parameters are needed, none were received"
				], 404);
			}

			$posts_collection = $this->repository->get_posts($type, $lang);

			return new Response($posts_collection, 200);
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"message" => $th->getMessage()
			], 500);
		}
	}

	public function get_post_tech(Request $request)
	{
		$lang = (string) $request['lang'];
		try {

			$post = $this->repository->get_post_tech($lang);
			return new Response($post, 200);
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"message" => $th->getMessage()
			], 500);
		}
	}

	// === Get common post used in all pages 

	public function get_common_post(Request $request)
	{
		$params = (object) $request->get_params();
		global $locales_code;
		try {

			if (!isset($params->lang)) {
				$response = $this->repository->get_common_post('option');
			}

			if (in_array($params->lang, (array) $locales_code)) {
				$response = $this->repository->get_common_post("option-{$params->lang}");
				$response->menu = $this->repository->get_menu($params->lang);
			}

			if (isset($response->form_contact)) {
				$response->form = $this->repository->get_form($response->form_contact->ID ?? 0);
				unset($response->form_contact);
			}
			return new Response($response, 200);
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"message" => $th->getMessage()
			]);
		}
	}

	public function get_site_meta()
	{
		try {
			$response = $this->repository->find_site_meta();
			return new Response($response, 200);
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"message" => $th->getMessage()
			]);
		}
	}

	public function get_terms(Request $request)
	{
		$params = (object) $request->get_params();
		try {

			$LIMIT = is_numeric($params->limit) ? (int) $params->limit : 0;
			$response = $this->repository->find_term($params->category, $params->lang, $LIMIT);
			return $response;
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"message" => $th->getMessage()
			]);
		}
	}

	public function get_first_category(Request $request)
	{
		$slug = (string) $request['slug'];
		$lang = (string) $request['lang'];
		try {
			$response = $this->repository->find_first_category($slug, $lang);

			return $response;
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"message" => $th->getMessage()
			]);
		}
	}

	public function get_subcategories(Request $request)
	{
		$parent = $request['parent'] ?: 'services';
		$lang   = $request['lang'] ?: 'es';

		$childrens = $this->repository->find_subcategories($parent, $lang);

		return $childrens;
	}

	public function get_menu()
	{
		return $this->repository->get_menu('es');
	}
}