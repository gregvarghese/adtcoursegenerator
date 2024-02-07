<?php

namespace Database\Factories;

use App\Models\History;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = History::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prompt' => $this->faker->text(),
            'json' => $this->faker->text(),
            'markdown' => $this->faker->text(),
            'html' => $this->faker->text(),
            'topic_id' => \App\Models\Topic::factory(),
            'section_id' => \App\Models\Section::factory(),
            'course_id' => \App\Models\Course::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
