<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentable extends Model
{
	use HasFactory;

	protected $table = "commentable";
	public $timestamps = false;

	public function comment()
	{
		return $this->belongsTo(Comment::class);
	}
	
}
