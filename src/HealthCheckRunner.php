<?php

namespace Nagy\HealthChecker;

use Exception;
use Illuminate\Support\Collection;
use Nagy\HealthChecker\Events\HealthEvent;
use Illuminate\Contracts\Foundation\Application;

class HealthCheckRunner
{
    /** @var Application */
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function run(HealthChecker $healthChecker, bool $triggerEvent = true)
    {
        $result = null;

        try {
            $checker = $this->initialize($healthChecker);

            StopWatch::start();
            $result = $checker->check();
            $result->setExecutionTime(StopWatch::elapsed());

        } catch (Exception $exception) {
            $result = new Result('General Error', Result::ERROR_STATUS, $exception->getMessage(), [
                'line' => $exception->getLine(),
                'file' => $exception->getFile()
            ]);
        }

        if ($triggerEvent) {
            event(new HealthEvent(collect([$result])));
        }

        return $result;
    }

    public function runAll(): Collection
    {
        $checkers = config('health-check')['checkers'] ?? [];
        $result = collect();
        foreach ($checkers as $name => $config) {
            $result->push($this->run(new HealthChecker($name, $config)));
        }

        event(new HealthEvent($result));

        return $result;
    }

    private function initialize(HealthChecker $healthChecker): HealthCheckInterface
    {
        return $this->application->make(
            $healthChecker->getHandler(),
            ['options' => $healthChecker->getOptions()]
        );
    }
}
