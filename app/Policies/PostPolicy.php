<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy extends Policy
{
    public function update(User $loginUser, Post $post)
    {
        return $loginUser->isAuthorOf($post);
    }
}
