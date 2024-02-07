<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Topic;
use App\Models\History;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicHistoriesTest extends TestCase
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
    public function it_gets_topic_histories(): void
    {
        $topic = Topic::factory()->create();
        $histories = History::factory()
            ->count(2)
            ->create([
                'topic_id' => $topic->id,
            ]);

        $response = $this->getJson(route('api.topics.histories.index', $topic));

        $response->assertOk()->assertSee($histories[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_topic_histories(): void
    {
        $topic = Topic::factory()->create();
        $data = History::factory()
            ->make([
                'topic_id' => $topic->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.topics.histories.store', $topic),
            $data
        );

        unset($data['markdown']);
        unset($data['html']);

        $this->assertDatabaseHas('histories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $history = History::latest('id')->first();

        $this->assertEquals($topic->id, $history->topic_id);
    }
}
