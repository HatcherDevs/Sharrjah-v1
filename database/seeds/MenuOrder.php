<?php

use Illuminate\Database\Seeder;

class MenuOrder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[0] = ['mission','board-of-directors','al-qasimiya-school','sharjah','partners','supporters','contributors','opportunities','team-1'];
        $data[1] = ['architecture-plus','calendar','library','archive','projects'];
        $data[2]= ['releases','coverage','press-kit'];

        foreach ($data as $pages){
            $date = \Carbon\Carbon::now();
            foreach ($pages as $page){
                $pg = \App\Models\Page::where('slug',$page)->first();

                if($pg){
                    $saveDate = $date;
                    $pg->update(['created_at' => $saveDate->format('Y-m-d')]);
                    $date = $date->subDay();
                }
            }
        }
    }
}
