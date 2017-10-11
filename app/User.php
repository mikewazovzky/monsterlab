<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirmation_token', 'role', 'avatar_path',
    ];

    /**
     * The attributes that should be hidden for arrays (toArray()) and json (json_encode()).
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirmation_token', 'email', 'created_at', 'updated_at',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function confirm()
    {
        $this->update([
            'role' => 'writer',
            'confirmation_token' => null,
        ]);
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isReader()
    {
        return $this->role == 'reader';
    }

    public function isWriter()
    {
        return $this->role == 'writer';
    }

    public static function admin()
    {
        return User::where('role', 'admin')->first();
    }

    public function getAvatarPathAttribute($avatar)
    {
        // return $avatar ? "/storage/{$avatar}" : '/images/default.png';
        return $avatar ? asset("/storage/{$avatar}") : asset('images/avatars/default.png');
    }
}
