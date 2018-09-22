<?php
namespace Nagy\HealthChecker\Traits;

trait CommandTrait
{
	protected function executeCommand(string $command)
	{
		return shell_exec($command);
	}
}
