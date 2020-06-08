<?php

namespace App\Models;

use App\Traits\GroupRelatable;
use App\Traits\UserRelatable;
use Illuminate\Database\Eloquent\Model;

class GroupImage extends Model
{
    use UserRelatable;
    use GroupRelatable;

    protected $fillable = [
        'group_id',
        'user_id',
        'url',
        'url_thumb',
    ];
}
