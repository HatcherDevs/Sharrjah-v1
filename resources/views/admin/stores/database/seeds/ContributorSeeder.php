<?php

use Illuminate\Database\Seeder;

class ContributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
        // CONTRIBUTORS
        ];

        foreach ($data as $item){
            $page_id = \App\Models\Page::where('slug',$item['post_type'])->select('id')->first();

            if(!$page_id)
                return false;

            if(!\App\Models\Contributor::where('slug' ,$item['slug'])->count()){
                \App\Models\Contributor::create( \Illuminate\Support\Arr::except($item, 'post_type'));
            }


        }

    }
}
