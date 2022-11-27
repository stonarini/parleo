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
			fake()->unique(reset: true)->randomElement();

		    $user_communities = array_map(fn ($c): int => $c["community_id"], $user->communities()->get()->toArray());
			
			$posts = Post::all();
			$ps = sizeof($posts);

			// Generate posts for user 
			Post::factory(rand(1, 5))
				->state(fn () => [
					"user_id" => $user->id, 
					"community_id" => fake()->randomElement($user_communities)
				])->create()->each(function ($p) {
					$all_tags = $p->community()->get()[0]->tags()->get();
					$tags = fake()->randomElements($all_tags, rand(0, sizeof($all_tags)));
					foreach($tags as $t) {
						PostTag::factory(sizeof($tags))->state(fn ()=> [
							"post_id" => $p->id,
							"tag_id" => $t->id,
						])->create();
					}
				});

			// Generate likes for posts 
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

			$comments = Comment::all();
			$cs = sizeof($comments);

			// Generate comments for posts 
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

			// Generate comments for comments
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
