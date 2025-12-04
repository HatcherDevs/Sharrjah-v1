<?php

use Illuminate\Database\Seeder;

class ResearchDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('ResearchTypeSeeder');
        $this->call('ResearchBuildingSeeder');
        $this->call('ResearchContentSeeder');
        $this->call('RepositoryTypeSeeder');
        $this->call('RepositorySeeder');
    }
}
