<?php

// src/Listeners/LogLoginActivity.php

namespace Abdulbaset\ActivityLogger\Listeners;

use Abdulbaset\ActivityLogger\Facades\ActivityLogger;
use Illuminate\Auth\Events\Login;

class LogLoginActivityListener
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user; // Get the authenticated user
        ActivityLogger::log($user, 'login', 'User logged in');
    }
}
