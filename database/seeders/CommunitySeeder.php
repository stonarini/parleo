<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    public function run()
    {
		Community::factory(10)->create()
			// Generate tags for community
			->each(fn ($c) => Tag::factory(rand(1, 4))->create(["community_id" => $c->id]));
    }
}
