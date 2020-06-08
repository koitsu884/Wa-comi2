<?php

namespace App;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Post;
use App\Models\UserProfile;
use App\Traits\Imageable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

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
        return $this->belongsToMany(Group::class)
            ->using(GroupMember::class)
            ->withPivot(['created_by', 'created_at', 'updated_at', 'role']);
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
