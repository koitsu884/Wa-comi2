<?php

namespace App\Models;

use App\User;
use App\Models\GroupPost;
use App\Traits\Imageable;
use App\Traits\Searchable;
use App\Traits\UserRelatable;
use App\Models\GroupInvitation;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use UserRelatable;
    use Imageable;
    use Searchable;

    protected $fillable = [
        'slug',
        'user_id',
        'group_category_id',
        'area_id',
        'name',
        'description',
        'is_public',
        'homepage',
        'facebook',
        'twitter',
        'instagram'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(GroupCategory::class, 'group_category_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_member')
            ->using(GroupMember::class)
            ->wherePivot('role', 'member');
    }

    public function invitedUsers()
    {
        return $this->belongsToMany(User::class)
                    ->using(GroupInvitation::class);
    }

    public function invitations()
    {
        return $this->hasMany(GroupInvitation::class)->with('user')->with('invited_user');
    }

    public function posts()
    {
        return $this->hasMany(GroupPost::class)->orderBy('updated_at', 'desc')->with('user');
    }

    public function groupPostImages()
    {
        //TODO get all group post images (Has many through?)
    }
}
