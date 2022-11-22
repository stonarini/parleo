<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

	protected $table = "likes";
	public $timestamps = false;

    protected $fillable = [
        'type',
	];

	public function user() 
	{
		return $this->belongsTo(User::class);
	}

	public function comment() 
	{
		return $this->belongsTo(Comment::class);
	}

	public function post() 
	{
		return $this->belongsTo(Post::class);
	}

}
