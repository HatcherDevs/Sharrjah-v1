<?php

use Illuminate\Database\Seeder;

class ButtonLinksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('button_links')->delete();
        
        \DB::table('button_links')->insert(array (
            0 => 
            array (
                'id' => 8,
                'linkable_id' => 73,
                'linkable_type' => 'App\\Models\\Post',
                'title' => 'Apply',
                'title_ar' => 'Apply Arss',
                'value' => 'mailto:careers@sharjaharchitecture.com',
                'value_ar' => 'mailto:careers@sharjaharchitecture.comae',
            ),
            1 => 
            array (
                'id' => 11,
                'linkable_id' => 12,
                'linkable_type' => 'App\\Models\\Post',
                'title' => 'APPLY NOW',
                'title_ar' => 'قدم الآن',
                'value' => 'mailto:careers@sharjaharchitecture.org?subject=Architect and Project Leader',
                'value_ar' => 'mailto:careers@sharjaharchitecture.org?subject=معماري ومدير مشاريع',
            ),
            2 => 
            array (
                'id' => 12,
                'linkable_id' => 11,
                'linkable_type' => 'App\\Models\\Post',
                'title' => 'APPLY NOW',
                'title_ar' => 'قدم الآن',
            'value' => 'mailto:careers@sharjaharchitecture.org?subject=Program Assistant (Arabic Language)',
                'value_ar' => 'mailto:careers@sharjaharchitecture.org?subject=مساعد إعداد برامج باللغة العربية',
            ),
            3 => 
            array (
                'id' => 13,
                'linkable_id' => 10,
                'linkable_type' => 'App\\Models\\Post',
                'title' => 'APPLY NOW',
                'title_ar' => 'قدم الآن',
                'value' => 'mailto:careers@sharjaharchitecture.org?subject=Online Content Coordinator',
                'value_ar' => 'mailto:careers@sharjaharchitecture.org?subject=منسق محتوى إلكتروني',
            ),
            4 => 
            array (
                'id' => 14,
                'linkable_id' => 17,
                'linkable_type' => 'App\\Models\\Post',
                'title' => 'SUBMIT',
                'title_ar' => 'اشترك',
                'value' => 'mailto:submissions@sharjaharchitecture.org?subject=Sharjah Shorts Submission',
                'value_ar' => 'mailto:submissions@sharjaharchitecture.org?subject=أفلام الشارقة القصيرة',
            ),
        ));
        
        
    }
}
