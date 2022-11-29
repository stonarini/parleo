<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Commentable;
use App\Models\Community;
use App\Models\Like;
use App\Models\Likeable;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
		// Run after the CommunitySeeder
		$communities = Community::all();

		User::factory(20)->create()->each(function ($user) use ($communities) {
			// Generate roles (aka subscribe to community) for users
			Role::factory(rand(1, sizeof($communities)))
				->state(fn () => [
					// 10% of getting 'noble' (aka moderator)
					"name" => fake()->optional($weight = 0.9, $default = "noble")->passthrough("peasant"),
					"user_id" => $user->id,
					"community_id" => fake()->unique()->randomElement($communities)
				])->create();
			// Faker's "randomElement" method must be resetted every time
			// because for Faker the ids are just numbers
 	 		fake()->unique(reset: true)->randomElement();

			// Get the user communities' ids
		    $user_communities = array_map(fn ($c): int => $c["community_id"], $user->communities()->get()->toArray());
			
			// Get all post before creating new ones.
			// This is useful later for the likes and comments
			$posts = Post::all();
			$ps = sizeof($posts);

			// Generate posts for user 
			Post::factory(rand(1, 5))
				->state(fn () => [
					"user_id" => $user->id, 
					"community_id" => fake()->randomElement($user_communities)
				])->create()->each(function ($p) {
					// Get the tags of the community of the post
					$all_tags = $p->community()->get()[0]->tags()->get();
					// And assign them at random
					$tags = fake()->randomElements($all_tags, rand(0, sizeof($all_tags)));
					foreach($tags as $t) {
						PostTag::factory(sizeof($tags))->state(fn ()=> [
							"post_id" => $p->id,
							"tag_id" => $t->id,
						])->create();
					}
				});

			// Generate likes for posts (min: 0, max: 10)
			// The posts do not include the ones of the users (see line 40)
			Like::factory(rand(0, $ps > 0 ? $ps < 10 ? $ps : 10 : 0))
				->state(fn () => ["user_id" => $user->id])
				->create()->each(function ($l) use ($posts, $user) {
					Likeable::factory()->state(fn () => [
						"like_id" => $l->id,
						"likeable_type" => "post",
						"likeable_id" =>fake()->unique()->randomElement($posts), 
					])->create();
				});
			fake()->unique(reset: true)->randomElement();

			// Same as we did for the post (line 40)
			$comments = Comment::all();
			$cs = sizeof($comments);

			// Generate comments for posts 
			// The max number will be one comment for each post of the site
			// The posts do not include the ones of the users (see line 40)
			Comment::factory(rand(0, sizeof($posts)))
				->state(fn () => ["user_id" => $user->id])
				->create()->each(function ($c) use ($posts, $user) {
					Commentable::factory()->state(fn () => [
						"comment_id" => $c->id,
						"commentable_type" => "post",
						"commentable_id" =>fake()->unique()->randomElement($posts), 
					])->create();
				});
			fake()->unique(reset: true)->randomElement();

			// Generate comments for comments (min: 0, max: 10)
			// The comments do not include the ones of the users (see line 76)
			Comment::factory(rand(0, $cs > 0 ? $cs < 10 ? $cs : 10 : 0))
				->state(fn () => ["user_id" => $user->id])
				->create()->each(function ($c) use ($comments, $user) {
					Commentable::factory()->state(fn () => [
						"comment_id" => $c->id,
						"commentable_type" => "comment",
						"commentable_id" =>fake()->unique()->randomElement($comments), 
					])->create();
				});
			fake()->unique(reset: true)->randomElement();

			// Generate likes for comments
			// The comments do not include the ones of the users (see line 76)
			Like::factory(rand(0, $cs > 0 ? $cs < 10 ? $cs : 10 : 0))
				->state(fn () => ["user_id" => $user->id])
				->create()->each(function ($l) use ($comments, $user) {
					Likeable::factory()->state(fn () => [
						"like_id" => $l->id,
						"likeable_type" => "comment",
						"likeable_id" =>fake()->unique()->randomElement($comments), 
					])->create();
				});
			fake()->unique(reset: true)->randomElement();
		});
    }
}
