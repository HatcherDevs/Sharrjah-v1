<?php

use Illuminate\Database\Seeder;

class MaterialContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'series_1_title' => 'Series 1',
            'series_1_description' => '',
            'series_1_title_ar' => 'Series 1',
            'series_1_description_ar' => '',
            'series_2_title' => 'Series 2',
            'series_2_description' => '',
            'series_2_title_ar' => 'Series 2',
            'series_2_description_ar' => '',
        ];

        \App\Models\MaterialSeriesContent::create($data);
    }
}
