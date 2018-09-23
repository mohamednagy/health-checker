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
		$this->json('get', 'health-check/checkers')
			->assertStatus(200)
			->assertJson(['httpd-check', 'app-debug']);
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
