<?php

namespace Nagy\HealthChecker;

class HealthChecker
{
    /** @var string */
    private $name;

    /** @var array */
    private $config;

    public function __construct(string $name, array $config)
    {
        $this->name = $name;
        $this->config = $config;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHandler(): string
    {
        return $this->config['class'];
    }

    public function getOptions(): array
    {
        $this->config['options']['checkerName'] = $this->getName();

        return $this->config['options'];
    }
}
