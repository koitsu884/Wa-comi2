<?php

namespace App\Models;

use App\Traits\UserRelatable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use UserRelatable;

    protected $fillable = [
        'user_id',
        'url',
        'url_thumb',
        'is_main',
        'path',
        'filename',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
