<?php 

// src/Traits/ActivityLoggerTrait.php

namespace Abdulbaset\ActivityLogger\Traits;

use Abdulbaset\ActivityLogger\Facades\ActivityLogger;

trait ActivityLoggerTrait
{
    public static function bootActivityLoggerTrait()
    {
        static::created(function ($model) {
            $model->logCreated('Entity created From Trait');
        });

        static::updated(function ($model) {
            $model->logUpdated('Entity updated From Trait');
        });

        static::deleted(function ($model) {
            $model->logDeleted('Entity deleted From Trait');
        });
    }

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
