<?php

use Illuminate\Database\Seeder;
use App\Traits\CanCreateSlug;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
                'name' => 'Fermin',
                'email' => 'fermin@sharjaharchitecture.org',
                'password' => \Illuminate\Support\Facades\Hash::make('fermin@sat2018!')
		];

		\App\User::create($data);
		
        $data = [
                'name' => 'Diane',
                'email' => 'diane@sharjaharchitecture.org',
                'password' => \Illuminate\Support\Facades\Hash::make('diane@sat2018!')
		];

		\App\User::create($data);
		
        $data = [
                'name' => 'Anum',
                'email' => 'anum@sharjaharchitecture.org',
                'password' => \Illuminate\Support\Facades\Hash::make('anum@sat2018!')
		];

		\App\User::create($data);
    }
}
