<?php

use Illuminate\Database\Seeder;

class ExternalLinksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('external_links')->delete();
        
        \DB::table('external_links')->insert(array (
            0 => 
            array (
                'id' => 3,
                'post_id' => 6,
                'url' => 'http://sharjaharchitecture.org/pages/programs/calendar/upcoming-events/rights-of-future-generations',
                'language' => 'ar',
                'created_at' => '2018-11-21 14:22:19',
                'updated_at' => '2018-11-21 14:22:19',
            ),
            1 => 
            array (
                'id' => 4,
                'post_id' => 6,
                'url' => 'http://sharjaharchitecture.org/pages/programs/calendar/upcoming-events/rights-of-future-generations',
                'language' => 'en',
                'created_at' => '2018-11-21 14:22:19',
                'updated_at' => '2018-11-21 14:22:19',
            ),
            2 => 
            array (
                'id' => 7,
                'post_id' => 9,
                'url' => 'http://sharjaharchitecture.org/pages/programs/calendar/previous-events/shifting-morphology-of-gulf-cities',
                'language' => 'ar',
                'created_at' => '2018-11-21 14:23:07',
                'updated_at' => '2018-11-21 14:23:07',
            ),
            3 => 
            array (
                'id' => 8,
                'post_id' => 9,
                'url' => 'http://sharjaharchitecture.org/pages/programs/calendar/previous-events/shifting-morphology-of-gulf-cities',
                'language' => 'en',
                'created_at' => '2018-11-21 14:23:07',
                'updated_at' => '2018-11-21 14:23:07',
            ),
            4 => 
            array (
                'id' => 9,
                'post_id' => 8,
                'url' => 'http://sharjaharchitecture.org/pages/programs/calendar/previous-events/the-global-climate-gheto',
                'language' => 'ar',
                'created_at' => '2018-11-21 14:23:18',
                'updated_at' => '2018-11-21 14:23:18',
            ),
            5 => 
            array (
                'id' => 10,
                'post_id' => 8,
                'url' => 'http://sharjaharchitecture.org/pages/programs/calendar/previous-events/the-global-climate-gheto',
                'language' => 'en',
                'created_at' => '2018-11-21 14:23:18',
                'updated_at' => '2018-11-21 14:23:18',
            ),
            6 => 
            array (
                'id' => 22,
                'post_id' => 22,
                'url' => 'http://www.alkhaleej.ae/alkhaleej/page/fb8668a1-a4da-4f66-bc60-d268429c429b',
                'language' => 'ar',
                'created_at' => '2018-11-22 12:09:51',
                'updated_at' => '2018-11-22 12:09:51',
            ),
            7 => 
            array (
                'id' => 23,
                'post_id' => 23,
                'url' => 'https://www.artforum.com/news/amin-alsaden-appointed-director-of-sharjah-architecture-triennial-75911',
                'language' => 'en',
                'created_at' => '2018-11-22 12:10:22',
                'updated_at' => '2018-11-22 12:10:22',
            ),
            8 => 
            array (
                'id' => 24,
                'post_id' => 24,
                'url' => 'https://www.archdaily.com/895729/sharjah-architecture-triennial-to-open-as-first-major-platform-on-middle-eastern-architecture',
                'language' => 'en',
                'created_at' => '2018-11-22 12:10:33',
                'updated_at' => '2018-11-22 12:10:33',
            ),
            9 => 
            array (
                'id' => 25,
                'post_id' => 25,
                'url' => 'https://www.dezeen.com/2018/06/04/sharjah-architecture-triennial-interview-adrian-lahoud-curator/',
                'language' => 'en',
                'created_at' => '2018-11-22 12:10:46',
                'updated_at' => '2018-11-22 12:10:46',
            ),
            10 => 
            array (
                'id' => 26,
                'post_id' => 26,
                'url' => 'http://client.mediaobserver-me.com/article/?slng=en&id=7808287&qk=DfwPiiobIXgNvE7WRtu0ortYtvpa9GwW0WKvZLSOBg4=',
                'language' => 'en',
                'created_at' => '2018-11-22 12:11:00',
                'updated_at' => '2018-11-22 12:11:00',
            ),
            11 => 
            array (
                'id' => 27,
                'post_id' => 27,
                'url' => 'https://www.wallpaper.com/architecture/sharjah-architecture-triennale-2019',
                'language' => 'en',
                'created_at' => '2018-11-22 12:11:16',
                'updated_at' => '2018-11-22 12:11:16',
            ),
            12 => 
            array (
                'id' => 28,
                'post_id' => 28,
                'url' => 'http://www.alhayat.com/article/4579809/%D8%AB%D9%82%D8%A7%D9%81%D8%A9-%D9%88-%D9%85%D8%AC%D8%AA%D9%85%D8%B9/%D9%85%D9%86%D9%88%D8%B9%D8%A7%D8%AA/%D8%A3%D8%AF%D8%B1%D9%8A%D8%A7%D9%86-%D9%84%D8%AD%D9%88%D8%AF-%D9%82%D9%8A%D9%85%D8%A7-%D9%84%D9%84%D9%86%D8%B',
                'language' => 'ar',
                'created_at' => '2018-11-22 12:11:41',
                'updated_at' => '2018-11-22 12:11:41',
            ),
            13 => 
            array (
                'id' => 29,
                'post_id' => 29,
                'url' => 'https://www.architecturaldigest.com/story/sharjah-architecture-triennial-means-for-the-middle-east',
                'language' => 'en',
                'created_at' => '2018-11-22 12:11:52',
                'updated_at' => '2018-11-22 12:11:52',
            ),
            14 => 
            array (
                'id' => 30,
                'post_id' => 30,
                'url' => 'http://www.alkhaleej.ae/economics/page/fa492741-cc23-46a1-96c7-5559b7e5e831',
                'language' => 'ar',
                'created_at' => '2018-11-22 12:12:23',
                'updated_at' => '2018-11-22 12:12:23',
            ),
            15 => 
            array (
                'id' => 31,
                'post_id' => 31,
                'url' => 'https://www.emaratalyoum.com/life/culture/2018-04-04-1.1086450',
                'language' => 'ar',
                'created_at' => '2018-11-22 12:12:43',
                'updated_at' => '2018-11-22 12:12:43',
            ),
            16 => 
            array (
                'id' => 32,
                'post_id' => 32,
                'url' => 'https://www.harpersbazaararabia.com/art/fairs-and-events/sharjah-architecture-triennial-hosts-first-public-programme',
                'language' => 'en',
                'created_at' => '2018-11-22 12:13:07',
                'updated_at' => '2018-11-22 12:13:07',
            ),
            17 => 
            array (
                'id' => 33,
                'post_id' => 33,
                'url' => 'https://www.hospitality-interiors.net/news/articles/2018/04/1175409363-first-sharjah-architecture-triennial-set-2019',
                'language' => 'en',
                'created_at' => '2018-11-22 12:13:26',
                'updated_at' => '2018-11-22 12:13:26',
            ),
            18 => 
            array (
                'id' => 34,
                'post_id' => 34,
                'url' => 'http://alwatannewspaper.ae/?p=308240',
                'language' => 'ar',
                'created_at' => '2018-11-22 12:13:52',
                'updated_at' => '2018-11-22 12:13:52',
            ),
            19 => 
            array (
                'id' => 35,
                'post_id' => 7,
                'url' => 'http://sharjaharchitecture.org/pages/programs/projects/sharjah-shorts-open-call',
                'language' => 'ar',
                'created_at' => '2018-11-22 12:24:53',
                'updated_at' => '2018-11-22 12:24:53',
            ),
            20 => 
            array (
                'id' => 36,
                'post_id' => 7,
                'url' => 'http://sharjaharchitecture.org/pages/programs/projects/sharjah-shorts-open-call',
                'language' => 'en',
                'created_at' => '2018-11-22 12:24:53',
                'updated_at' => '2018-11-22 12:24:53',
            ),
        ));
        
        
    }
}
