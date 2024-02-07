<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Introduction to Digital Marketing',
                'description' => 'This section will introduce you to the world of digital marketing.',
                'course_id' => 1,
                'user_id' => 1,
                'created_at' => '2024-02-04 20:29:46',
                'updated_at' => '2024-02-04 20:56:34',
            ),
        ));
        
        
    }
}