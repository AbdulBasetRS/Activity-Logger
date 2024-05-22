<?php

namespace Abdulbaset\ActivityLogger;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Abdulbaset\ActivityLogger\Helpers;

class ActivityLogger
{
    public static function log($model, $event = null, $description = null, $otherInfo = [])
    {
        if ($event == 'updated') {
            $old = json_encode($model->getOriginal());
            $new = json_encode($model->getChanges());
        } elseif ($event == 'created') {
            $new = json_encode($model->toArray());
            $old = null; // No old data for created event
        } elseif ($event == 'deleted') {
            $old = json_encode($model->toArray());
            $new = null; // No new data for deleted event
        } elseif ($event == 'retrieved') {
            $old = json_encode($model->toArray());
            $new = null; // No new data for retrieved event
        } else {
            $old = null;
            $new = null;
        }

        if (!is_array($otherInfo)) {
            $otherInfo = null;
        } elseif (empty($otherInfo)) {
            $otherInfo = null;
        } else {
            $otherInfo = json_encode($otherInfo);
        }

        $logData = [
            'event' => $event,
            'user_id' => Auth::id() ?: null,
            'model' => get_class($model),
            'model_id' => $model->id,
            'old' => $old,
            'new' => $new,
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

    public static function retrieved($model, $description = null, $otherInfo = [])
    {
        if (!is_array($otherInfo)) {
            $otherInfo = null;
        } elseif (empty($otherInfo)) {
            $otherInfo = null;
        } else {
            $otherInfo = json_encode($otherInfo);
        }

        $logData = [
            'event' => 'retrieved',
            'user_id' => Auth::id() ?: null,
            'model' => get_class($model),
            'model_id' => $model->id,
            'old' =>  $model->toJson(),
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

    public static function visited($description = null, $otherInfo = [])
    {
        if (!is_array($otherInfo)) {
            $otherInfo = null;
        } elseif (empty($otherInfo)) {
            $otherInfo = null;
        } else {
            $otherInfo = json_encode($otherInfo);
        }

        $logData = [
            'event' => 'visited',
            'user_id' => Auth::id() ?: null,
            'model' => null, // No specific model
            'model_id' => null, // No specific model ID
            'old' => null,
            'new' => null,
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

    public static function event($event = 'default', $description = null, $otherInfo = [])
    {
        if (!is_array($otherInfo)) {
            $otherInfo = null;
        } elseif (empty($otherInfo)) {
            $otherInfo = null;
        } else {
            $otherInfo = json_encode($otherInfo);
        }

        $logData = [
            'event' => $event,
            'user_id' => Auth::id() ?: null,
            'model' => null, // No specific model
            'model_id' => null, // No specific model ID
            'old' => null,
            'new' => null,
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
