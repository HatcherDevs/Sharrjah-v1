<?php

use App\Models\ResearchBuilding;
use Illuminate\Database\Seeder;

class ResearchBuildingSeeder extends Seeder
{
    use \App\Traits\CanCreateSlug;

    public function __construct(\App\Models\ResearchBuilding $model)
    {
        $this->model = $model;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->model->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $years = ['pre-1960','1960-1980','1981-2000','2001-2020','post-2020'];

        for ($x=1;$x<50;$x++){

            $d = [
                'title' => $this->random_lipsum(rand(2,4)),
                'title_ar' => $this->random_lipsum_ar(rand(3,5)),
                'slug'=> \Illuminate\Support\Str::slug('Building '.$x),
                'content'=> $this->random_lipsum(rand(150,170)),
                'content_ar'=> $this->random_lipsum_ar(rand(150,170)),
                'lat'=> '25.'.rand(285151,369469),
                'lng'=> '55.'.rand(3821178,4979469),
                'year'=> $years[rand(0,4)],
                'research_type_id'=>rand(1,3),
                'image'=> 'img/research/building-placeholder-'.rand(1,3).'.jpg',
            ];

            ResearchBuilding::create($d);
        }

    }

    public function random_lipsum($amount) {
        $words = [
            'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur',
            'adipiscing', 'elit', 'curabitur', 'vel', 'hendrerit', 'libero',
            'eleifend', 'blandit', 'nunc', 'ornare', 'odio', 'ut',
            'orci', 'gravida', 'imperdiet', 'nullam', 'purus', 'lacinia',
            'a', 'pretium', 'quis', 'congue', 'praesent', 'sagittis',
            'laoreet', 'auctor', 'mauris', 'non', 'velit', 'eros',
            'dictum', 'proin', 'accumsan', 'sapien', 'nec', 'massa',
            'volutpat', 'venenatis', 'sed', 'eu', 'molestie', 'lacus',
            'quisque', 'porttitor', 'ligula', 'dui', 'mollis', 'tempus',
            'at', 'magna', 'vestibulum', 'turpis', 'ac', 'diam',
            'tincidunt', 'id', 'condimentum', 'enim', 'sodales', 'in',
            'hac', 'habitasse', 'platea', 'dictumst', 'aenean', 'neque',
            'fusce', 'augue', 'leo', 'eget', 'semper', 'mattis',
            'tortor', 'scelerisque', 'nulla', 'interdum', 'tellus', 'malesuada',
            'rhoncus', 'porta', 'sem', 'aliquet', 'et', 'nam',
            'suspendisse', 'potenti', 'vivamus', 'luctus', 'fringilla', 'erat',
            'donec', 'justo', 'vehicula', 'ultricies', 'varius', 'ante',
            'primis', 'faucibus', 'ultrices', 'posuere', 'cubilia', 'curae',
            'etiam', 'cursus', 'aliquam', 'quam', 'dapibus', 'nisl',
            'feugiat', 'egestas', 'class', 'aptent', 'taciti', 'sociosqu',
            'ad', 'litora', 'torquent', 'per', 'conubia', 'nostra',
            'inceptos', 'himenaeos', 'phasellus', 'nibh', 'pulvinar', 'vitae',
            'urna', 'iaculis', 'lobortis', 'nisi', 'viverra', 'arcu',
            'morbi', 'pellentesque', 'metus', 'commodo', 'ut', 'facilisis',
            'felis', 'tristique', 'ullamcorper', 'placerat', 'aenean', 'convallis',
            'sollicitudin', 'integer', 'rutrum', 'duis', 'est', 'etiam',
            'bibendum', 'donec', 'pharetra', 'vulputate', 'maecenas', 'mi',
            'fermentum', 'consequat', 'suscipit', 'aliquam', 'habitant', 'senectus',
            'netus', 'fames', 'quisque', 'euismod', 'curabitur', 'lectus',
            'elementum', 'tempor', 'risus', 'cras'
        ];
        $data = '';

        for ($x=1;$x<$amount;$x++)
            $data .= $words[rand(0,count($words))].' ';

        return $data;
    }

    public function random_lipsum_ar($amount) {

        $words = [
            0 => 'طلبه ',
            1 => 'الح',
            2 => 'اجة،',
            3 => 'ي',
            4 => 'قوم',
            5 => 'مول',
            6 => 'ّدنا هذ',
            7 => 'ا با',
            8 => 'ستخدام',
            9 => 'ك',
            10 => 'لمات',
            11 => 'من ',
            12 => 'قاموس ',
            13 => 'يحوي ',
            14 => 'على ',
            15 => 'أكثر',
            16 => 'من ك',
            17 => 'لمة ل',
            18 => 'ا تي',
            19 => 'نية،',
            20 => 'مضاف ',
            21 => 'إل',
            22 => 'يها ',
            23 => 'مجموعة ',
            24 => 'من ا',
            25 => 'لجمل ',
            26 => 'الن',
            27 => 'موذجية، ',
            28 => 'لتكوين',
            29 => 'نص ل',
            30 => 'وريم إ',
            31 => 'يبسوم ',
            32 => 'ذو',
            33 => 'شكل ',
            34 => 'منطقي ',
            35 => 'قريب إلى ',
            36 => 'النص ا',
            37 => 'لحقيقي',
            38 => ' وب',
            39 => 'التالي ',
            40 => 'يكون',
            41 => 'النص',
            42 => 'ال',
            43 => 'ناتح ',
            44 => 'خالي',
            45 => 'من ال',
            46 => 'تكرار،',
            47 => 'أو أي ك',
            48 => 'لمات أو ',
            49 => 'عبارات غ',
            50 => 'ير لا',
            51 => 'ئقة أو',
            52 => 'ما ش',
            53 => 'ابهوهذا',
            54 => 'ما ي',
            55 => 'جعله أ',
            56 => 'ول مولّ',
            57 => 'د نص ل',
            58 => 'وريم إ',
            59 => 'يبسوم ',
            60 => 'حقيقي ',
            61 => 'على ا',
            62 => 'لإنترنت.',
        ];

        $data = '';

        for ($x=1;$x<$amount;$x++)
            $data .= $words[rand(0,count($words))].' ';

        return $data;
    }
}
