<?php
namespace Nagy\HealthChecker\Tests;

use Illuminate\Support\Facades\Artisan;
use Nagy\HealthChecker\CheckRunner;

class CheckerTest extends TestCase
{

    public function testItCanRunCheckers()
    {
//        $checker = new CheckRunner(config('health-checker'));
//
//        $results = $checker->run('docker-compose Check');
//
//        dd($results);

//        Artisan::call('health:check');
//        dd(Artisan::output());

//        $response = $this->json('get', 'health-check');
//        dd($response->json());

        $response = $this->json('get', 'health-check/dashboard');
        dd($response->getContent());
    }
}
