<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function before(User $loginUser)
    {
        if ($loginUser->isSuperAdmin()) {
            return true;
        }
    }
}
