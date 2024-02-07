<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topic::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'prompt' => $this->faker->text(),
            'json' => $this->faker->text(),
            'markdown' => $this->faker->text(),
            'html' => $this->faker->text(),
            'complete' => $this->faker->boolean(),
            'section_id' => \App\Models\Section::factory(),
            'course_id' => \App\Models\Course::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
