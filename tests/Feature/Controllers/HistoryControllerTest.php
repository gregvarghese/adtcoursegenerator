<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\History;

use App\Models\Topic;
use App\Models\Course;
use App\Models\Section;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_histories(): void
    {
        $histories = History::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('histories.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.histories.index')
            ->assertViewHas('histories');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_history(): void
    {
        $response = $this->get(route('histories.create'));

        $response->assertOk()->assertViewIs('app.histories.create');
    }

    /**
     * @test
     */
    public function it_stores_the_history(): void
    {
        $data = History::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('histories.store'), $data);

        unset($data['markdown']);
        unset($data['html']);

        $this->assertDatabaseHas('histories', $data);

        $history = History::latest('id')->first();

        $response->assertRedirect(route('histories.edit', $history));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_history(): void
    {
        $history = History::factory()->create();

        $response = $this->get(route('histories.show', $history));

        $response
            ->assertOk()
            ->assertViewIs('app.histories.show')
            ->assertViewHas('history');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_history(): void
    {
        $history = History::factory()->create();

        $response = $this->get(route('histories.edit', $history));

        $response
            ->assertOk()
            ->assertViewIs('app.histories.edit')
            ->assertViewHas('history');
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

        $response = $this->put(route('histories.update', $history), $data);

        unset($data['markdown']);
        unset($data['html']);

        $data['id'] = $history->id;

        $this->assertDatabaseHas('histories', $data);

        $response->assertRedirect(route('histories.edit', $history));
    }

    /**
     * @test
     */
    public function it_deletes_the_history(): void
    {
        $history = History::factory()->create();

        $response = $this->delete(route('histories.destroy', $history));

        $response->assertRedirect(route('histories.index'));

        $this->assertModelMissing($history);
    }
}
