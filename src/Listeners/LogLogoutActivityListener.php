<?php 
// src/Listeners/LogLogoutActivity.php

namespace Abdulbaset\ActivityLogger\Listeners;

use Abdulbaset\ActivityLogger\Facades\ActivityLogger;
use Illuminate\Auth\Events\Logout;

class LogLogoutActivityListener
{
    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user; // Get the user who logged out
        ActivityLogger::log($user, 'logout', 'User logged out');
    }
}
