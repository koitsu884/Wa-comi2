<?php

namespace App\Policies;

use App\User;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupInvitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupInvitationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsGroupInvitation  $modelsGroupInvitation
     * @return mixed
     */
    public function view(User $user, GroupInvitation $groupInvitation)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $group = request()->route('group');
        $isMember = GroupMember::where([
            ['user_id', $user->id],
            ['group_id', $group->id],
            ['user_id', $user->id],
            ['role', 'member']
        ])->exists();
        return $user->id === $group->user_id || $isMember;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsGroupInvitation  $modelsGroupInvitation
     * @return mixed
     */
    public function update(User $user, GroupInvitation $invitation)
    {
        return $user->id === $invitation->invited_user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsGroupInvitation  $modelsGroupInvitation
     * @return mixed
     */
    public function delete(User $user, GroupInvitation $invitation)
    {
        return $user->id === $invitation->invited_user_id || $user->id === $invitation->user_id;
    }
}
