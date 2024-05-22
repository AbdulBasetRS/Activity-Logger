<?php 

namespace Abdulbaset\ActivityLogger\Observers;

use Abdulbaset\ActivityLogger\Facades\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

class ActivityLoggerObserver
{
    /**
     * Log when a new model is created.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function created(Model $entity)
    {
        ActivityLogger::log($entity, 'created', 'Entity created From Observer');
    }

    /**
     * Log when a model is updated.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function updated(Model $entity)
    {
        ActivityLogger::log($entity, 'updated', 'Entity updated From Observer');
    }

    /**
     * Log when a model is deleted.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function deleted(Model $entity)
    {
        ActivityLogger::log($entity, 'deleted', 'Entity deleted From Observer');
    }

    /**
     * Log when a model is restored from soft delete.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function restored(Model $entity)
    {
        ActivityLogger::log($entity, 'restored', 'Entity restored From Observer');
    }

    /**
     * Log when a model is force deleted.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function forceDeleted(Model $entity)
    {
        ActivityLogger::log($entity, 'forceDeleted', 'Entity force deleted From Observer');
    }
}
