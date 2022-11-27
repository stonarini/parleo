<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	use HasFactory;

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

	public function parent()
	{
		$post = $this->morphTo(Post::class, "commentable");
		$comment = $this->morphTo(Comment::class, "commentable");
		return $post ?? $comment;
	}

	public function comments()
	{
		return $this->morphToMany(Comment::class, "commentable");
	}

	public function likes()
	{
		return $this->hasMany(Like::class);
	}
	
}
