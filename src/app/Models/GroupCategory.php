<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
