<?php

namespace App\Policies;

use App\User;
use App\Models\GroupImage;
use App\Models\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\GroupImage  $GroupImage
     * @return mixed
     */
    public function delete(User $user, GroupImage $image)
    {
        return $user->id === $image->user_id;
    }

    public function update(User $user, Group $group, GroupImage $image){
        if($user->id !== $group->user_id)
            return false;
        $relatingModel = $image->imageable()->first();
        return $group->id === $relatingModel->id;
    }
}
