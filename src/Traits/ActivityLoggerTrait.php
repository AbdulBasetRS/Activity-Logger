<?php 

// src/Traits/LogsActivity.php

namespace Abdulbaset\ActivityLogger\Traits;

use Abdulbaset\ActivityLogger\Facades\ActivityLogger;

trait ActivityLoggerTrait
{
    public function logCreated($description)
    {
        ActivityLogger::log($this, 'created', $description);
    }

    public function logUpdated($description)
    {
        ActivityLogger::log($this, 'updated', $description);
    }

    public function logDeleted($description)
    {
        ActivityLogger::log($this, 'deleted', $description);
    }
}
