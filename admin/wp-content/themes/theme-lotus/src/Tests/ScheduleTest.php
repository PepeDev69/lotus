<?php

class ScheduleTest extends \PHPUnit\Framework\TestCase
{

	/**
	 * @var  \GuzzleHttp\Client
	 */
	private $http;

	protected function setUp(): void
	{
		$this->http = new \GuzzleHttp\Client(['base_uri' => 'http://localhost/lotus/admin/index.php/wp-json/api/bookly/schedule/']);
	}

	public function testGetAllUsers()
	{
		$response = $this->http->request('GET');
		$this->assertEquals(200, $response->getStatusCode());
		$data = json_decode($response->getBody(true), true);
		$this->assertArrayHasKey('first_name', $data[0]);
	}

	public function testCreateUser()
	{
		$user = [
			"first_name" => "Michael Jackson",
			"last_name" => "I'Collins Royer",
			"gender" => "Masculino",
			"email" => "testgm@gmail.com",
			"avatar" => "",
			"position" => "Rinosplastia"
		];
		$response = $this->http->request('POST', 'create', [
			'body' => json_encode($user)
		]);
		$this->assertEquals(201, $response->getStatusCode());
	}

	protected function tearDown(): void
	{
		$this->http = null;
	}
}
