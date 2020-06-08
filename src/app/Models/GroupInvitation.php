<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupInvitation extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'message',
        'invited_by',
    ];
}
