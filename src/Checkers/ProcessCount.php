<?php

namespace Nagy\HealthChecker\Checkers;

use Nagy\HealthChecker\Checkers\Traits\CommandTrait;
use Nagy\HealthChecker\HealthCheckInterface;
use Nagy\HealthChecker\Result;

class ProcessCount extends AbstractBaseChecker implements HealthCheckInterface
{
    use CommandTrait;

    /** @var string  */
    private $commandSignature = 'pgrep %s | wc -l';

    /** @var string  */
    private $message = 'Current running processes count of %s is %d, expected min %d and max %s';

    /** @var mixed */
    private $result;

    public function check(): Result
    {
        $this->result = (int) $this->executeCommand($this->buildCommand());
        if ($this->isHealthy()) {
            return $this->makeHealthyResult();
        }

        return $this->makeUnHealthyResult();
    }

    private function buildCommand()
    {
        return sprintf(
            $this->commandSignature,
            $this->getOption('processName')
        );
    }

    public function isHealthy(): bool
    {
        $min = $this->getOption('min');
        $max = $this->getOption('max') ?? 99999;
        return $this->result >= $min && $this->result <= $max;
    }

    public function getMessage(): string
    {
        return sprintf(
            $this->message,
            $this->getOption('processName'),
            $this->result,
            $this->getOption('min'),
            $this->getOption('max') ?? 'unlimited'
        );
    }
}
