<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\History;

use App\Models\Topic;
use App\Models\Course;
use App\Models\Section;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryTest extends TestCase
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
    public function it_gets_histories_list(): void
    {
        $histories = History::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.histories.index'));

        $response->assertOk()->assertSee($histories[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_history(): void
    {
        $data = History::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.histories.store'), $data);

        unset($data['markdown']);
        unset($data['html']);

        $this->assertDatabaseHas('histories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_history(): void
    {
        $history = History::factory()->create();

        $topic = Topic::factory()->create();
        $section = Section::factory()->create();
        $course = Course::factory()->create();
        $user = User::factory()->create();

        $data = [
            'prompt' => $this->faker->text(),
            'json' => $this->faker->text(),
            'markdown' => $this->faker->text(),
            'html' => $this->faker->text(),
            'topic_id' => $topic->id,
            'section_id' => $section->id,
            'course_id' => $course->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.histories.update', $history),
            $data
        );

        unset($data['markdown']);
        unset($data['html']);

        $data['id'] = $history->id;

        $this->assertDatabaseHas('histories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_history(): void
    {
        $history = History::factory()->create();

        $response = $this->deleteJson(route('api.histories.destroy', $history));

        $this->assertModelMissing($history);

        $response->assertNoContent();
    }
}
