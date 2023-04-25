<?php

namespace Lotus\Modules\Bookly\Customer\Model;

use Lotus\Shared\Facade\DB;
use Lotus\Shared\Helper;

final class CustomerModel
{

	public function create(object $value)
	{
		return DB::insert(
			"INSERT INTO mv_customer(name, phone, email, address, note, paid) VALUES (?, ?, ?, ?, ?, ?)",
			[$value->name, $value->phone, $value->email, $value->address, $value->note, $value->paid]
		);
	}

	public function update(int $id, array $values)
	{
		$values = Helper::SQLUpdateEntity($values);
		return DB::update(
			"UPDATE `mv_customer` SET {$values} WHERE id = ?",
			[$id]
		) ? $id : false;
	}

	public function delete(int $id)
	{
		return DB::table('customer')->where('id', $id)->delete() ? $id : false;
	}

	public function find(int $id)
	{
		return DB::table('customer')
			->select('id', 'name', 'phone', 'address', 'note', 'paid')
			->where('id', '=', $id)
			->first();
	}

	public function all()
	{
		return DB::table('customer')->get();
	}
}
