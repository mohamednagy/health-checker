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
        $this->notificationsConfig = config('health-checker.notifications');
    }

    public function handle(HealthEvent $event)
    {
        $notifiedResults = collect();
        foreach ($event->resultCollection as $result) {
            if ($this->shouldNotify($result)) {
                $notifiedResults->push($result);
            }
        }

        foreach (config('health-checker.notifications.channels') as $channel) {
            (new $channel)->notify($notifiedResults);
        }
    }

    private function isNotificationsEnabled(): bool
    {
        return $this->notificationsConfig['enabled'];
    }



    private function shouldNotify(Result $result)
    {
        $result = $result->toArray();

        $shouldNotifiy = $this->isNotificationsEnabled();

        $checkerName = $result['checkerName'];
        $config = config('health-checker.checkers.'.$checkerName);
        $shouldNotifiy = $config['notify'] ?? $shouldNotifiy;

        if (!in_array($result['type'], $this->notificationsConfig['notify_on'])) {
            $shouldNotifiy = false;
        }

        return $shouldNotifiy;
    }
}
