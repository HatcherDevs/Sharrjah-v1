<?php

use Illuminate\Database\Seeder;
use App\Models\PageTemplate;

class PageTemplateSeeder extends Seeder
{
    public function __construct(PageTemplate $model)
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
                ['name' => 'Page','slug'=>'single'],
                ['name' => 'Category','slug'=>'main'],
                ['name' => 'List without image','slug'=>'list'],
                ['name' => 'List with image','slug'=>'list-image'],
                ['name' => 'List with one language only','slug'=>'list-one-lang']
            ];

        foreach ($data as $item){
            $this->model->create($item);
        }
    }
}
