<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Topic;
use App\Models\Section;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionTopicsTest extends TestCase
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
    public function it_gets_section_topics(): void
    {
        $section = Section::factory()->create();
        $topics = Topic::factory()
            ->count(2)
            ->create([
                'section_id' => $section->id,
            ]);

        $response = $this->getJson(
            route('api.sections.topics.index', $section)
        );

        $response->assertOk()->assertSee($topics[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_section_topics(): void
    {
        $section = Section::factory()->create();
        $data = Topic::factory()
            ->make([
                'section_id' => $section->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sections.topics.store', $section),
            $data
        );

        unset($data['markdown']);

        $this->assertDatabaseHas('topics', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $topic = Topic::latest('id')->first();

        $this->assertEquals($section->id, $topic->section_id);
    }
}
