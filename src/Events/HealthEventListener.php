<?php
namespace Nagy\HealthChecker\Events;

use Illuminate\Support\Facades\Notification;
use Nagy\HealthChecker\Notifications\Notifier;
use Nagy\HealthChecker\Result;

class HealthEventListener
{
    /** @var array  */
    private $notificationsConfig;

    public function __construct()
    {
        $this->notificationsConfig = config('health-check.notifications');
    }

    public function handle(HealthEvent $event)
    {
        $notifiedResults = collect();
        foreach ($event->resultCollection as $result) {
            if ($this->shouldNotify($result)) {
                $notifiedResults->push($result);
            }
        }

        if ($notifiedResults->count() == 0) {
            return;
        }

        foreach (config('health-check.notifications.channels') as $channel) {
            app()->make($channel)->notify($notifiedResults);
        }
    }

    private function isNotificationsEnabled(): bool
    {
        return $this->notificationsConfig['enabled'];
    }

    private function shouldNotify(Result $result): bool
    {
        $result = $result->toArray();

        $shouldNotify = $this->isNotificationsEnabled();
        if ($shouldNotify === false) {
            return false;
        }

        $checkerName = $result['checkerName'];
        $config = config('health-check.checkers.'.$checkerName);
        $shouldNotify = $config['notify'] ?? $shouldNotify;

        if (!in_array($result['status'], $this->notificationsConfig['notify_on'])) {
            $shouldNotify = false;
        }

        return $shouldNotify;
    }
}
