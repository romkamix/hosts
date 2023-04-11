<?php

namespace Romkamix\App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Romkamix\App\Console\Commands\HostPingCommand;

class HostServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'romkamix');

        if ($this->app->runningInConsole()) {
            $this->commands([
                HostPingCommand::class,
            ]);
        }

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('host:ping')->everyMinute();
        });
    }
}
