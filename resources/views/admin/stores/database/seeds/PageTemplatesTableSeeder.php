<?php

use Illuminate\Database\Seeder;

class PageTemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('page_templates')->delete();
        
        \DB::table('page_templates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Page',
                'slug' => 'single',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Category',
                'slug' => 'main',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'List without image',
                'slug' => 'list',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'List with image',
                'slug' => 'list-image',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'List with one language only',
                'slug' => 'list-one-lang',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
        ));
        
        
    }
}
