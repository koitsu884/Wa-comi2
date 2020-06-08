<?php

namespace App\Traits;

use App\Models\Group;

trait GroupRelatable
{
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
