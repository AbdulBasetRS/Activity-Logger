<?php

// config/activity-logger.php

return [
    /*
    |--------------------------------------------------------------------------
    | Activity Logger Enabled
    |--------------------------------------------------------------------------
    |
    | This value determines whether the activity logger is enabled or disabled.
    | If set to true, activity logging will be enabled. If set to false, activity
    | logging will be disabled and no logs will be recorded.
    |
    */
    'enabled' => env('ACTIVITY_LOGGER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Activity Log Table Name
    |--------------------------------------------------------------------------
    |
    | This value determines the name of the table that will store the activity
    | logs if the 'database' logging method is used. You can set this to any
    | table name that fits your application's requirements.
    |
    */
    'table_name' => 'activity_logs',

    /*
    |--------------------------------------------------------------------------
    | Logging Method
    |--------------------------------------------------------------------------
    |
    | This value determines where the activity logs will be stored. You can
    | choose between 'database' and 'file'. If 'database' is selected, logs
    | will be stored in the table specified above. If 'file' is selected,
    | logs will be stored in the file specified by 'log_file_path'.
    |
    | Supported options: 'database', 'file'
    |
    */
    'log_method' => 'database',

    /*
    |--------------------------------------------------------------------------
    | Log File Path
    |--------------------------------------------------------------------------
    |
    | This value specifies the path to the file where activity logs will be
    | stored if the 'file' logging method is used. The path should be an
    | absolute path or a relative path from the storage directory.
    |
    */
    'log_file_path' => storage_path('logs/activity_logs.log'),

    /*
    |--------------------------------------------------------------------------
    | Log Only Changes
    |--------------------------------------------------------------------------
    |
    | This value determines whether only the changes should be logged when an
    | entity is updated.
    |
    */
    'log_only_changes' => true,

    /*
    |--------------------------------------------------------------------------
    | Log Login Auth
    |--------------------------------------------------------------------------
    |
    | This option determines whether login events will be automatically logged.
    | If set to true, login events will be logged. If set to false, login events
    | will not be logged.
    |
    */
    'log_login_auth' => true,

    /*
    |--------------------------------------------------------------------------
    | Log Logout Auth
    |--------------------------------------------------------------------------
    |
    | This option determines whether logout events will be automatically logged.
    | If set to true, logout events will be logged. If set to false, logout events
    | will not be logged.
    |
    */
    'log_logout_auth' => true,
];
