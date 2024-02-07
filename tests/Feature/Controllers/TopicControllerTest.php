<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Topic;

use App\Models\Course;
use App\Models\Section;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicControllerTest extends TestCase
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
    public function it_displays_index_view_with_topics(): void
    {
        $topics = Topic::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('topics.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.topics.index')
            ->assertViewHas('topics');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_topic(): void
    {
        $response = $this->get(route('topics.create'));

        $response->assertOk()->assertViewIs('app.topics.create');
    }

    /**
     * @test
     */
    public function it_stores_the_topic(): void
    {
        $data = Topic::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('topics.store'), $data);

        unset($data['markdown']);

        $this->assertDatabaseHas('topics', $data);

        $topic = Topic::latest('id')->first();

        $response->assertRedirect(route('topics.edit', $topic));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_topic(): void
    {
        $topic = Topic::factory()->create();

        $response = $this->get(route('topics.show', $topic));

        $response
            ->assertOk()
            ->assertViewIs('app.topics.show')
            ->assertViewHas('topic');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_topic(): void
    {
        $topic = Topic::factory()->create();

        $response = $this->get(route('topics.edit', $topic));

        $response
            ->assertOk()
            ->assertViewIs('app.topics.edit')
            ->assertViewHas('topic');
    }

    /**
     * @test
     */
    public function it_updates_the_topic(): void
    {
        $topic = Topic::factory()->create();

        $section = Section::factory()->create();
        $course = Course::factory()->create();
        $user = User::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'prompt' => $this->faker->text(),
            'json' => $this->faker->text(),
            'markdown' => $this->faker->text(),
            'html' => $this->faker->text(),
            'complete' => $this->faker->boolean(),
            'section_id' => $section->id,
            'course_id' => $course->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(route('topics.update', $topic), $data);

        unset($data['markdown']);

        $data['id'] = $topic->id;

        $this->assertDatabaseHas('topics', $data);

        $response->assertRedirect(route('topics.edit', $topic));
    }

    /**
     * @test
     */
    public function it_deletes_the_topic(): void
    {
        $topic = Topic::factory()->create();

        $response = $this->delete(route('topics.destroy', $topic));

        $response->assertRedirect(route('topics.index'));

        $this->assertModelMissing($topic);
    }
}
