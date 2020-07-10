<?php

namespace App\Policies;

use App\Models\PostComment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\PostComment  $comment
     * @return mixed
     */
    public function update(User $user, PostComment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\PostComment  $comment
     * @return mixed
     */
    public function delete(User $user, PostComment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
