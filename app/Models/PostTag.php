<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
	use HasFactory;

	protected $table = "posts_tags";
	public $timestamps = false;

	public function post() 
	{
		return $this->belongsTo(Post::class);
	}

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
