<?php
namespace Nagy\HealthChecker\Checkers;


use Nagy\HealthChecker\HealthCheckInterface;
use Nagy\HealthChecker\Result;

class Expression extends AbstractBaseChecker implements HealthCheckInterface
{
	public $message = 'The evaluation of expression %s is false but true is expected)';

	/** @var mixed */
    private $result;

    public function check(): Result
	{
        if ($this->isHealthy()) {
            return $this->makeHealthyResult();
        }

        return $this->makeUnHealthyResult();
	}

	public function isHealthy(): bool
	{
        $this->result = eval(" return {$this->getOption('expression')};");

        return $this->result;
	}

	public function getMessage(): string
    {
        return sprintf(
            $this->message,
            $this->getOption('expression')
        );
    }
}
