<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('options')->delete();
        
        \DB::table('options')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Headline En',
                'slug' => 'headline-en',
                'value' => '<h1 style="font-weight:normal">INAUGURAL EDITION: NOVEMBER 9, 2019 - FEBRUARY 8, 2020</h1>
<h1><strong>“RIGHTS OF FUTURE GENERATIONS”</strong></h1>
<h1 style="font-weight:normal">CURATED BY ADRIAN LAHOUD</h1>',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Headline AR',
                'slug' => 'headline-ar',
                'value' => '<h1 dir="rtl">
الدورة الافتتاحية<span style="font-family:Tahoma">،</span> نوفمبر 9<span style="font-family:Tahoma">،</span>  2019 - فبراير 8<span style="font-family:Tahoma">،</span> 2020</h1>
<h1><strong>“حقوق الاجيال القادمة“</strong></h1>
<h1>مع القيّم ادريان لحود</h1>',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Intro EN',
                'slug' => 'intro-en',
                'value' => 'Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and South and Southeast Asia. Participating in international conversations while anchored in the specificity of Sharjah and the United Arab Emirates, we offer new spaces for critical reflection and foster research that situates the built environment within its complex social, economic, and cultural contexts.',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Intro AR',
                'slug' => 'intro-ar',
                'value' => 'يعدّ ترينالي الشارقة للعمارة المنصة الرئيسة والأولى من نوعها للعمارة والتحضّر في الشرق الأوسط وشمال وشرق أفريقيا وجنوب و جنوب شرق آسيا. بمشاركته في النقاشات الدولية مع التركيز على خصوصية الشارقة والإمارات العربية المتحدة، يفسح الترينالي مساحات جديدة للتأمل النقدي ويدعم البحوث التي تمعّن في علاقة البيئة العمرانية بسياقاتها الاجتماعية والاقتصادية والثقافية المعقدة.',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Additional',
                'slug' => 'additional',
                'value' => '',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Facebook-link',
                'slug' => 'facebook-link',
                'value' => 'https://www.facebook.com/sharjaharchitecture/',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Twitter-link',
                'slug' => 'twitter-link',
                'value' => 'https://twitter.com/sharjaharch',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Instagram-link',
                'slug' => 'instagram-link',
                'value' => 'https://www.instagram.com/sharjaharchitecture/',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Vimeo-link',
                'slug' => 'vimeo-link',
                'value' => 'https://vimeo.com/sharjaharchitecture',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Copyright',
                'slug' => 'copyright',
                'value' => '© Sharjah Architecture Triennial 2018. All Rights Reserved.',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Copyright Right',
                'slug' => 'copyright-right',
                'value' => 'بدعم من مجلس الشارقة للتخطيط العمراني',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Main Menu 1',
                'slug' => 'main-menu-1',
                'value' => '1',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Main Menu 2',
                'slug' => 'main-menu-2',
                'value' => '9',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Main Menu 3',
                'slug' => 'main-menu-3',
                'value' => '14',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Main Menu 4',
                'slug' => 'main-menu-4',
                'value' => '21',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Main Menu 5',
                'slug' => 'main-menu-5',
                'value' => '25',
            ),
        ));
        
        
    }
}
