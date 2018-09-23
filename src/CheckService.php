<?php

namespace Nagy\HealthChecker;

use Exception;
use Illuminate\Support\Collection;
use Nagy\HealthChecker\Events\HealthEvent;

class CheckService
{
    private $checks = [];

    public function __construct(array $checks = null)
    {
        $checks = $checks ?? $this->getCheckers();
        $this->checks = $checks;
    }

    public function runAll(): Collection
    {
        $result = collect();
        foreach ($this->checks as $name => $check) {
            $result->push($this->run($name, $check));
        }

        event(new HealthEvent($result));

        return $result;
    }

    public function run(string $name, array $checker = []): Result
    {
        try {
            if (count($checker) == 0) {
                $checker = $this->getCheckerByName($name);
            }

            $options = $checker['options'];
            $options['checkerName'] = $name;

            $checker = new $checker['class']($options);

            $time = microtime(true);
            $result = $checker->check();
            $time = microtime(true) - $time;
            $result->setExecutionTime($time);

            event(new HealthEvent(collect([$result])));

            return $result;

        } catch (Exception $exception) {
            return new Result('General Error', Result::ERROR_STATUS, $exception->getMessage(), [
                'line' => $exception->getLine(),
                'file' => $exception->getFile()
            ]);
        }
    }

    public function getCheckerByName(string $name): ?array
    {
        return $this->getCheckers()[$name] ?? null;
    }

    public function getCheckers(): array
    {
        return config('health-check')['checkers'] ?? [];
    }
}
