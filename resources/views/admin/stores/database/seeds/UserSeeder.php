<?php

use Illuminate\Database\Seeder;
use App\Traits\CanCreateSlug;
use App\Models\Forms\FormQuestionType;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
                'name' => 'Gene Ellorin',
                'email' => 'gene@thisishatch.com',
                'password' => \Illuminate\Support\Facades\Hash::make('Hatch@2018!')
            ];

            \App\User::create($data);
    }
}
