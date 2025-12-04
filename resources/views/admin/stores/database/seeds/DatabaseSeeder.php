<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UsersTableSeeder');
        $this->call('PasswordResetsTableSeeder');
        $this->call('UploadsTableSeeder');
        $this->call('OptionsTableSeeder');
        $this->call('FormsTableSeeder');
        $this->call('FormQuestionTypesTableSeeder');
        $this->call('FormQuestionsTableSeeder');
        $this->call('FormQuestionChoicesTableSeeder');
        $this->call('PagesTableSeeder');
        $this->call('PageParentsTableSeeder');
        $this->call('PostsTableSeeder');
        $this->call('LandingElementsTableSeeder');
        $this->call('ContributorsTableSeeder');
        $this->call('PageTemplatesTableSeeder');
        $this->call('PageImageSlidesTableSeeder');
        $this->call('PostImageSlidesTableSeeder');
        $this->call('ExternalLinksTableSeeder');
        $this->call('ExternalFilesTableSeeder');
        $this->call('PressKitsTableSeeder');
        $this->call('PressKitItemsTableSeeder');
        $this->call('FormEntriesTableSeeder');
        $this->call('FormEntryItemsTableSeeder');
        $this->call('PageFormsTableSeeder');
        $this->call('ButtonLinksTableSeeder');
        $this->call('AdminUserSeeder');
    }
}
