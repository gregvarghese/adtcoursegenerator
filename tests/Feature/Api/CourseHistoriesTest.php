<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Course;
use App\Models\History;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseHistoriesTest extends TestCase
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
    public function it_gets_course_histories(): void
    {
        $course = Course::factory()->create();
        $histories = History::factory()
            ->count(2)
            ->create([
                'course_id' => $course->id,
            ]);

        $response = $this->getJson(
            route('api.courses.histories.index', $course)
        );

        $response->assertOk()->assertSee($histories[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_course_histories(): void
    {
        $course = Course::factory()->create();
        $data = History::factory()
            ->make([
                'course_id' => $course->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.courses.histories.store', $course),
            $data
        );

        unset($data['markdown']);
        unset($data['html']);

        $this->assertDatabaseHas('histories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $history = History::latest('id')->first();

        $this->assertEquals($course->id, $history->course_id);
    }
}
