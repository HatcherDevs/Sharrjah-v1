<?php

use Illuminate\Database\Seeder;

class FormQuestionTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('form_question_types')->delete();
        
        \DB::table('form_question_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Text Field',
                'slug' => 'text',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Textarea',
                'slug' => 'textarea',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Multiple choices with single answers',
                'slug' => 'radio',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Multiple choices with multiple answers',
                'slug' => 'checkbox',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Rate question',
                'slug' => 'rate',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Date',
                'slug' => 'date',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'File',
                'slug' => 'file',
                'created_at' => '2018-11-21 13:53:46',
                'updated_at' => '2018-11-21 13:53:46',
            ),
        ));
        
        
    }
}
