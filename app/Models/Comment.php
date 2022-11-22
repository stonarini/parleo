<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

	protected $table = "comments";
	public $timestamps = false;

    protected $fillable = [
        'content',
        'image',
    ];

	public function user() 
	{
		return $this->belongsTo(User::class);
	}

	public function post()
	{
		return $this->belongsTo(Post::class);
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
