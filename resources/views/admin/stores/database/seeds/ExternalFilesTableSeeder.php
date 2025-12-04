<?php

use Illuminate\Database\Seeder;

class ExternalFilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('external_files')->delete();
        
        \DB::table('external_files')->insert(array (
            0 => 
            array (
                'id' => 1,
                'post_id' => 18,
                'language' => 'ar',
                'created_at' => '2018-11-22 12:21:08',
                'updated_at' => '2018-11-22 12:21:08',
            ),
            1 => 
            array (
                'id' => 2,
                'post_id' => 18,
                'language' => 'en',
                'created_at' => '2018-11-22 12:21:08',
                'updated_at' => '2018-11-22 12:21:08',
            ),
            2 => 
            array (
                'id' => 3,
                'post_id' => 19,
                'language' => 'ar',
                'created_at' => '2018-11-22 12:21:43',
                'updated_at' => '2018-11-22 12:21:43',
            ),
            3 => 
            array (
                'id' => 4,
                'post_id' => 19,
                'language' => 'en',
                'created_at' => '2018-11-22 12:21:43',
                'updated_at' => '2018-11-22 12:21:43',
            ),
            4 => 
            array (
                'id' => 5,
                'post_id' => 20,
                'language' => 'ar',
                'created_at' => '2018-11-22 12:22:17',
                'updated_at' => '2018-11-22 12:22:17',
            ),
            5 => 
            array (
                'id' => 6,
                'post_id' => 20,
                'language' => 'en',
                'created_at' => '2018-11-22 12:22:18',
                'updated_at' => '2018-11-22 12:22:18',
            ),
            6 => 
            array (
                'id' => 7,
                'post_id' => 21,
                'language' => 'ar',
                'created_at' => '2018-11-22 12:22:45',
                'updated_at' => '2018-11-22 12:22:45',
            ),
            7 => 
            array (
                'id' => 8,
                'post_id' => 21,
                'language' => 'en',
                'created_at' => '2018-11-22 12:22:45',
                'updated_at' => '2018-11-22 12:22:45',
            ),
        ));
        
        
    }
}
