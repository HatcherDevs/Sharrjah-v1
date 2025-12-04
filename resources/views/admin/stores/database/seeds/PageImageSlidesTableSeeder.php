<?php

use Illuminate\Database\Seeder;

class PageImageSlidesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('page_image_slides')->delete();
        
        \DB::table('page_image_slides')->insert(array (
            0 => 
            array (
                'id' => 2,
                'page_id' => 3,
                'created_at' => '2018-11-21 09:25:07',
                'updated_at' => '2018-11-21 09:25:07',
            ),
            1 => 
            array (
                'id' => 8,
                'page_id' => 2,
                'created_at' => '2018-11-22 05:59:34',
                'updated_at' => '2018-11-22 05:59:34',
            ),
            2 => 
            array (
                'id' => 9,
                'page_id' => 4,
                'created_at' => '2018-11-22 06:18:03',
                'updated_at' => '2018-11-22 06:18:03',
            ),
            3 => 
            array (
                'id' => 10,
                'page_id' => 4,
                'created_at' => '2018-11-22 06:18:03',
                'updated_at' => '2018-11-22 06:18:03',
            ),
            4 => 
            array (
                'id' => 11,
                'page_id' => 4,
                'created_at' => '2018-11-22 06:18:03',
                'updated_at' => '2018-11-22 06:18:03',
            ),
            5 => 
            array (
                'id' => 12,
                'page_id' => 4,
                'created_at' => '2018-11-22 06:18:03',
                'updated_at' => '2018-11-22 06:18:03',
            ),
            6 => 
            array (
                'id' => 13,
                'page_id' => 4,
                'created_at' => '2018-11-22 06:18:03',
                'updated_at' => '2018-11-22 06:18:03',
            ),
            7 => 
            array (
                'id' => 14,
                'page_id' => 10,
                'created_at' => '2018-11-22 11:08:19',
                'updated_at' => '2018-11-22 11:08:19',
            ),
            8 => 
            array (
                'id' => 15,
                'page_id' => 11,
                'created_at' => '2018-11-22 11:09:13',
                'updated_at' => '2018-11-22 11:09:13',
            ),
            9 => 
            array (
                'id' => 16,
                'page_id' => 18,
                'created_at' => '2018-11-22 11:57:49',
                'updated_at' => '2018-11-22 11:57:49',
            ),
            10 => 
            array (
                'id' => 17,
                'page_id' => 19,
                'created_at' => '2018-11-22 11:58:24',
                'updated_at' => '2018-11-22 11:58:24',
            ),
        ));
        
        
    }
}
