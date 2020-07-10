<?php

namespace App\Models;

use App\Traits\Imageable;
use App\Traits\Commentable;
use App\Traits\UserRelatable;
use App\Traits\GroupRelatable;
use Illuminate\Database\Eloquent\Model;

class GroupPost extends Model
{
    use UserRelatable;
    use GroupRelatable;
    use Commentable;
    use Imageable;

    protected $fillable = [
        'user_id',
        'group_id',
        'title',
        'content',
        'youtube'
    ];
}
