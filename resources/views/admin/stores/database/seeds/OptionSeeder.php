<?php

use Illuminate\Database\Seeder;
use App\Models\Option;
use \App\Traits\CanCreateSlug;

class OptionSeeder extends Seeder
{
    use CanCreateSlug;

    public function __construct(Option $model)
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
        $data = [
            [
                'name' => 'Headline En',
                'value' => '<h1 style="font-weight:normal">INAUGURAL EDITION: NOVEMBER 9, 2019 - FEBRUARY 8, 2020</h1>
								<h1><strong>“RIGHTS OF FUTURE GENERATIONS”</strong></h1>
								<h1 style="font-weight:normal">CURATED BY ADRIAN LAHOUD</h1>',
            ],
            [
                'name' => 'Headline AR',
                'value' => '<h1 dir="rtl">
الدورة الافتتاحية<span style="font-family:Tahoma">،</span> نوفمبر 9<span style="font-family:Tahoma">،</span>  2019 - فبراير 8<span style="font-family:Tahoma">،</span> 2020</h1>
								<h1><strong>“حقوق الاجيال القادمة“</strong></h1>
								<h1>مع القيّم ادريان لحود</h1>',
            ],
            [
                'name' => 'Intro EN',
                'value' => 'Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and South and Southeast Asia. Participating in international conversations while anchored in the specificity of Sharjah and the United Arab Emirates, we offer new spaces for critical reflection and foster research that situates the built environment within its complex social, economic, and cultural contexts.',
            ],
            [
                'name' => 'Intro AR',
                'value' => 'يعدّ ترينالي الشارقة للعمارة المنصة الرئيسة والأولى من نوعها للعمارة والتحضّر في الشرق الأوسط وشمال وشرق أفريقيا وجنوب و جنوب شرق آسيا. بمشاركته في النقاشات الدولية مع التركيز على خصوصية الشارقة والإمارات العربية المتحدة، يفسح الترينالي مساحات جديدة للتأمل النقدي ويدعم البحوث التي تمعّن في علاقة البيئة العمرانية بسياقاتها الاجتماعية والاقتصادية والثقافية المعقدة.',
            ],
            [
                'name' => 'Additional',
                'value' => '',
            ],
            [
                'name' => 'Facebook-link',
                'value' => 'https://www.facebook.com/sharjaharchitecture/',
            ],
            [
                'name' => 'Twitter-link',
                'value' => 'https://twitter.com/sharjaharch',
            ],
            [
                'name' => 'Instagram-link',
                'value' => 'https://www.instagram.com/sharjaharchitecture/',
            ],
            [
                'name' => 'Vimeo-link',
                'value' => 'https://vimeo.com/sharjaharchitecture',
            ],
            [
                'name' => 'Copyright',
                'value' => '© Sharjah Architecture Triennial 2018. All Rights Reserved.',
            ],
            [
                'name' => 'Copyright Right',
                'value' => 'بدعم من مجلس الشارقة للتخطيط العمراني',
            ],
            [
                'name' => 'Main Menu 1',
                'value' => 1,
            ],
            [
                'name' => 'Main Menu 2',
                'value' => 9,
            ],
            [
                'name' => 'Main Menu 3',
                'value' => 14,
            ],
            [
                'name' => 'Main Menu 4',
                'value' => 21,
            ],
            [
                'name' => 'Main Menu 5',
                'value' => 25,
            ]
        ];

        foreach ($data as $item){
            $item['slug'] = $this->generateSlug($item['name']);

            $this->model->create($item);
        }

    }
}
