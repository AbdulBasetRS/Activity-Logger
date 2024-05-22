<?php

namespace Abdulbaset\ActivityLogger;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Abdulbaset\ActivityLogger\Helpers;

class ActivityLogger
{
    public static function log($model, $event, $description = null, $otherInfo = [])
    {
        $logData = [
            'event' => $event,
            'user_id' => Auth::id() ?: null,
            'model' => get_class($model),
            'model_id' => $model->id,
            'old' => $event == 'updated' ? $model->getOriginal() : null,
            'new' => $event == 'updated' ? $model->getChanges() : $model->toArray(),
            'ip' => Request::ip(),
            'browser' => Request::header('User-Agent'),
            'browser_version' => Helpers\getBrowserVersion(Request::header('User-Agent')),
            'referring_url' => Request::server('HTTP_REFERER'),
            'current_url' => Request::fullUrl(),
            'device_type' => Helpers\getDeviceType(),
            'operating_system' => Helpers\getOperatingSystem(),
            'description' => $description,
            'other_info' => $otherInfo,
            'created_at' => now()->toDateTimeString(), // Use Laravel's now() helper for the timestamp
            'updated_at' => now()->toDateTimeString(),
        ];

        // Log based on the configured method
        switch (config('activity-logger.log_method')) {
            case 'file':
                self::logToFile($logData);
                break;
            case 'database':
            default:
                self::logToDatabase($logData);
                break;
        }
    }

    protected static function logToDatabase($logData)
    {
        DB::table(config('activity-logger.table_name'))->insert($logData);
    }

    protected static function logToFile($logData)
    {
        $logFilePath = config('activity-logger.log_file_path');
        $logEntry = json_encode($logData) . PHP_EOL;
        Storage::append($logFilePath, $logEntry);
    }
}
