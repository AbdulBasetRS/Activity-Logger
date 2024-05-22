<?php

namespace Abdulbaset\ActivityLogger\Providers;

use Illuminate\Support\ServiceProvider;
use Abdulbaset\ActivityLogger\ActivityLogger;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Abdulbaset\ActivityLogger\Listeners\LogLoginActivityListener;
use Abdulbaset\ActivityLogger\Listeners\LogLogoutActivityListener;

class ActivityLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register login event listener if enabled in config
        if (config('activity-logger.log_login_auth')) {
            Event::listen(Login::class, LogLoginActivityListener::class);
        }
        
        // Register logout event listener if enabled in config
        if (config('activity-logger.log_logout_auth')) {
            Event::listen(Logout::class, LogLogoutActivityListener::class);
        }

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
        $this->app->singleton('activity-logger', function ($app) {
            return new ActivityLogger();
        });
    }
}
