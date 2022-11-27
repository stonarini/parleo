<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
		$users = User::all();
		$communities = Community::all();

		// Generate king (aka admin/creator) role for each community
		Role::factory(sizeof($communities))
			->sequence(fn ($s) => ['community_id' => $s->index+1])
			->state(fn (array $a) => ["user_id" => fake()->unique()
				// Filter users that already are in the current community
				->randomElement($users->filter(fn ($u) => 0 == in_array($a["community_id"], 
					$u->communities()->get()->map(fn ($c)=> $c->community_id)->toArray()))
				->map(fn ($u) => $u->id)),])
			->create(["name" => "king"]);
    }
}
