<?php

namespace Abdulbaset\ActivityLogger\Providers;

use Illuminate\Support\ServiceProvider;

class ActivityLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish config file
        $this->publishes([
            __DIR__.'/../Config/activity-logger.php' => config_path('activity-logger.php'),
        ]);

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/activity-logger.php', 'activity-logger'
        );
    }
}
