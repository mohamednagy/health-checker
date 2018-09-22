<?php

namespace Nagy\HealthChecker\Checkers;

use Nagy\HealthChecker\Result;

abstract class AbstractBaseChecker
{
    /**
     * @var array
     */
    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function getOption(string $optionName): ?string
    {
        return $this->options[$optionName] ?? null;
    }

    public function makeHealthyResult()
    {
        return new Result($this->getOption('checkerName'));
    }

    public function makeUnHealthyResult(string $severity = null)
    {
        $severity  = $severity ?? Result::ERROR_STATUS;

        return new Result($this->getOption('checkerName'), $severity, $this->getMessage(), []);
    }
}
