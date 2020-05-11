<?php
namespace Nagy\HealthChecker;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Nagy\HealthChecker\Events\HealthEvent;
use Nagy\HealthChecker\Events\HealthEventListener;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/health-check.php' => config_path('health-check.php')
        ]);

        $frequency = config('health-check.schedule') ?? 'hourly';
        $this->app->make(Schedule::class)
            ->command(HealthCheckCommand::class)->{$frequency}();
    }

    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/../config/health-check.php', 'health-check');

        $this->registerEventListeners();

        $this->registerCommand();
    }

    private function registerEventListeners()
    {
        Event::listen(HealthEvent::class, HealthEventListener::class);
    }

    private function registerCommand()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([HealthCheckCommand::class]);
        }
    }
}
