<?php
namespace Nagy\HealthChecker\Events;

use Illuminate\Support\Collection;
use Nagy\HealthChecker\Result;

class HealthEvent
{
    /** @var Result */
    public $resultCollection;

    public function __construct(Collection $resultCollection)
    {
        $this->resultCollection = $resultCollection;
    }
}
