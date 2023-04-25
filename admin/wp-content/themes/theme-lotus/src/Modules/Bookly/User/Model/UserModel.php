<?php

namespace Lotus\Modules\Bookly\User\Model;

use DateTime;
use Lotus\Shared\Facade\DB;
use Lotus\Shared\Helper;

final class UserModel
{
	public function create(array $doctor)
	{
		$data = Helper::SQLInsertEntity($doctor);
		return DB::insert("INSERT INTO `mv_doctor` ({$data->keys}) VALUES ({$data->values})")
			? array_merge([
				'id' => DB::insertId(),
				'fullname' => "{$doctor['first_name']} {$doctor['last_name']}"
			], $doctor)
			: false;
	}

	public function update(int $id, array $doctor)
	{
		$values = Helper::SQLUpdateEntity($doctor);
		return DB::update("UPDATE `mv_doctor` SET {$values} WHERE id = ?", [$id])
			? array_merge([
				'id' => $id,
				'fullname' => "{$doctor['first_name']} {$doctor['last_name']}"
			], $doctor)
			: false;
	}

	public function delete(int $id)
	{
		return DB::table('doctor')->where('id', $id)->delete() ? $id : false;
	}

	public function all()
	{
		return DB::table('doctor')
			->select("*", "CONCAT(first_name, ' ', last_name) as fullname")
			->get();
	}

	public function find(int $id)
	{
		// return DB::table('doctor')
		// 	->select("*", "CONCAT(first_name, ' ', last_name) as fullname")
		// 	->where('id', '=', $id)
		// 	->first();

		return DB::selectOne("SELECT *, CONCAT(first_name, ' ', last_name) as fullname FROM mv_doctor WHERE id = ?", [$id]);
	}

	public function findAvailableByDate(string $date)
	{
		$time = (new DateTime($date))->format('i:s');
		return DB::select(
			"SELECT *, CONCAT(first_name, ' ', last_name) as fullname FROM `mv_doctor` WHERE id NOT IN (
				SELECT doctor FROM mv_schedule sh WHERE sh.from = ? 
			) AND TIME_FORMAT(time_start, '%i:%s') = ?",
			[$date, $time]
		) ?? [];
	}

	public static function isAvailableWithTime(int $id, object $time)
	{
		return DB::select(
			"SELECT d.id, sh.from, sh.to FROM `mv_doctor` d INNER JOIN `mv_schedule` sh ON sh.doctor = d.id WHERE d.id = ? AND sh.from = ?",
			[$id, $time->from]
		);
	}
}
