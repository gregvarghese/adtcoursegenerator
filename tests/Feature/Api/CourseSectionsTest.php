<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseSectionsTest extends TestCase
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
    public function it_gets_course_sections(): void
    {
        $course = Course::factory()->create();
        $sections = Section::factory()
            ->count(2)
            ->create([
                'course_id' => $course->id,
            ]);

        $response = $this->getJson(
            route('api.courses.sections.index', $course)
        );

        $response->assertOk()->assertSee($sections[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_course_sections(): void
    {
        $course = Course::factory()->create();
        $data = Section::factory()
            ->make([
                'course_id' => $course->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.courses.sections.store', $course),
            $data
        );

        $this->assertDatabaseHas('sections', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $section = Section::latest('id')->first();

        $this->assertEquals($course->id, $section->course_id);
    }
}
