<?php

use Illuminate\Database\Seeder;

class NewResearchContentSeeder extends Seeder
{

    use \App\Traits\CanCreateSlug;

    public function __construct(\App\Models\ResearchContent $model)
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
        $data = [
            [
                'title' => 'Map page title EN',
                'title_ar' => 'Map page title AR',
                'content' => 'Map',
                'content_ar' => 'Map',
                'slug' => 'map-page-title',
            ],
            [
                'title' => 'Show Arabic Version',
                'content' => 1,
                'slug' => 'show-arabic'
            ],
        ];

        foreach ($data as $item){
            $this->model->create($item);
        }

    }

}
