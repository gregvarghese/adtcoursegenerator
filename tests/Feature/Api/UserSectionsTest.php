<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Section;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSectionsTest extends TestCase
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
    public function it_gets_user_sections(): void
    {
        $user = User::factory()->create();
        $sections = Section::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.sections.index', $user));

        $response->assertOk()->assertSee($sections[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_sections(): void
    {
        $user = User::factory()->create();
        $data = Section::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.sections.store', $user),
            $data
        );

        $this->assertDatabaseHas('sections', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $section = Section::latest('id')->first();

        $this->assertEquals($user->id, $section->user_id);
    }
}
