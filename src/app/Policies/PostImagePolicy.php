<?php

namespace App\Policies;

use App\User;
use App\Models\PostImage;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\PostImage  $postImage
     * @return mixed
     */
    public function delete(User $user, PostImage $image)
    {
        return $user->id === $image->user_id;
    }

    public function update(User $user, Post $post, PostImage $image){
        if($user->id !== $post->user_id)
            return false;
        $relatingModel = $image->imageable()->first();
        return $post->id === $relatingModel->id;
    }
}
