<?php
namespace Nagy\HealthChecker\Notifications\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;

class HealthChecked extends Mailable
{
    private $resultCollections;

    public function __construct(Collection $resultCollections)
    {
        $this->resultCollections = $resultCollections;
    }

    public function build()
    {
        return $this->from(config('health-checker.notifications.mail_from'))
            ->view('health-check::mail', $this->resultCollections);
    }
}
