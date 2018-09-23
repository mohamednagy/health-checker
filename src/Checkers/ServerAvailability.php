<?php
namespace Nagy\HealthChecker\Checkers;

use Nagy\HealthChecker\HealthCheckInterface;
use Nagy\HealthChecker\Result;

class ServerAvailability extends AbstractBaseChecker implements HealthCheckInterface
{
	/** @var string  */
	private $message = '';

	public function check(): Result
	{
		if ($this->isHealthy()) {
			return $this->makeHealthyResult();
		}

		return $this->makeUnHealthyResult();
	}

	public function isHealthy(): bool
	{
		$host = $this->getOption('host');
		$port = $this->getOption('port') ?? 80;
		$timeout = $this->getOption('timeOut') ?? 3;
		$fp = @fsockopen($host, $port, $errNo, $errStr, $timeout);
		if ($fp) {
			fclose($fp);
			return true;
		}

		$this->message = $errStr;

		return false;
	}

	public function getMessage(): string
	{
		return $this->message;
	}
}
