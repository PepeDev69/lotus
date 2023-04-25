<?php

namespace Bookly\Providers;

use Twilio\Rest\Client;

final class TwilioSMSManager
{
	/**
	 * @var \Twilio\Rest\Client 
	 */
	private $client;

	public function __construct()
	{
		$this->client = new Client(env('TWILIO_ACOUNT_ID'), env('TWILIO_AUTH_TOKEN'));
		date_default_timezone_set('America/Los_Angeles');
	}

	public function send()
	{
		$meta = DB::selectOne(
			"SELECT substr(option_name, 1, 6) `key`, JSON_OBJECTAGG(replace(option_name, 'options_', ''), option_value) meta FROM lotus_wp_options 
				WHERE option_name IN ('options_phone', 'options_address') GROUP BY 1"
		);

		$meta = json_decode($meta->meta);

		$date_from = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+ 20 hour'));
		$date_to   = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+ 21 hour'));		

	
		$all_users = DB::select(
			"SELECT ms.id, ms.`from`, ms.`to`, ct.name, ct.phone, ct.email, ps.post_title `service`, concat(doc.first_name, ' ', doc.last_name) doctor FROM mv_schedule ms 
				INNER JOIN mv_customer ct on ct.id = ms.customer 
				INNER JOIN mv_doctor doc on doc.id = ms.doctor
				LEFT JOIN lotus_wp_posts ps on ps.ID = ms.service
			ORDER BY ms.`from`"
		);

		//DB::delete('DELETE FROM mv_schedule where id = 27');
	
		$db_users = DB::select(
			"SELECT ms.id, ms.`from`, ms.`to`, ct.name, ct.phone, ct.email, ps.post_title `service`, concat(doc.first_name, ' ', doc.last_name) doctor FROM mv_schedule ms 
				INNER JOIN mv_customer ct on ct.id = ms.customer 
				INNER JOIN mv_doctor doc on doc.id = ms.doctor
				LEFT JOIN lotus_wp_posts ps on ps.ID = ms.service
			WHERE ms.`from` BETWEEN :date_from AND :date_to ORDER BY ms.`from`",
			[':date_from' => $date_from, ':date_to' => $date_to]
		); 

		//return compact('db_users', 'all_users', 'date_from', 'date_to');

		if (count($db_users) <= 0) {
			return ["Not send: ". date('Y-m-d H:i:s') . PHP_EOL ];
		}
		$messages = [];
		$sends = [];
		foreach ($db_users as $user) {
			$address = strip_tags($meta->address);
			$message = $this->client->messages->create(
				strlen($user->phone) == 9 ? "+51{$user->phone}" : "+1{$user->phone}",
				[
					'body' => $this->makeMessage($user->name, $user->from, $user->doctor, $user->service, $address, $meta->phone),
					'from' => env('TWILIO_VIRTUAL_NUMBER')
				]
			);

			$sends[] = $message->sid;
		}

		return $sends;
	}

	public function makeMessage(string $client, $date, string $doctor, string $address, string $oficce_number)
	{
		$day = $this->formatDate($date);
		$time = date('h:i A', strtotime($date));

		$template = "Sr(a) %s, le informamos de la clinica Lotus Estetic que el %s a las %s usted a reservado una cita con el medico %s en nuestro servico de %s en la direccion %s. \n\nNo olvide llegar 10 minutos antes. \n\nCuanquier duda o consulta comunicarse al %s";

		return sprintf($template, $client, $day, $time, $doctor, $address, $servcie, $oficce_number);
	}

	private function formatDate($date)
	{
		$date = strtotime($date);

		$dias = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"];
		$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

		return $dias[date('w', $date)] . " " . date('d', $date) . " de " . $meses[date('n', $date) - 1] . " del " . date('Y', $date);
	}

	public function fetch()
	{
		$messages_sid = [
			"SM4b8feabac667417b9b12b3093fda1380",
			"SM544d2ab90b8441e8a83d5eeb2b071f89"
		];

		$messages = $this->client->messages->read([
			'dateSentBefore' => new \DateTime('2022-06-08T00:00:00Z')
		], 10);

		return $messages;
	}
}
