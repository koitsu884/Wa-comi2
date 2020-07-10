<?php

namespace App;

use App\Models\Post;
use App\Models\Group;
use App\Traits\Imageable;
use App\Models\GroupMember;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use App\Models\GroupInvitation;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, Imageable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'introduction',
        // 'avatar',
        'twitter',
        'facebook',
        'instagram',
        'admin',
        'verification_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class)->with(['category']);
    }

    public function groups()
    {
        return $this->hasMany(Group::class)->with(['category']);
    }

    public function supportGroups()
    {
        return $this->belongsToMany(Group::class, 'group_member')
            ->using(GroupMember::class)
            ->wherePivot('role', 'member');

        // return $this->belongsToMany(Group::class, 'group_member')
        //     ->using(GroupMember::class)
        //     ->withPivot('role', 'member');
    }

    public function groupInvitations()
    {
        return $this->hasMany(GroupInvitation::class, 'invited_user_id')->with('user')->with('group');
        // return $this->belongsToMany(Group::class, 'group_invitations', 'invited_user_id')
        // ->using(GroupInvitation::class)
        // ->withPivot(['message', 'status', 'user_id']);
    }

    public static function generateVerificationCode()
    {
        return Str::random(40);
    }

    public function isVerified()
    {
        return $this->email_verified_at !== null;
    }

    public function isAdmin()
    {
        return $this->admin ? true : false;
    }
}
