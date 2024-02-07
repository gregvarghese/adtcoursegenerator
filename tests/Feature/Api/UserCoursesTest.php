<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Course;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCoursesTest extends TestCase
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
    public function it_gets_user_courses(): void
    {
        $user = User::factory()->create();
        $courses = Course::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.courses.index', $user));

        $response->assertOk()->assertSee($courses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_courses(): void
    {
        $user = User::factory()->create();
        $data = Course::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.courses.store', $user),
            $data
        );

        unset($data['complexity']);
        unset($data['target']);

        $this->assertDatabaseHas('courses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $course = Course::latest('id')->first();

        $this->assertEquals($user->id, $course->user_id);
    }
}
