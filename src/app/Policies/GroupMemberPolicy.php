<?php

namespace App\Policies;

use App\User;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupMemberPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\GroupMember  $groupMember
     * @return mixed
     */
    public function view(User $user, GroupMember $member)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Group $group)
    {
        return $user->id === $group->user_id;
        //TODO: If user is support member, they might be allowed to add member (Need to add permission column for group member)
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\GroupMember  $groupMember
     * @return mixed
     */
    public function update(User $user, Group $group, GroupMember $member)
    {
        return $user->id === $group->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\GroupMember  $groupMember
     * @return mixed
     */
    public function delete(User $user, Group $group, GroupMember $member)
    {
        return $user->id === $group->user_id || $user->id === $member->user_id;
    }
}
