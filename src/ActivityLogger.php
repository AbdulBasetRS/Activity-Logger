<?php

namespace Abdulbaset\ActivityLogger;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Abdulbaset\ActivityLogger\Helpers;

class ActivityLogger
{
    public static function log($model, $event = null, $description = null, $otherInfo = [])
    {
        if (!config('activity-logger.enabled')) {
            return; // Activity logging is disabled
        }

        $logData = self::prepareLogData($model, $event, $description, $otherInfo);

        self::logData($logData);
    }

    public static function retrieved($model, $description = null, $otherInfo = [])
    {
        if (!config('activity-logger.enabled')) {
            return; // Activity logging is disabled
        }

        $logData = self::prepareLogData($model, 'retrieved', $description, $otherInfo);

        self::logData($logData);
    }

    public static function visited($description = null, $otherInfo = [])
    {
        if (!config('activity-logger.enabled')) {
            return; // Activity logging is disabled
        }

        $logData = self::prepareLogData(null, 'visited', $description, $otherInfo);

        self::logData($logData);
    }

    public static function event($event = 'default', $description = null, $otherInfo = [])
    {
        if (!config('activity-logger.enabled')) {
            return; // Activity logging is disabled
        }

        $logData = self::prepareLogData(null, $event, $description, $otherInfo);

        self::logData($logData);
    }

    protected static function prepareLogData($model, $event, $description, $otherInfo)
    {
        $userAgent = Request::header('User-Agent');

        $logData = [
            'event' => $event,
            'user_id' => Auth::id() ?: null,
            'model' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'old' => null,
            'new' => null,
            'ip' => Request::ip(),
            'browser' => Helpers\getBrowser($userAgent),
            'browser_version' => Helpers\getBrowserVersion($userAgent),
            'referring_url' => Request::server('HTTP_REFERER'),
            'current_url' => Request::fullUrl(),
            'device_type' => Helpers\getDeviceType($userAgent),
            'operating_system' => Helpers\getOperatingSystem($userAgent),
            'description' => $description,
            'other_info' => empty($otherInfo) ? null : json_encode($otherInfo),
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ];

        if ($event === 'updated') {
            $logData['old'] = json_encode($model->getOriginal());
            $logData['new'] = json_encode($model->getChanges());
            if (config('activity-logger.log_only_changes')) {
                $logData['old'] = json_encode(array_intersect_key($model->getOriginal(), $model->getChanges()));
                $logData['new'] = json_encode($model->getChanges());
            } else {
                $logData['old'] = json_encode($model->getOriginal());
                $logData['new'] = json_encode($model->toArray());
            }
        } elseif ($event === 'created') {
            $logData['new'] = json_encode($model->toArray());
        } elseif ($event === 'deleted') {
            $logData['old'] = json_encode($model->toArray());
        } elseif ($event === 'retrieved') {
            $logData['old'] = json_encode($model->toArray());
        }

        return $logData;
    }

    protected static function logData($logData)
    {
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
        // Append the log entry to the file
        file_put_contents($logFilePath, $logEntry, FILE_APPEND);
    }
}
