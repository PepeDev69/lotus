<?php

namespace Lotus\Shared\Providers;

use Lotus\Shared\Providers\Contracts\SMSManager;
use Twilio\Rest\Client;

final class TwilioSMSManager implements SMSManager
{
	private const TWILIO_ID = '';

	private const TWILIO_TOKEN = '';

	/**
	 * @var \Twilio\Rest\Client 
	 */
	private $client;

	public function __construct()
	{
		$this->client = new Client(self::TWILIO_ID, self::TWILIO_TOKEN);
	}

	public function send()
	{
		$numbers = ['<your-number>'];
		$sends = [];
		foreach ($numbers as $number) {
			$message = $this->client->messages->create(
				$number,
				[
					'body' => 'Una prueba para AMG',
					'from' => '<virtual-number>'
				]
			);

			$sends[] = $message->sid;
		}
		return $sends;
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
