<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('courses')->delete();
        
        \DB::table('courses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Digital Marketing',
                'description' => '<p>This course will cover the foundational terminology for digital marketing, spanning different disciplines. It\'s a crash course in important terminology, complete with real-world examples. Whether you\'re a marketer, developer, artist, writer, or leader, everyone involved in digital should know and understand these terms. &nbsp;</p><p>Each topic will be broken down to cover an easy-to-understand description, examples of how it would be used in real-world scenarios, and often used tools/platforms. Please note that any listed tools should be considered recommendations/preferences and, in most cases, are not listed in any particular order.&nbsp;</p>',
                'complexity' => 'average',
                'target' => 'beginners',
                'user_id' => 1,
                'created_at' => '2024-02-04 20:29:45',
                'updated_at' => '2024-02-04 20:55:57',
            ),
        ));
        
        
    }
}