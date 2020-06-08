<?php

namespace App\Models;

use App\Traits\UserRelatable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use UserRelatable;

    protected $fillable = [
        'user_id',
        'comment',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }
}
