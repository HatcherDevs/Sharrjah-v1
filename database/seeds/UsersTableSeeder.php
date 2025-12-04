<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Gene Ellorin',
                'email' => 'gene@thisishatch.com',
                'password' => '$2y$10$7qAJEoxiUKWaA5Y7Eau32OVDuAfOGqQ2x5dJdgqdBLVGTN05kKbWa',
                'remember_token' => 'k742mWtPBIxsJuNJdMwrLrpzHt9Y2607byDhxAB4O71HudyCezIhIZyukiLj',
                'created_at' => '2018-11-21 14:36:31',
                'updated_at' => '2018-11-21 14:46:51',
            ),
        ));
        
        
    }
}
