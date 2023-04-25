<?php

namespace Lotus\Modules\Bookly\Customer;

use WP_REST_Request as Request;
use WP_REST_Response as Response;

final class CustomerController
{
	private $repository;

	public function __construct(CustomerRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 ** @Route("/bookly/doctor")  methods={"GET"} 
	 */
	public function index(Request $request): Response
	{
		$customers = $this->repository->all();
		if (empty($customers)) {
			return new Response(["status" => "empty"]);
		}
		return new Response($customers);
	}

	/**
	 ** @Route("/bookly/doctor/create")  methods={"POST"} 
	 */
	public function create(Request $request): Response
	{
		$values = (object) $request->get_params();
		$files  = (object) json_decode(json_encode($request->get_file_params()));

		$destination = $this->uploadFileToStorage($files, $values);
		$values->avatar = $destination;
		$created = $this->repository->create($values);

		if (!$created) {
			return new Response(["created" => false]);
		}
		return new Response(["created" => true, 'data' => $created], 201);
	}

	/**
	 **  @Route("/bookly/doctor/update/<id>") methods={"PUT"} 
	 */
	public function update(Request $request): Response
	{
		$id = (int) $request->get_param('id');
		$values = (object) $request->get_params();
		$files  = (object) json_decode(json_encode($request->get_file_params()));
		$destination = $this->uploadFileToStorage($files, $values);
		$values->avatar = $destination;

		$updated = $this->repository->update($id, $values);

		if (!$updated) {
			return new Response(["updated" => false]);
		}
		return new Response(["updated" => true, 'data' => $updated]);
	}

	/**
	 **  @Route("/bookly/doctor/delete/=<id>") methods={"DELETE"} 
	 */
	public function delete(Request $request): Response
	{
		$id = (int) $request->get_param('id');
		$deleted = $this->repository->delete($id);
		if (!$deleted) {
			return new Response(["deleted" => false]);
		}
		return new Response(["deleted" => $deleted]);
	}

	/**
	 ** @Route("/bookly/doctor/find/<id>")  methods={"GET"} 
	 */
	public function find(Request $request): Response
	{
		$id = (int) $request->get_param('id');
		$doctor = $this->repository->find($id);

		if (empty($doctor)) {
			return new Response(["status" => "Doctor Not Found"], 204);
		}
		return new Response($doctor);
	}


	private function uploadFileToStorage(object $files, object $values)
	{
		$SHARED_DIR = get_option('siteurl') . '/wp-content/uploads/users/';
		$UPLOAD_DIR = ABSPATH . "/wp-content/uploads/users/";
		$destination = $SHARED_DIR . "default.svg";

		if (isset($files->avatar) && isset($files->avatar->name)) {
			$folder = $UPLOAD_DIR . $files->avatar->name;
			$shared_dir = $SHARED_DIR . $files->avatar->name;

			if (!$this->isImage($files->avatar->name)) {
				throw new \Exception("File extension not valid", 1);
			}

			if (move_uploaded_file($files->avatar->tmp_name, $folder)) {
				$destination = $shared_dir;
			} else throw new \Exception("File upload failed", 1);
		}

		return rtrim($destination, '/\\');
	}

	private function isImage(string $path)
	{
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		return in_array($ext, ["png", "svg", "jpg", "webp", "gif", "sgi", "tiff", "tif"]);
	}
}
