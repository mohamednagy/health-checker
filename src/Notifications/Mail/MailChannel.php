<?php
namespace Nagy\HealthChecker\Notifications\Mail;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class MailChannel
{
    public function notify(Collection $results)
    {
        Mail::to(config('health-checker.notifications.mail_to'))
            ->send(new HealthChecked($results));
    }
}
