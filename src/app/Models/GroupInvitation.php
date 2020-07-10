<?php

namespace App\Models;

use App\User;
use App\Traits\UserRelatable;
use App\Traits\GroupRelatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupInvitation extends Pivot
{
    use UserRelatable;
    use GroupRelatable;

    public $incrementing = true;
    protected $table="group_invitations";

    protected $fillable = [
        'user_id',
        'group_id',
        'message',
        'invited_user_id',
    ];

    public function invited_user()
    {
        return $this->belongsTo(User::class, 'invited_user_id');
    }
}
