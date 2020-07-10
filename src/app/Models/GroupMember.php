<?php

namespace App\Models;

use App\Traits\GroupRelatable;
use App\Traits\UserRelatable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupMember extends Pivot
{
    use UserRelatable;
    use GroupRelatable;

    protected $table="group_member";

    protected $fillable = [
        'user_id',
        'group_id',
        'invited_by',
        'role'
    ];

    public function invited_by_user()
    {
        return $this->belongsTo(User::class, 'invited_by');
    } 
}
