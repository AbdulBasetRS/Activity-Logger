<?php 

namespace Abdulbaset\ActivityLogger\Traits;

use Abdulbaset\ActivityLogger\Facades\ActivityLogger;

trait ActivityLoggerTrait
{
    // Boot method to register model event listeners
    public static function bootActivityLoggerTrait()
    {
        // Listen for the 'created' event and log it
        static::created(function ($model) {
            $model->logCreated('Entity created From Trait');
        });

        // Listen for the 'updated' event and log it
        static::updated(function ($model) {
            $model->logUpdated('Entity updated From Trait');
        });

        // Listen for the 'deleted' event and log it
        static::deleted(function ($model) {
            $model->logDeleted('Entity deleted From Trait');
        });

        // Listen for the 'restored' event and log it
        static::restored(function ($model) {
            $model->logRestored('Entity restored From Trait');
        });

        // Listen for the 'forceDeleted' event and log it
        static::forceDeleted(function ($model) {
            $model->logForceDeleted('Entity force deleted From Trait');
        });

        // You can add more event listeners here if needed
        // For example:
        // static::saved(function ($model) {
        //     $model->logSaved('Entity saved From Trait');
        // });
    }

    // Log the 'created' event
    public function logCreated($description)
    {
        ActivityLogger::log($this, 'created', $description);
    }

    // Log the 'updated' event
    public function logUpdated($description)
    {
        ActivityLogger::log($this, 'updated', $description);
    }

    // Log the 'deleted' event
    public function logDeleted($description)
    {
        ActivityLogger::log($this, 'deleted', $description);
    }

    // Log the 'restored' event
    public function logRestored($description)
    {
        ActivityLogger::log($this, 'restored', $description);
    }

    // Log the 'forceDeleted' event
    public function logForceDeleted($description)
    {
        ActivityLogger::log($this, 'forceDeleted', $description);
    }

    // You can add more logging methods here as needed
    // For example:
    // public function logSaved($description)
    // {
    //     ActivityLogger::log($this, 'saved', $description);
    // }
}
