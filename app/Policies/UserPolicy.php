<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $loginUser, User $user)
    {
        return $loginUser->id === $user->id;
    }

    public function enterAdminDashboard(User $loginUser)
    {
        return $loginUser->may('administrator');
    }
}
