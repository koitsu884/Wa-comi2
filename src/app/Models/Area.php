<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'name',
    ];

    // public function groups()
    // {
    //     return $this->belongsToMany(Group::class);
    // }

    // public function posts()
    // {
    //     return $this->belongsToMany(Post::class);
    // }
}
