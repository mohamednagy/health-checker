<?php

namespace Nagy\HealthChecker\Tests;

use Illuminate\Support\Facades\Config;
use Nagy\HealthChecker\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        Config::set('health-check.notifications.enabled', false);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
           ServiceProvider::class
        ];
    }
}
