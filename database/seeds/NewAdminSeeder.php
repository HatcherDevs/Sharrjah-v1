<?php

use Illuminate\Database\Seeder;
use App\Traits\CanCreateSlug;

class NewAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'Admin',
            'email' => 'webadmin@sharjaharchitecture.org',
            'password' => \Illuminate\Support\Facades\Hash::make('admin@satX2022!')
        ];

        \App\User::create($data);

    }
}
