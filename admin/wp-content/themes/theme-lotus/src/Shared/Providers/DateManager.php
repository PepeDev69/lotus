<?php

namespace Lotus\Shared\Providers;

use DateTime;
use Lotus\Shared\Facade\DB;

final class DateManager
{
	private $startTime = '08:00:00';
	private $endTime   = '19:00:00';
	private $timeSpace = '+ 30 minutes';

	public const DATE_OUT_OF_RANGE = 'DATE_OUT_OF_RANGE';

	public function __construct()
	{
		date_default_timezone_set('America/Los_Angeles');
	}

	public function setTimezone(string $time_zone)
	{
		date_default_timezone_set($time_zone);
	}

	public function validate(string $date, string $format = 'Y-m-d')
	{
		$data = DateTime::createFromFormat($format, $date);
		return $data && $data->format($format) === $date;
	}

	public function isValidStartTime($date)
	{
		$from = new DateTime($date);
		return $from->format('H:i') >= $this->startTime('H:i') && $from->format('H:i') < $this->endTime('H:i');
	}

	public function isValidEndTime($date)
	{
		$to = new DateTime($date);
		return $to->format('H:i') > $this->startTime('H:i') && $to->format('H:i') <= $this->endTime('H:i');
	}

	// valid if time out of attention time
	public function isValidDiffTime($date)
	{
		$today = new DateTime();
		$from  = new DateTime($date);
		$diff = $today->diff($from);

		return ($diff->days >= 1 || $diff->h >= 8) && $diff->invert === 0;
	}

	public function isValidUpdatedTime($date)
	{
		$today = new DateTime();
		$from  = new DateTime($date);

		return $today->diff($from)->invert === 0;
	}

	public function genRange()
	{
		$data = [];
		$current = new DateTime($this->startTime);
		while ($current <= new DateTime($this->endTime)) {
			array_push($data, $current->format('H:i:s'));
			$current = $current->modify($this->timeSpace);
		}
		return $data;
	}

	public function genRangeOptional()
	{
		$SCHEDULE = [];
		$current = new DateTime($this->startTime);
		$ending  = (new DateTime($this->startTime))->modify($this->timeSpace);

		while ($current < new DateTime($this->endTime)) {
			array_push($SCHEDULE, (object)[
				'value' => "{$current->format('H:i:s')}|{$ending->format('H:i:s')}",
				'label'  => "{$current->format('h:i A')} - {$ending->format('h:i A')}"
			]);
			$current = $current->modify($this->timeSpace);
			$ending  = $ending->modify($this->timeSpace);
		}

		return $SCHEDULE;
	}

	public function genRangeWith(string $date)
	{
		$SCHEDULE = ["AM" => [], "PM" => []];
		$current = new DateTime($this->startTime);
		$ending  = (new DateTime($this->startTime))->modify($this->timeSpace);

		$busy = DB::select(
			"SELECT sh.id, sh.from, sh.to, COUNT(*) as count FROM mv_schedule sh where date(sh.from) = ? and TIME_FORMAT(sh.from, '%i:%s') = '30:00' GROUP BY 1, 2, 3
				HAVING COUNT(*) >= (SELECT COUNT(*) FROM mv_doctor where TIME_FORMAT(time_start, '%i:%s') = '30:00')
			UNION 
			SELECT sh.id, sh.from, sh.to, COUNT(*) as count FROM mv_schedule sh where date(sh.from) = ? and TIME_FORMAT(sh.from, '%i:%s') = '00:00' GROUP BY 1, 2, 3 
				HAVING COUNT(*) >= (SELECT COUNT(*) FROM mv_doctor where TIME_FORMAT(time_start, '%i:%s') = '00:00')
			ORDER BY 2",
			[$date, $date]
		);

		while ($current < new DateTime($this->endTime)) {
			$timeModel = (object)[
				'value' => "{$current->format('H:i:s')}|{$ending->format('H:i:s')}",
				'time'  => "{$current->format('H:i')} {$ending->format('H:i')}",
				'busy'  => false
			];

			foreach ($busy as $bus) {
				if ((new DateTime($bus->from))->format('H:i:s') === $current->format('H:i:s')) {
					$timeModel->busy = true;
				}
			}

			if ($current->format('H') < 12) {
				array_push($SCHEDULE['AM'], $timeModel);
			} else {
				array_push($SCHEDULE['PM'], $timeModel);
			}

			$current = $current->modify($this->timeSpace);
			$ending  = $ending->modify($this->timeSpace);
		}
		return $SCHEDULE;
	}

	private function startTime(string $format = 'H:i:s')
	{
		return date($format, strtotime($this->startTime));
	}

	private function endTime(string $format = 'H:i:s')
	{
		return date($format, strtotime($this->endTime));
	}
}
