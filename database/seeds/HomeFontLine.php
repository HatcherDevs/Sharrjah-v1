<?php

use Illuminate\Database\Seeder;

class HomeFontLine extends Seeder
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
                'name' => 'Home Page Font Line EN',
                'value' => 41,
            ],
            [
                'name' => 'Home Page Font Line AR',
                'value' => 41,
            ],
        ];

        foreach ($data as $item){
            $item['slug'] = $this->generateSlug($item['name']);

            $this->model->create($item);
        }
    }
}
