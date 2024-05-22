<?php

return [
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
];
