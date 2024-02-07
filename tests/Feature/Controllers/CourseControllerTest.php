<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Course;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseControllerTest extends TestCase
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
    public function it_displays_index_view_with_courses(): void
    {
        $courses = Course::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('courses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.courses.index')
            ->assertViewHas('courses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_course(): void
    {
        $response = $this->get(route('courses.create'));

        $response->assertOk()->assertViewIs('app.courses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_course(): void
    {
        $data = Course::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('courses.store'), $data);

        unset($data['complexity']);
        unset($data['target']);

        $this->assertDatabaseHas('courses', $data);

        $course = Course::latest('id')->first();

        $response->assertRedirect(route('courses.edit', $course));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_course(): void
    {
        $course = Course::factory()->create();

        $response = $this->get(route('courses.show', $course));

        $response
            ->assertOk()
            ->assertViewIs('app.courses.show')
            ->assertViewHas('course');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_course(): void
    {
        $course = Course::factory()->create();

        $response = $this->get(route('courses.edit', $course));

        $response
            ->assertOk()
            ->assertViewIs('app.courses.edit')
            ->assertViewHas('course');
    }

    /**
     * @test
     */
    public function it_updates_the_course(): void
    {
        $course = Course::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->text(),
            'description' => $this->faker->text(),
            'complexity' => $this->faker->text(255),
            'target' => $this->faker->text(255),
            'user_id' => $user->id,
        ];

        $response = $this->put(route('courses.update', $course), $data);

        unset($data['complexity']);
        unset($data['target']);

        $data['id'] = $course->id;

        $this->assertDatabaseHas('courses', $data);

        $response->assertRedirect(route('courses.edit', $course));
    }

    /**
     * @test
     */
    public function it_deletes_the_course(): void
    {
        $course = Course::factory()->create();

        $response = $this->delete(route('courses.destroy', $course));

        $response->assertRedirect(route('courses.index'));

        $this->assertModelMissing($course);
    }
}
