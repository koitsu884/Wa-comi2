<?php

namespace App\Traits;

use App\User;

trait UserRelatable
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
