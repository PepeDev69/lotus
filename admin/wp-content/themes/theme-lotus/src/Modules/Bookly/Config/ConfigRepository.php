<?php

namespace Lotus\Modules\Bookly\Config;

use Lotus\Shared\Providers\DateManager;

final class ConfigRepository
{
	private const TIME_ZONES = [
		'UTC-10' => ['Hawaii Standard Time'],
		'UTC-9'  => ['Hawaii-Aleutian Daylight Time'],
		'UTC-8'  => ['Alaska Daylight Time'],
		'UTC-7'  => ['Pacific Daylight Time', 'Mountain Standard Time'],
		'UTC-6'  => ['Mountain Daylight Time'],
		'UTC-5'  => ['Central Daylight Time'],
		'UTC-4'  => ['Eastern Daylight Time']
	];

	private const TIME_SPACE = [
		'from' => '08:00:00',
		'to'   => '19:00:00'
	];

	private const LUNCH_TIME = '13:00:00';

	/**
	 * @var \Lotus\Shared\Providers\DateManager
	 */
	private $dateManager;

	public function __construct(DateManager $dateManager)
	{
		$this->dateManager = $dateManager;
	}
	public function find()
	{
		return [
			'time_zone'  => self::TIME_ZONES['UTC-7'],
			'time_space' => self::TIME_SPACE,
			'lunch_time' => self::LUNCH_TIME,
			'date_range' => $this->dateManager->genRangeOptional()
		];
	}

	public function create()
	{
		// TODO
	}

	public function update()
	{
		// TODO
	}
}
