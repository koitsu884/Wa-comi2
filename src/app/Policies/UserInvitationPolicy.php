<?php

namespace App\Policies;

use App\Models\UserInvitation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserInvitationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UserInvitation  $userInvitation
     * @return mixed
     */
    public function update(User $user, UserInvitation $invitation)
    {
        return $user->id === $invitation->invited_user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UserInvitation  $userInvitation
     * @return mixed
     */
    public function delete(User $user, UserInvitation $invitation)
    {
        return $user->id === $invitation->invited_user_id;
    }
}
