<?php

use Illuminate\Database\Seeder;
use App\Traits\CanCreateSlug;
use App\Models\Forms\FormQuestionType;

class FormQuestionTypeSeeder extends Seeder
{
    use CanCreateSlug;

    public function __construct(FormQuestionType $model)
    {
        $this->model = $model;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->model->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data =
        [
            ['name' => 'Text Field','slug'=>'text'],
            ['name' => 'Textarea','slug'=>'textarea'],
            ['name' => 'Multiple choices with single answers','slug'=>'radio'],
            ['name' => 'Multiple choices with multiple answers','slug'=>'checkbox'],
            ['name' => 'Rate question','slug'=>'rate'],
            ['name' => 'Date','slug'=>'date'],
            ['name' => 'File','slug'=>'file'],
        ];

        foreach ($data as $item){
            $this->model->create($item);
        }
    }
}
