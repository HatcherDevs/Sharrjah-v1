<?php

use Illuminate\Database\Seeder;

class PageParentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('page_parents')->delete();
        
        \DB::table('page_parents')->insert(array (
            0 => 
            array (
                'page_id' => 2,
                'page_parent_id' => 1,
                'active' => 1,
            ),
            1 => 
            array (
                'page_id' => 3,
                'page_parent_id' => 1,
                'active' => 1,
            ),
            2 => 
            array (
                'page_id' => 4,
                'page_parent_id' => 1,
                'active' => 1,
            ),
            3 => 
            array (
                'page_id' => 5,
                'page_parent_id' => 1,
                'active' => 1,
            ),
            4 => 
            array (
                'page_id' => 6,
                'page_parent_id' => 1,
                'active' => 1,
            ),
            5 => 
            array (
                'page_id' => 7,
                'page_parent_id' => 1,
                'active' => 1,
            ),
            6 => 
            array (
                'page_id' => 8,
                'page_parent_id' => 1,
                'active' => 1,
            ),
            7 => 
            array (
                'page_id' => 10,
                'page_parent_id' => 9,
                'active' => 1,
            ),
            8 => 
            array (
                'page_id' => 11,
                'page_parent_id' => 9,
                'active' => 1,
            ),
            9 => 
            array (
                'page_id' => 12,
                'page_parent_id' => 9,
                'active' => 1,
            ),
            10 => 
            array (
                'page_id' => 13,
                'page_parent_id' => 9,
                'active' => 1,
            ),
            11 => 
            array (
                'page_id' => 15,
                'page_parent_id' => 14,
                'active' => 1,
            ),
            12 => 
            array (
                'page_id' => 16,
                'page_parent_id' => 15,
                'active' => 1,
            ),
            13 => 
            array (
                'page_id' => 17,
                'page_parent_id' => 15,
                'active' => 1,
            ),
            14 => 
            array (
                'page_id' => 18,
                'page_parent_id' => 14,
                'active' => 1,
            ),
            15 => 
            array (
                'page_id' => 19,
                'page_parent_id' => 14,
                'active' => 1,
            ),
            16 => 
            array (
                'page_id' => 20,
                'page_parent_id' => 14,
                'active' => 1,
            ),
            17 => 
            array (
                'page_id' => 22,
                'page_parent_id' => 21,
                'active' => 1,
            ),
            18 => 
            array (
                'page_id' => 23,
                'page_parent_id' => 21,
                'active' => 1,
            ),
            19 => 
            array (
                'page_id' => 24,
                'page_parent_id' => 21,
                'active' => 1,
            ),
        ));
        
        
    }
}
