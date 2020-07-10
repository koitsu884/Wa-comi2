<?php

namespace App\Policies;

use App\Models\Image;
use App\User;
use App\UserImage;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class UserImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserImage  $image
     * @return mixed
     */
    public function view(User $user, UserImage $image)
    {
        $user->id == $image->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user && $user->isVerified();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Image  $image
     * @return mixed
     */
    public function delete(User $user, Image $image)
    {
        $user->id == $image->user_id;
    }
}
