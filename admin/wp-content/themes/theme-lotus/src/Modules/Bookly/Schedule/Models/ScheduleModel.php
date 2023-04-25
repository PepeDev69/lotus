<?php

namespace Lotus\Modules\Bookly\Schedule\Models;

use Lotus\Shared\Facade\DB;
use Lotus\Shared\Helper;

final class ScheduleModel
{
	public function create(int $doctor_id, int $customer_id, int $service_id, object $date)
	{
		return DB::insert(
			"INSERT INTO mv_schedule (`from`, `to`, `doctor`, `customer`, `service`) VALUES (?, ?, ?, ?, ?)",
			[$date->from, $date->to, $doctor_id, $customer_id, $service_id]
		);
	}

	public function update(int $id, array $update)
	{
		$values = Helper::SQLUpdateEntity($update);
		return DB::update(
			"UPDATE `mv_schedule` SET {$values} WHERE id = ?",
			[$id]
		);
	}

	public function delete(int $id)
	{
		return DB::table('schedule')->where('id', $id)->delete();
	}

	public function find(int $id)
	{
		return $this->findSchedule("where sh.id = ?", [$id], true);
	}

	public function findOneDay(string $date)
	{
		return $this->findSchedule(
			"where date(sh.from) = ? order by sh.created_at DESC",
			[$date]
		);
	}

	public function findByDoctor(int $id)
	{
		return $this->findSchedule(
			"where sh.doctor = :id order by sh.created_at DESC",
			[':id' => $id]
		);
	}

	public function all()
	{
		return $this->findSchedule();
	}

	private function findSchedule(string $query = '', array $params = [], bool $only = false)
	{
		$rawSchedules = DB::queryBuilder(
			"SELECT sh.id, sh.from, sh.to, sh.created_at, dt.doctor, ct.customer, sr.service FROM mv_schedule sh
				LEFT JOIN (
					SELECT id, JSON_OBJECT('id', id, 'name', CONCAT(first_name, ' ', last_name), 'email', email, 'avatar', avatar) AS doctor FROM mv_doctor GROUP BY 1
				) dt ON dt.id = sh.doctor
				LEFT JOIN (
					SELECT id, JSON_OBJECT('id', id, 'name', name, 'phone', phone, 'email', email, 'address', `address`, 'note', note, 'paid', paid, 'created', created_at) AS customer FROM mv_customer GROUP BY 1
				) ct ON ct.id = sh.customer
				LEFT JOIN (
					SELECT ID AS id, JSON_OBJECT('id', ID, 'name', post_title, 'price', CONVERT(mt.meta_value, signed INTEGER)) AS `service` FROM lotus_wp_posts p
						LEFT JOIN lotus_wp_postmeta mt ON mt.post_id = p.ID AND mt.meta_key = '_price' 
					WHERE p.post_type = 'product' AND p.post_status = 'publish'
				) sr ON sr.id = sh.service"
		)->merge($query, $params, $only);

		if (!is_array($rawSchedules)) {
			$rawSchedules->doctor   = json_decode($rawSchedules->doctor);
			$rawSchedules->customer = json_decode($rawSchedules->customer);
			$rawSchedules->service  = json_decode($rawSchedules->service);
			return $rawSchedules;
		}

		foreach ($rawSchedules as $key => $schedule) {
			$schedules[] = $schedule;
			$schedules[$key]->doctor   = json_decode($schedule->doctor);
			$schedules[$key]->customer = json_decode($schedule->customer);
			$schedules[$key]->service  = json_decode($schedule->service);
		}

		return $schedules;
	}
}
