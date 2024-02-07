<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Greg Varghese',
                'email' => 'admin@admin.com',
                'email_verified_at' => '2024-02-04 20:29:44',
                'password' => '$2y$12$Eh0QDID4dJ/I4AOCKTRKvOGW6v3BrGooQkVgoeL9enMqFR6go02/i',
                'remember_token' => 'Ftbc0oxT2W',
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'two_factor_confirmed_at' => NULL,
                'current_team_id' => NULL,
                'profile_photo_path' => NULL,
                'created_at' => '2024-02-04 20:29:45',
                'updated_at' => '2024-02-04 20:29:45',
            ),
        ));
        
        
    }
}