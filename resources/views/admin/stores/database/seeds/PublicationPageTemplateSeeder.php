<?php

use Illuminate\Database\Seeder;

class PublicationPageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('page_templates')->insert(array (
            0 =>
                array (
                    'id' => 6,
                    'name' => '3-Column',
                    'slug' => 'column-3',
                    'created_at' => '2019-05-29 13:53:46',
                    'updated_at' => '2019-05-29 13:53:46',
                )
        ));
    }
}
