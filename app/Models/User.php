<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

	protected $table = "users";
	public $timestamps = false;
	
    protected $fillable = [
        'name',
        'email',
        'password',
		'picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

	protected $attributes = [
		'picture' => "/img/u/default",
	];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function communities()
	{
		return $this->hasMany(Role::class);
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function comments() 
	{
		return $this->hasMany(Comment::class);
	}

	public function likes()
	{
		return $this->hasMany(Like::class);
	}
}
