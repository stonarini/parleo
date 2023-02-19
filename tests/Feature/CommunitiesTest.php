<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Community;
use App\Models\User;
use Database\Seeders\CommunitySeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommunitiesTest extends TestCase
{
    public function test_can_fetch_all_communities()
    {
        $this->seed(CommunitySeeder::class);
        $community = Community::find(1);
        $user = User::factory()->create();
        $user->createToken("api");

        $response = $this->actingAs($user)->getJson("/api/communities");
        $response->assertOk();
        $response->assertJson(
            function (AssertableJson $json) use ($community) {
                $json->has(
                    'data',
                    10,
                    function (AssertableJson $json) use ($community) {
                        $json->where('id', $community->id)
                            ->where('name', $community->name)
                            ->where('description', $community->description)
                            ->where('banner', $community->banner);
                    }
                );
            }
        );
    }

    public function test_can_fetch_single_community()
    {
        $community = Community::find(1);
        $user = User::factory()->create();
        $user->createToken("api");

        $response = $this->actingAs($user)->getJson("/api/communities/1");
        $response->assertOk();
        $response->assertJson(
            function (AssertableJson $json) use ($community) {
                $json->where('data.id', $community->id)
                    ->where('data.name', $community->name)
                    ->where('data.description', $community->description)
                    ->where('data.banner', $community->banner);
            }
        );
    }

    public function test_can_create_community()
    {
        $user = User::factory()->create();
        $user->createToken("api");

        $response = $this->actingAs($user)->postJson("/api/communities", ["name" => "Test", "description" => "DTest", "banner" => "BTest"]);
        $response->assertCreated();
        $response->assertJson(
            function (AssertableJson $json) {
                $json->where('data.id', 11)
                    ->where('data.name', "Test")
                    ->where('data.description', "DTest")
                    ->where('data.banner', "BTest");
            }
        );
    }


    public function test_guests_cannot_create_community()
    {
        $response = $this->postJson("/api/communities", ["name" => "Test", "description" => "DTest", "banner" => "BTest"]);
        $response->assertUnauthorized();
        $response->assertJson(
            function (AssertableJson $json) {
                $json->where('message', "Unauthenticated.");
            }
        );
    }

    public function test_can_update_community()
    {
        $community = Community::find(11);
        $user = User::factory()->create();
        $user->createToken("api");

        $response = $this->actingAs($user)->patchJson("/api/communities/11", ["name" => "Changed"]);
        $response->assertOk();
        $response->assertJson(
            function (AssertableJson $json) use ($community) {
                $json->where('data.id', $community->id)
                    ->where('data.name', "Changed")
                    ->where('data.description', $community->description)
                    ->where('data.banner', $community->banner);
            }
        );
        $this->assertEquals("Changed", $community->refresh()->name);
    }

    public function test_can_delete_community()
    {
        $user = User::factory()->create();
        $user->createToken("api");

        $response = $this->actingAs($user)->deleteJson("/api/communities/11");
        $response->assertNoContent();
        $this->assertEmpty(Community::find(11));
    }

    public function test_can_return_a_json_api_error_object_when_a_community_is_not_found()
    {
        $user = User::factory()->create();
        $user->createToken("api");

        $response = $this->actingAs($user)->getJson("/api/communities/11");
        $response->assertNotFound();
        $response->assertJson(
            function (AssertableJson $json) {
                $json->has(
                    'errors',
                    1,
                    function (AssertableJson $json) {
                        $json->where('status', 404)
                            ->where('title', 'Resource Not found')
                            ->where('detail', 'The requested resource could not be found');
                    }
                );
            }
        );
    }
}
