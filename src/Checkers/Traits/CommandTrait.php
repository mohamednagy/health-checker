<?php
namespace Nagy\HealthChecker\Checkers\Traits;

trait CommandTrait
{
	protected function executeCommand(string $command)
	{
		return shell_exec($command);
	}
}
