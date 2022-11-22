<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	protected $table = "posts";
	public $timestamps = false;

    protected $fillable = [
        'title',
        'content',
        'image',
    ];

	public function user() 
	{
		return $this->belongsTo(User::class);
	}

	public function community()
	{
		return $this->belongsTo(Community::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class);
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
