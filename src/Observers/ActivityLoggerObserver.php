<?php 

// src/Observers/ActivityLoggerObserver.php

namespace Abdulbaset\ActivityLogger\Observers;

use Abdulbaset\ActivityLogger\Facades\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

class ActivityLoggerObserver
{
    public function created(Model $entity)
    {
        ActivityLogger::log($entity, 'created');
    }

    public function updated(Model $entity)
    {
        ActivityLogger::log($entity, 'updated');
    }

    public function deleted(Model $entity)
    {
        ActivityLogger::log($entity, 'deleted');
    }
}
