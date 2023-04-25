<?php

namespace Lotus\Modules\Bookly\User;

use Lotus\Modules\Bookly\User\Model\UserModel;

final class UserRepository
{
	/**
	 * User model instance
	 * 
	 * @var \Lotus\Modules\Bookly\User\Model\UserModel
	 */
	private $user;

	/**
	 * User repository constructor
	 * 
	 * @param \Lotus\Modules\Bookly\User\Model\UserModel $user
	 */
	public function __construct(UserModel $user)
	{
		$this->user = $user;
	}
	public function create(object $doctor)
	{
		return $this->user->create([
			"first_name" => $doctor->first_name,
			"last_name"	 => $doctor->last_name,
			"gender"	 => $doctor->gender,
			"email"		 => $doctor->email,
			"avatar"	 => $doctor->avatar,
			"position"	 => $doctor->position,
			"time_start" => $doctor->time_start,
			"time_end"	 => $doctor->time_end
		]);
	}

	public function update(int $id, object $data)
	{
		return $this->user->update($id, [
			"first_name" => $data->first_name,
			"last_name"	 => $data->last_name,
			"gender"	 => $data->gender,
			"email"		 => $data->email,
			"avatar"	 => $data->avatar,
			"position"	 => $data->position,
			"time_start" => $data->time_start,
			"time_end"	 => $data->time_end
		]);
	}

	public function delete(int $id)
	{
		return $this->user->delete($id);
	}

	public function all()
	{
		return $this->user->all();
	}

	public function find(int $id)
	{
		return $this->user->find($id);
	}

	public function searchAvailables(string $date)
	{
		return $this->user->findAvailableByDate($date);
	}
}
