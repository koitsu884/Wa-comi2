<?php

namespace App\Policies;

use App\User;
use App\Models\GroupPost;
use App\Models\GroupMember;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPostPolicy
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
     * @param  \App\Models\GroupPost  $groupPost
     * @return mixed
     */
    public function view(User $user, GroupPost $groupPost)
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
     * @param  \App\Models\GroupPost  $groupPost
     * @return mixed
     */
    public function update(User $user, GroupPost $post)
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\GroupPost  $groupPost
     * @return mixed
     */
    public function delete(User $user, GroupPost $post)
    {
        $groupOwnerId = request()->route('group')->user_id;
        return $user->id === $post->user_id || $user->id === $groupOwnerId;
    }
}
