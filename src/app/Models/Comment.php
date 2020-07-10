<?php

namespace App\Models;

use App\Traits\UserRelatable;
use App\Http\Resources\ReplyResource;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use UserRelatable;

    protected $table = 'comments';

    protected $fillable = [
        'user_id',
        'comment',
    ];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function replyCount()
    {
        return $this->replies()->count();
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
