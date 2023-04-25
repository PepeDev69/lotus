<?php
namespace Lotus\Modules\Bookly\User;

final class User 
{
	/**
	 * The entity id
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $first_name;

	/**
	 * @var string
	 */
	public $last_name;

	/**
	 * @var string
	 */
	public $gender;

	/**
	 * @var string
	 */
	public $email;

	/**
	 * @var string
	 */
	public $avatar;

	/**
	 * @var string
	 */
	public $position;

	/**
	 * @var string
	 */
	public $time_start;

	/**
	 * @var string
	 */
	public $time_end;

	/**
	 * Verify entity is consistent
	 * @return bool
	 */
	public function isConsistent() 
	{
		return !empty($this->first_name) && 
			!empty($this->last_name) && 
			!empty($this->gender) && 
			!empty($this->email) && 
			!empty($this->avatar) && 
			!empty($this->position) && 
			!empty($this->time_start) && 
			!empty($this->time_end);
	}
}