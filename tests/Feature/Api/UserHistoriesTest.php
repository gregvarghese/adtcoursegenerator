<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\History;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserHistoriesTest extends TestCase
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
    public function it_gets_user_histories(): void
    {
        $user = User::factory()->create();
        $histories = History::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.histories.index', $user));

        $response->assertOk()->assertSee($histories[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_histories(): void
    {
        $user = User::factory()->create();
        $data = History::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.histories.store', $user),
            $data
        );

        unset($data['markdown']);
        unset($data['html']);

        $this->assertDatabaseHas('histories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $history = History::latest('id')->first();

        $this->assertEquals($user->id, $history->user_id);
    }
}
