<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Topic;
use App\Models\Course;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseTopicsTest extends TestCase
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
    public function it_gets_course_topics(): void
    {
        $course = Course::factory()->create();
        $topics = Topic::factory()
            ->count(2)
            ->create([
                'course_id' => $course->id,
            ]);

        $response = $this->getJson(route('api.courses.topics.index', $course));

        $response->assertOk()->assertSee($topics[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_course_topics(): void
    {
        $course = Course::factory()->create();
        $data = Topic::factory()
            ->make([
                'course_id' => $course->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.courses.topics.store', $course),
            $data
        );

        unset($data['markdown']);

        $this->assertDatabaseHas('topics', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $topic = Topic::latest('id')->first();

        $this->assertEquals($course->id, $topic->course_id);
    }
}
