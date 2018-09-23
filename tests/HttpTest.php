<?php
namespace Nagy\HealthChecker\Tests;

class HttpTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
	}

	public function testItCanAccessTheDashboard()
	{
		$this->json('get', 'health-check/dashboard')
			->assertStatus(200)
			->assertSee('checkers-container');
	}

	public function testItCanCallGetCheckers()
	{
		$response = $this->json('get', 'health-check/checkers')
			->assertStatus(200);

		$checkers = array_keys(config('health-check.checkers'));

		$this->assertEquals($checkers, $response->json());
	}

	public function testItCanCallGetAllCheckersResult()
	{
		$this->json('get', 'health-check')
			->assertStatus(200)
			->assertJsonStructure([
				['status', 'message', 'checkerName']
			]);
	}

	public function testItCanCallGetSpecificCheckersResult()
	{
		$this->json('get', 'health-check/httpd-check')
			->assertStatus(200)
			->assertJsonStructure(['status', 'message', 'checkerName']);
	}
}
