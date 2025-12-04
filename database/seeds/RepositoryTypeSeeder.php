<?php

use Illuminate\Database\Seeder;
use App\Traits\CanCreateSlug;

class RepositoryTypeSeeder extends Seeder
{
    use CanCreateSlug;

    public function __construct(\App\Models\RepositoryType $model)
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->model->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $data = [
            ['title' => 'Seminars','title_ar' => 'ندوات ','slug'=>'seminars'],
            ['title' => 'Webinars','title_ar' => ' ندوات عبر الإنترنت','slug'=>'webinars'],
            ['title' => 'Discussions','title_ar' => 'مناقشات','slug'=>'discussions'],
            ['title' => 'Publications','title_ar' => 'منشورات','slug'=>'publications','is_video'=>0],
        ];

        foreach ($data as $item){
            $this->model->create($item);
        }
    }
}
