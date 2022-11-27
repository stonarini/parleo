<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
	use HasFactory;

	protected $table = "likes";
	public $timestamps = false;

    protected $fillable = [
        'type',
	];

	public function user() 
	{
		return $this->belongsTo(User::class);
	}

	public function liked() 
	{
		$post = $this->morphTo(Post::class, "likeable"); 
		$comment = $this->morphTo(Comment::class, "likeable"); 
		return $post ?? $comment;
	}
}
