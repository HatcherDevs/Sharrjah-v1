<?php

use Illuminate\Database\Seeder;

class PostImageSlidesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('post_image_slides')->delete();
        
        \DB::table('post_image_slides')->insert(array (
            0 => 
            array (
                'id' => 1,
                'post_id' => 6,
                'created_at' => '2018-11-21 14:21:04',
                'updated_at' => '2018-11-21 14:21:04',
            ),
            1 => 
            array (
                'id' => 2,
                'post_id' => 9,
                'created_at' => '2018-11-21 14:23:07',
                'updated_at' => '2018-11-21 14:23:07',
            ),
            2 => 
            array (
                'id' => 3,
                'post_id' => 8,
                'created_at' => '2018-11-21 14:23:18',
                'updated_at' => '2018-11-21 14:23:18',
            ),
            3 => 
            array (
                'id' => 4,
                'post_id' => 7,
                'created_at' => '2018-11-22 05:58:11',
                'updated_at' => '2018-11-22 05:58:11',
            ),
            4 => 
            array (
                'id' => 9,
                'post_id' => 1,
                'created_at' => '2018-11-22 06:38:30',
                'updated_at' => '2018-11-22 06:38:30',
            ),
            5 => 
            array (
                'id' => 10,
                'post_id' => 5,
                'created_at' => '2018-11-22 06:39:50',
                'updated_at' => '2018-11-22 06:39:50',
            ),
            6 => 
            array (
                'id' => 11,
                'post_id' => 4,
                'created_at' => '2018-11-22 06:40:33',
                'updated_at' => '2018-11-22 06:40:33',
            ),
            7 => 
            array (
                'id' => 12,
                'post_id' => 3,
                'created_at' => '2018-11-22 06:41:34',
                'updated_at' => '2018-11-22 06:41:34',
            ),
            8 => 
            array (
                'id' => 13,
                'post_id' => 2,
                'created_at' => '2018-11-22 06:42:04',
                'updated_at' => '2018-11-22 06:42:04',
            ),
            9 => 
            array (
                'id' => 14,
                'post_id' => 13,
                'created_at' => '2018-11-22 11:23:17',
                'updated_at' => '2018-11-22 11:23:17',
            ),
            10 => 
            array (
                'id' => 15,
                'post_id' => 15,
                'created_at' => '2018-11-22 11:33:24',
                'updated_at' => '2018-11-22 11:33:24',
            ),
            11 => 
            array (
                'id' => 16,
                'post_id' => 14,
                'created_at' => '2018-11-22 11:34:10',
                'updated_at' => '2018-11-22 11:34:10',
            ),
            12 => 
            array (
                'id' => 17,
                'post_id' => 18,
                'created_at' => '2018-11-22 12:23:02',
                'updated_at' => '2018-11-22 12:23:02',
            ),
            13 => 
            array (
                'id' => 18,
                'post_id' => 19,
                'created_at' => '2018-11-22 12:23:08',
                'updated_at' => '2018-11-22 12:23:08',
            ),
            14 => 
            array (
                'id' => 19,
                'post_id' => 20,
                'created_at' => '2018-11-22 12:23:15',
                'updated_at' => '2018-11-22 12:23:15',
            ),
            15 => 
            array (
                'id' => 20,
                'post_id' => 21,
                'created_at' => '2018-11-22 12:23:23',
                'updated_at' => '2018-11-22 12:23:23',
            ),
        ));
        
        
    }
}
