<?php

namespace App\Models;

use App\Traits\UserRelatable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use UserRelatable;

    protected $fillable = [
        'user_id',
        'comment_id',
        'reply',
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
