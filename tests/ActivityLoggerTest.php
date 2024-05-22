<?php

namespace Abdulbaset\ActivityLogger\Tests;

use Abdulbaset\ActivityLogger\ActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityLoggerTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            \Abdulbaset\ActivityLogger\Providers\ActivityLoggerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Set up a temporary database for testing
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Set up configuration for the logger
        $app['config']->set('activity-logger.table_name', 'activity_logs');
        $app['config']->set('activity-logger.log_method', 'database');
        $app['config']->set('activity-logger.log_file_path', storage_path('logs/activity_logs.log'));
    }

    public function testLogToDatabase()
    {
        // Run migrations
        $this->loadMigrationsFrom(__DIR__.'/../src/Migrations');

        // Create a dummy model
        $dummyModel = new class {
            public $id = 1;
            public function getOriginal() { return []; }
            public function getChanges() { return []; }
            public function toArray() { return []; }
        };

        // Log an event
        ActivityLogger::log($dummyModel, 'created', 'Test log entry');

        // Verify the log entry in the database
        $this->assertDatabaseHas('activity_logs', [
            'event' => 'created',
            'description' => 'Test log entry',
        ]);
    }

    public function testLogToFile()
    {
        // Set the logging method to file
        config(['activity-logger.log_method' => 'file']);

        // Create a dummy model
        $dummyModel = new class {
            public $id = 1;
            public function getOriginal() { return []; }
            public function getChanges() { return []; }
            public function toArray() { return []; }
        };

        // Log an event
        ActivityLogger::log($dummyModel, 'created', 'Test log entry');

        // Verify the log entry in the file
        $logFilePath = config('activity-logger.log_file_path');
        $this->assertTrue(Storage::disk('local')->exists($logFilePath));
        $logContent = Storage::disk('local')->get($logFilePath);
        $this->assertStringContainsString('Test log entry', $logContent);
    }
}
