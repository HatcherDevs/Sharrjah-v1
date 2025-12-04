<?php

use Illuminate\Database\Seeder;

class LandingElementsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('landing_elements')->delete();
        
        \DB::table('landing_elements')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Sea view',
                'title_ar' => 'Sea view',
                'order' => NULL,
                'is_main' => 0,
                'active' => 1,
                'created_at' => '2018-11-22 05:56:47',
                'updated_at' => '2018-11-22 05:56:47',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Construction',
                'title_ar' => 'Construction',
                'order' => NULL,
                'is_main' => 0,
                'active' => 1,
                'created_at' => '2018-11-22 05:56:57',
                'updated_at' => '2018-11-22 05:56:57',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Beach View',
                'title_ar' => 'Beach View',
                'order' => NULL,
                'is_main' => 0,
                'active' => 1,
                'created_at' => '2018-11-22 05:57:06',
                'updated_at' => '2018-11-22 05:57:06',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Parking View',
                'title_ar' => 'Parking View',
                'order' => NULL,
                'is_main' => 0,
                'active' => 1,
                'created_at' => '2018-11-22 05:57:16',
                'updated_at' => '2018-11-22 05:57:16',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Highway',
                'title_ar' => 'Highway',
                'order' => NULL,
                'is_main' => 0,
                'active' => 1,
                'created_at' => '2018-11-22 05:57:27',
                'updated_at' => '2018-11-22 05:57:27',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Smile',
                'title_ar' => 'Smile',
                'order' => NULL,
                'is_main' => 0,
                'active' => 1,
                'created_at' => '2018-11-22 05:57:37',
                'updated_at' => '2018-11-22 05:57:37',
            ),
        ));
        
        
    }
}
