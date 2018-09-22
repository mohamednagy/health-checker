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
            __DIR__.'/../config/health-checker.php' => config_path('health-checker.php')
        ]);

        $this->publishes([
            __DIR__.'/../resources/js' => public_path('js'),
        ], 'public');

        $this->app->make(Schedule::class)
            ->command(HealthCheckCommand::class)->everyFiveMinutes();
    }

    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/../config/health-checker.php', 'health-checker');
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'health-checker');

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

//        $scheduler = $this->app->make(Schedule::class, []);
//        $scheduler->command('health:check')->everyFiveMinutes();
    }
}
