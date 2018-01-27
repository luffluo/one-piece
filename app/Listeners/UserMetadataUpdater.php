<?php

namespace App\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;

class UserMetadataUpdater
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Registered::class, [$this, 'whenUserWasRegistered']);
        $events->listen(Login::class, [$this, 'whenUserWasLogin']);
    }

    public function whenUserWasRegistered(Registered $event)
    {
        /* @var \App\Models\User $user */
        $user = $event->user;
        if ($user && $user->exists) {
            $user->updateLoggedAt()->save();
        }
    }

    public function whenUserWasLogin(Login $event)
    {
        /* @var \App\Models\User $user */
        $user = $event->user;
        if ($user && $user->exists) {
            $user->updateLoggedAt()->save();
        }
    }
}
