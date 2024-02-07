<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
				'name' => 'Greg Varghese', // Add a name
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

		$course = Course::factory()->count(1)->create([
			'name' => 'Digital Marketing',
			'description' => 'This course is designed to help you understand all aspects of digital marketing.',
			'complexity' => 'average',
			'target' => 'beginners',
			'user_id' => $user->first()->id,
		]);

		Section::factory()->count(1)->create([
			'name' => 'Introduction to Digital Marketing',
			'description' => 'This section will introduce you to the world of digital marketing.',
			'course_id' => $course->first()->id,
		]);

//        $this->call(CourseSeeder::class);
//        $this->call(HistorySeeder::class);
//        $this->call(SectionSeeder::class);
//        $this->call(TopicSeeder::class);
//        $this->call(UserSeeder::class);
    }
}
