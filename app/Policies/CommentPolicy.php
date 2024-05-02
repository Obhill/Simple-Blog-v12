<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function delete(User $user, Comment $comment)
    {
        return $user->isAdmin() || $user->id === $comment->user_id;
    }
}
