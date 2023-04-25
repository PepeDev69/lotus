<?php

namespace Lotus\Modules\Bookly\Schedule;

use DateTime;
use Lotus\Shared\Providers\DateManager;

use Lotus\Modules\Bookly\Schedule\Models\ScheduleModel;
use Lotus\Modules\Bookly\User\Model\UserModel;
use Lotus\Shared\Facade\DB;

final class ScheduleRepository
{
	/**
	 * Data manager instance
	 * @var \Lotus\Shared\Providers\DateManager
	 */
	protected $dateManager;

	/**
	 * Schedule model instance
	 * @var \Lotus\Modules\Bookly\Schedule\Models\ScheduleModel
	 */
	protected $schedule;

	/**
	 * @param \Lotus\Shared\Providers\DateManager $dateManager 
	 * @param \Lotus\Modules\Bookly\Schedule\Models\ScheduleModel $schedule 
	 */
	public function __construct(DateManager $dateManager, ScheduleModel $schedule)
	{
		$this->dateManager = $dateManager;
		$this->schedule    = $schedule;
	}

	public function create(object $date, int $doctor, int $service, object $customer)
	{
		if ($this->scheduleValidator($doctor, $date) !== true) {
			return DateManager::DATE_OUT_OF_RANGE;
		}

		$customerInternal = json_encode([
			'name'    => $customer->name,
			'phone'   => $customer->phone,
			'email'   => $customer->email,
			'note'    => $customer->note,
			'paid'    => $customer->paid,
			'address' => $customer->address
		]);


		return DB::selectOne("CALL sp_create_schedule(:user, :customer, :service, :date)", [
			':user' 	=> (int) $doctor,
			':service'	=> (int) $service,
			':customer' => $customerInternal,
			':date'		=> json_encode($date)
		]);
	}


	public function update(int $id, object $date, int $doctor, int $service, object $customer)
	{
		if ($this->validUpdateTime($doctor, $date) !== true) {
			return DateManager::DATE_OUT_OF_RANGE;
		}

		$customerInternal = json_encode([
			'id'	  => $customer->id,
			'name'    => $customer->name,
			'phone'   => $customer->phone,
			'email'   => $customer->email,
			'note'    => $customer->note,
			'paid'    => $customer->paid,
			'address' => $customer->address
		]);

		return DB::selectOne("CALL sp_update_schedule(:id, :user, :customer, :service, :date)", [
			':id'		=> (int) $id,
			':user' 	=> (int) $doctor,
			':service'	=> (int) $service,
			':customer' => $customerInternal,
			':date'		=> json_encode($date)
		]);
	}

	public function delete(int $id)
	{
		return DB::table('schedule')->where('id', $id)->delete();
	}

	public function find(int $id)
	{
		return $this->schedule->find($id);
	}

	public function findOneDay(string $date)
	{
		return $this->schedule->findOneDay($date);
	}

	public function findByDoctor(int $id)
	{
		return $this->schedule->findByDoctor($id);
	}

	public function findCompleteDay(string $day)
	{
		$ranges    = $this->dateManager->genRange();
		$schedules = $this->schedule->findOneDay($day);
		$responses = [];

		foreach ((array) $ranges as $range) {
			$responses[$range] = [];
			foreach ((array) $schedules as $schedule) {
				if ((new DateTime($schedule->from))->format('H:i:s') == $range) {
					$responses[$range][] = (array) $schedule;
				}
			}
		}
		return [$responses, count((array) $schedules)];
	}

	public function searchAvailableBy(string $type, array $values)
	{
		return [$type, $values];
	}

	public function findAll()
	{
		return $this->schedule->all();
	}

	private function scheduleValidator(int $doctor, object $date)
	{
		if (!$this->dateManager->isValidDiffTime($date->from)) {
			return 'Fecha fuera de rango';
		}

		if (!$this->dateManager->isValidStartTime($date->from)) {
			return 'Espacio de hora fuera de rango';
		}

		if (!$this->dateManager->isValidEndTime($date->to)) {
			return 'Espacio de hora fuera de rango';
		}

		if (UserModel::isAvailableWithTime($doctor, $date)) {
			return "$date->from El especialista no esta disponible esa fecha";
		}
		return true;
	}

	private function validUpdateTime($doctor, object $date)
	{
		if (!$this->dateManager->isValidUpdatedTime($date->from)) {
			return 'Fecha fuera de rango';
		}

		if (!$this->dateManager->isValidStartTime($date->from)) {
			return 'Espacio de hora fuera de rango';
		}

		if (!$this->dateManager->isValidEndTime($date->to)) {
			return 'Espacio de hora fuera de rango';
		}

		if (UserModel::isAvailableWithTime($doctor, $date)) {
			return "$date->from El especialista no esta disponible esa fecha";
		}
		return true;
	}
}
