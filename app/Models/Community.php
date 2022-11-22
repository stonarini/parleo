<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{

	protected $table = "communities";
	public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'banner',
    ];

	public function users() 
	{
		return $this->hasMany(Role::class);
	}

	public function tags() 
	{
		return $this->hasMany(Tag::class);
	}

	public function posts() 
	{
		return $this->hasMany(Post::class);
	}

}
