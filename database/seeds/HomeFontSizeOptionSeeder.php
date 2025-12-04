<?php

use Illuminate\Database\Seeder;

class HomeFontSizeOptionSeeder extends Seeder
{
    use \App\Traits\CanCreateSlug;

    public function __construct(\App\Models\Option $model)
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
                'name' => 'Home Page Font Size EN',
                'value' => 30,
            ],
            [
                'name' => 'Home Page Font Size AR',
                'value' => 30,
            ],
        ];

        foreach ($data as $item){
            $item['slug'] = $this->generateSlug($item['name']);

            $this->model->create($item);
        }

    }
}
