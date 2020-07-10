<?php

namespace App\Observers;

use App\Models\GroupMember;
use App\Models\GroupInvitation;

class GroupMemberObserver
{
    /**
     * Handle the group member "created" event.
     *
     * @param  \App\Models\GroupMember  $groupMember
     * @return void
     */
    public function created(GroupMember $groupMember)
    {
        $invitation = GroupInvitation::where([
            ['group_id', $groupMember->group_id],
            ['invited_user_id', $groupMember->user_id],
        ])->first();
        if($invitation){
            $invitation->delete();
        }
    }

    /**
     * Handle the group member "updated" event.
     *
     * @param  \App\Models\GroupMember  $groupMember
     * @return void
     */
    public function updated(GroupMember $groupMember)
    {
        //
    }

    /**
     * Handle the group member "deleted" event.
     *
     * @param  \App\Models\GroupMember  $groupMember
     * @return void
     */
    public function deleted(GroupMember $groupMember)
    {
        //
    }

    /**
     * Handle the group member "restored" event.
     *
     * @param  \App\Models\GroupMember  $groupMember
     * @return void
     */
    public function restored(GroupMember $groupMember)
    {
        //
    }

    /**
     * Handle the group member "force deleted" event.
     *
     * @param  \App\Models\GroupMember  $groupMember
     * @return void
     */
    public function forceDeleted(GroupMember $groupMember)
    {
        //
    }
}
