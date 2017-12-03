<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy extends Policy
{
    public function delete(User $loginUser, Comment $comment)
    {
        return $loginUser->isAuthorOf($comment);
    }
}
