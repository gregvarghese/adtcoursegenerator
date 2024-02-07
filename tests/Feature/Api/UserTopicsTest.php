<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Topic;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTopicsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_user_topics(): void
    {
        $user = User::factory()->create();
        $topics = Topic::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.topics.index', $user));

        $response->assertOk()->assertSee($topics[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_user_topics(): void
    {
        $user = User::factory()->create();
        $data = Topic::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.topics.store', $user),
            $data
        );

        unset($data['markdown']);

        $this->assertDatabaseHas('topics', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $topic = Topic::latest('id')->first();

        $this->assertEquals($user->id, $topic->user_id);
    }
}
