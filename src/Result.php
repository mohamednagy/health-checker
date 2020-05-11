<?php

namespace Nagy\HealthChecker;

class Result
{
    /** @var string  */
    const ERROR_STATUS = 'error';

    /** @var string  */
    const SUCCESS_STATUS = 'success';

    /** @var string  */
    const WARNING_STATUS = 'warning';

    /** @var string */
    private $status;

    /** @var string */
    private $message;

    /** @var array  */
    private $trace = [];

    /** @var string  */
    private $checkerName;

    private $executionTime;

    public function __construct(string $checkerName, $status = 'success', $message = 'Everything is ok with the process', $trace = [])
    {
        $this->status = $status;
        $this->message = $message;
        $this->trace = $trace;
        $this->checkerName = $checkerName;
    }

    public function setExecutionTime($time)
    {
        $this->executionTime = $time;
    }

    public function toArray()
    {
        return [
            'checkerName' => $this->checkerName,
            'status' => $this->status,
            'message' => $this->message,
            'trace' => $this->trace,
            'executionTime' => $this->executionTime
        ];
    }

    public function __toString()
    {
        return @json_encode($this->toArray());
    }
}
