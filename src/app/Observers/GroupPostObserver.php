<?php

namespace App\Observers;

use App\Models\GroupPost;

class GroupPostObserver
{
    /**
     * Handle the group post "created" event.
     *
     * @param  \App\Models\GroupPost  $groupPost
     * @return void
     */
    public function created(GroupPost $groupPost)
    {
        //
    }

    /**
     * Handle the group post "updated" event.
     *
     * @param  \App\Models\GroupPost  $groupPost
     * @return void
     */
    public function updated(GroupPost $groupPost)
    {
        //
    }

    /**
     * Handle the group post "deleted" event.
     *
     * @param  \App\Models\GroupPost  $groupPost
     * @return void
     */
    public function deleted(GroupPost $post)
    {
        $post->deleteAllImages();
    }

    /**
     * Handle the group post "restored" event.
     *
     * @param  \App\Models\GroupPost  $groupPost
     * @return void
     */
    public function restored(GroupPost $groupPost)
    {
        //
    }

    /**
     * Handle the group post "force deleted" event.
     *
     * @param  \App\Models\GroupPost  $groupPost
     * @return void
     */
    public function forceDeleted(GroupPost $groupPost)
    {
        //
    }
}
