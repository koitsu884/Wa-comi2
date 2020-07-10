<?php

namespace App\Observers;

use App\User;
use App\Models\Group;
use App\Models\GroupInvitation;
use App\Notifications\GroupInvited;

class GroupInvitationObserver
{
    /**
     * Handle the group invitation "created" event.
     *
     * @param  \App\Models\GroupInvitation  $groupInvitation
     * @return void
     */
    public function created(GroupInvitation $groupInvitation)
    {
        $user = User::find($groupInvitation->invited_user_id);
        $invitedUser = User::find($groupInvitation->user_id);
        $group = Group::find($groupInvitation->group_id);

        $details = [
            'group_invitation_id' => $groupInvitation->id,
            "group_slug" => $group->slug,
            "group_name" => $group->name,
            "invite_user_name" => $invitedUser->name
        ];

        $user->notify(new GroupInvited($details));
    }

    /**
     * Handle the group invitation "updated" event.
     *
     * @param  \App\Models\GroupInvitation  $groupInvitation
     * @return void
     */
    public function updated(GroupInvitation $groupInvitation)
    {
        //
    }

    /**
     * Handle the group invitation "deleted" event.
     *
     * @param  \App\Models\GroupInvitation  $groupInvitation
     * @return void
     */
    public function deleted(GroupInvitation $groupInvitation)
    {
        //
    }

    /**
     * Handle the group invitation "restored" event.
     *
     * @param  \App\Models\GroupInvitation  $groupInvitation
     * @return void
     */
    public function restored(GroupInvitation $groupInvitation)
    {
        //
    }

    /**
     * Handle the group invitation "force deleted" event.
     *
     * @param  \App\Models\GroupInvitation  $groupInvitation
     * @return void
     */
    public function forceDeleted(GroupInvitation $groupInvitation)
    {
        //
    }
}
