<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

	protected $table = "tags";
	public $timestamps = false;

    protected $fillable = [
        'name',
    ];

	public function community() 
	{
		return $this->belongsTo(Community::class);
	}

	public function posts()
	{
		return $this->belongsToMany(Post::class);
	}
}
