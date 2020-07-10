<?php

namespace App\Observers;

use App\Models\GroupMember;
use App\Models\UserInvitation;

class UserInvitationObserver
{


    /**
     * Handle the user invitation "updated" event.
     *
     * @param  \App\Models\UserInvitation  $userInvitation
     * @return void
     */
    public function saved(UserInvitation $invitation)
    {
        if($invitation->status === 'accepted')
        {
            GroupMember::create([
                'user_id' => $invitation->invited_user_id,
                'group_id' => $invitation->group_id,
                'role' => 'member',
                'invited_by' => $invitation->user_id,
            ]);
        }
    }
}
