<?php

namespace App\Models;

use App\Traits\Imageable;
use App\Traits\Searchable;
use App\Traits\UserRelatable;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use UserRelatable;
    use Imageable;
    use Searchable;

    protected $fillable = [
        'user_id',
        'group_category_id',
        'area_id',
        'title',
        'description',
        'is_public',
        'homepage',
        'facebook',
        'twitter',
        'instagram'
    ];

    public function category()
    {
        return $this->belongsTo(GroupCategory::class, 'group_category_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(GroupMember::class)
            ->withPivot(['role', 'created_by', 'created_at', 'updated_at']);
    }
}
