<?php

namespace Lotus\Modules\Bookly\Schedule;

use Lotus\Shared\Http;
use Lotus\Shared\Providers\DateManager;
use Lotus\Shared\Providers\MailManager;

use WP_REST_Request as Request;
use WP_REST_Response as Response;

final class ScheduleController
{
	/**
	 * Schedule repository instance
	 * @var \Lotus\Modules\Bookly\Schedule\ScheduleRepository
	 */
	private $repository;

	/**
	 * Date Manager instance
	 * @var \Lotus\Shared\Providers\DateManager
	 */
	private $dateManager;

	/**
	 * Date Manager instance
	 * @var \Lotus\Shared\Providers\MailManager
	 */
	private $mailManager;

	public function __construct(ScheduleRepository $repository, DateManager $dateManager, MailManager $mailManager)
	{
		$this->repository  = $repository;
		$this->dateManager = $dateManager;
		$this->mailManager = $mailManager;
	}

	/**
	 **  @Route("/bookly/date") methods={"POST"} 
	 */
	public function index(): Response
	{
		$schedules = $this->repository->findAll();
		return new Response($schedules);
	}

	/**
	 * * @Route("/bookly/date/create") methods={"POST"} 
	 */
	public function create($request): Response
	{
		$date = (object) [
			"from" => $request->get_param('from'),
			"to"   => $request->get_param('to')
		];
		$doctor   = (int) $request->get_param('doctor');
		$service  = (int) $request->get_param('service');
		$customer = (object) $request->get_param('customer');

		$created = $this->repository->create($date, $doctor, $service, $customer);

		if ($created === DateManager::DATE_OUT_OF_RANGE) {
			return new Response(['created' => false, 'data' => 'El especialista o fecha estan fuera de rango']);
		}
		$this->mailManager->send();
		return new Response(['created' => true, 'data' => $created]);
	}

	/**
	 * * @Route("/bookly/date/update/<id>") methods={"PUT"} 
	 */
	public function update($request): Response
	{
		$id   = (int) $request->get_param('id');
		$date = (object) [
			"from" => $request->get_param('from'),
			"to"   => $request->get_param('to')
		];
		$doctor   = (int) $request->get_param('doctor');
		$service  = (int) $request->get_param('service');
		$customer = (object) $request->get_param('customer');

		$updated = $this->repository->update($id, $date, $doctor, $service, $customer);

		if ($updated === DateManager::DATE_OUT_OF_RANGE) {
			return new Response(['updated' => false, 'data' => 'El especialista o fecha estan fuera de rango']);
		}
		return new Response(['updated' => true, 'data' => $updated]);
	}

	/**
	 * * @Route("/bookly/date/delete") methods={"DELETE"} 
	 */
	public function delete($request): Response
	{
		$id = (int) $request->get_param('id');
		$delete = $this->repository->delete($id);

		if ($delete === false) {
			return new Response(["deleted" => false]);
		}
		return new Response(["deleted" => true]);
	}

	/**
	 * * @Route("/bookly/date/find/<id>") methods={"GET"} 
	 */
	public function find($request): Response
	{
		$id = (int) $request->get_param('id');
		$schedule = $this->repository->find($id);
		if (empty($schedule)) {
			return new Response(['status' => 'Schedule Not Found']);
		}
		return new Response($schedule);
	}

	/**
	 * * @Route("/bookly/date/today") methods={"GET"} 
	 */
	public function findScheduleByDate($request): Response
	{
		$date = (string) $request->get_param('date');

		if (!$this->dateManager->validate($date)) {
			return new Response(["message" => "invalid Date"], Http::HTTP_BAD_REQUEST);
		}

		list($schedules, $count) = $this->repository->findCompleteDay($date);

		$response = (object) [
			"date" 	=> $date,
			"count" => $count,
			"schedules" => $schedules
		];
		return new Response($response);
	}

	public function findScheduleByDoctor(Request $request)
	{
		$doctor = (int) $request->get_param('doctor');
		$schedules = $this->repository->findByDoctor($doctor);

		return new Response($schedules);
	}

	public function searchAvailableByDate($request)
	{
		$date = (string) urldecode($request->get_param('date'));
		$response = $this->repository->searchAvailableBy('date', ["value" => $date]);
		return new Response($response);
	}

	public function dateRange($request)
	{
		$date = (string) $request->get_param('date');
		$dates = $this->dateManager->genRangeWith($date);
		return new Response($dates);
	}
}
