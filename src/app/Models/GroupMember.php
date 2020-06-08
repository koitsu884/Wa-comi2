<?php

namespace App\Models;

use App\Traits\GroupRelatable;
use App\Traits\UserRelatable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupMember extends Pivot
{
    use UserRelatable;
    use GroupRelatable;

    protected $fillable = [
        'user_id',
        'group_id',
        'created_by',
        'role'
    ];
}
