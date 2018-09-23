<?php
namespace Nagy\HealthChecker\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Nagy\HealthChecker\Checkers\Expression;
use Nagy\HealthChecker\Checkers\ProcessCount;
use Nagy\HealthChecker\CheckService;
use Nagy\HealthChecker\Result;

class CheckerTest extends TestCase
{
    /** @var CheckService */
    private $checkService;

    public function setUp()
    {
        parent::setUp();
    }

    public function testProcessCountChecker()
    {
        Config::set('health-check.checkers', [
            'php' => [
                "class" => ProcessCount::class,
                "options" => ['processName' => 'php', 'min' => 1]
            ]
        ]);

        $this->checkService = $this->app->make(CheckService::class);

        $result = $this->checkService->run('php');
        $this->assertEquals(Result::SUCCESS_STATUS, $result->toArray()['type']);


        Config::set('health-check.checkers', [
            'php' => [
                "class" => ProcessCount::class,
                "options" => ['processName' => 'notExistingProcess', 'min' => 1]
            ]
        ]);

        $result = $this->checkService->run('php');
        $this->assertEquals(Result::ERROR_STATUS, $result->toArray()['type']);
    }


    public function testExpressionChecker()
    {

        Config::set('health-check.checkers', [
            'expression' => [
                "class" => Expression::class,
                'options' => [
                    'expression' => '1+1 == 2'
                ]
            ]
        ]);

        $this->checkService = $this->app->make(CheckService::class);

        $result = $this->checkService->run('expression')->toArray();
        $this->assertEquals(Result::SUCCESS_STATUS, $result['type']);

        Config::set('health-check.checkers.expression.options.expression', '1+1 == 3');
        $result = $this->checkService->run('expression')->toArray();
        $this->assertEquals(Result::ERROR_STATUS, $result['type']);
    }
}
