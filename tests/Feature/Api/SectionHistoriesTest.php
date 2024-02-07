<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Section;
use App\Models\History;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionHistoriesTest extends TestCase
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
    public function it_gets_section_histories(): void
    {
        $section = Section::factory()->create();
        $histories = History::factory()
            ->count(2)
            ->create([
                'section_id' => $section->id,
            ]);

        $response = $this->getJson(
            route('api.sections.histories.index', $section)
        );

        $response->assertOk()->assertSee($histories[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_section_histories(): void
    {
        $section = Section::factory()->create();
        $data = History::factory()
            ->make([
                'section_id' => $section->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sections.histories.store', $section),
            $data
        );

        unset($data['markdown']);
        unset($data['html']);

        $this->assertDatabaseHas('histories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $history = History::latest('id')->first();

        $this->assertEquals($section->id, $history->section_id);
    }
}
