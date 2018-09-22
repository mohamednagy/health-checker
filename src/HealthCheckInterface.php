<?php

namespace Nagy\HealthChecker;

interface HealthCheckInterface
{
    public function check(): Result;

    public function isHealthy(): bool;

    public function getMessage(): string;
}
