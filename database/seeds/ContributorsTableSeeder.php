<?php

use Illuminate\Database\Seeder;

class ContributorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contributors')->delete();
        
        \DB::table('contributors')->insert(array (
            0 => 
            array (
                'id' => 1,
                'letter' => 'A',
                'letter_ar' => 'خ',
                'order' => 4,
                'order_ar' => 2,
                'post_id' => 35,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            1 => 
            array (
                'id' => 2,
                'letter' => 'A',
                'letter_ar' => 'أ',
                'order' => 3,
                'order_ar' => 1,
                'post_id' => 36,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-21 11:55:53',
            ),
            2 => 
            array (
                'id' => 3,
                'letter' => 'E',
                'letter_ar' => 'ع',
                'order' => 2,
                'order_ar' => 2,
                'post_id' => 37,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            3 => 
            array (
                'id' => 4,
                'letter' => 'K',
                'letter_ar' => 'ع',
                'order' => 1,
                'order_ar' => 1,
                'post_id' => 38,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            4 => 
            array (
                'id' => 5,
                'letter' => 'A',
                'letter_ar' => 'خ',
                'order' => 7,
                'order_ar' => 5,
                'post_id' => 39,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            5 => 
            array (
                'id' => 6,
                'letter' => 'B',
                'letter_ar' => 'ح',
                'order' => 1,
                'order_ar' => 2,
                'post_id' => 40,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            6 => 
            array (
                'id' => 7,
                'letter' => 'P',
                'letter_ar' => 'ف',
                'order' => 1,
                'order_ar' => 2,
                'post_id' => 41,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            7 => 
            array (
                'id' => 8,
                'letter' => 'P',
                'letter_ar' => 'ر',
                'order' => 2,
                'order_ar' => 1,
                'post_id' => 42,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 11:55:53',
            ),
            8 => 
            array (
                'id' => 9,
                'letter' => 'S',
                'letter_ar' => 'م',
                'order' => 1,
                'order_ar' => 4,
                'post_id' => 43,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            9 => 
            array (
                'id' => 10,
                'letter' => 'L',
                'letter_ar' => 'أ',
                'order' => 1,
                'order_ar' => 3,
                'post_id' => 44,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            10 => 
            array (
                'id' => 11,
                'letter' => 'L',
                'letter_ar' => 'أ',
                'order' => 2,
                'order_ar' => 4,
                'post_id' => 45,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            11 => 
            array (
                'id' => 12,
                'letter' => 'D',
                'letter_ar' => 'ل',
                'order' => 1,
                'order_ar' => 1,
                'post_id' => 46,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 11:55:53',
            ),
            12 => 
            array (
                'id' => 13,
                'letter' => 'O',
                'letter_ar' => 'ع',
                'order' => 1,
                'order_ar' => 3,
                'post_id' => 47,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 11:55:53',
            ),
            13 => 
            array (
                'id' => 14,
                'letter' => 'M',
                'letter_ar' => 'د',
                'order' => 1,
                'order_ar' => 1,
                'post_id' => 48,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 11:55:53',
            ),
            14 => 
            array (
                'id' => 15,
                'letter' => 'W',
                'letter_ar' => 'أ',
                'order' => 1,
                'order_ar' => 5,
                'post_id' => 49,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            15 => 
            array (
                'id' => 16,
                'letter' => 'A',
                'letter_ar' => 'ف',
                'order' => 1,
                'order_ar' => 1,
                'post_id' => 50,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            16 => 
            array (
                'id' => 17,
                'letter' => 'G',
                'letter_ar' => 'ف',
                'order' => 1,
                'order_ar' => 4,
                'post_id' => 51,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            17 => 
            array (
                'id' => 18,
                'letter' => 'H',
                'letter_ar' => 'ف',
                'order' => 1,
                'order_ar' => 3,
                'post_id' => 52,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            18 => 
            array (
                'id' => 19,
                'letter' => 'K',
                'letter_ar' => 'ج',
                'order' => 2,
                'order_ar' => 2,
                'post_id' => 53,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            19 => 
            array (
                'id' => 20,
                'letter' => 'A',
                'letter_ar' => 'ج',
                'order' => 2,
                'order_ar' => 1,
                'post_id' => 54,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            20 => 
            array (
                'id' => 21,
                'letter' => 'A',
                'letter_ar' => 'ح',
                'order' => 8,
                'order_ar' => 1,
                'post_id' => 55,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            21 => 
            array (
                'id' => 22,
                'letter' => 'H',
                'letter_ar' => 'ح',
                'order' => 2,
                'order_ar' => 3,
                'post_id' => 56,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 11:55:53',
            ),
            22 => 
            array (
                'id' => 23,
                'letter' => 'S',
                'letter_ar' => 'ه',
                'order' => 3,
                'order_ar' => 1,
                'post_id' => 57,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:14:36',
            ),
            23 => 
            array (
                'id' => 24,
                'letter' => 'S',
                'letter_ar' => 'أ',
                'order' => 2,
                'order_ar' => 2,
                'post_id' => 58,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            24 => 
            array (
                'id' => 25,
                'letter' => 'A',
                'letter_ar' => 'خ',
                'order' => 5,
                'order_ar' => 3,
                'post_id' => 59,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 11:55:53',
            ),
            25 => 
            array (
                'id' => 26,
                'letter' => 'A',
                'letter_ar' => 'خ',
                'order' => 6,
                'order_ar' => 1,
                'post_id' => 60,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            26 => 
            array (
                'id' => 27,
                'letter' => 'A',
                'letter_ar' => 'خ',
                'order' => 9,
                'order_ar' => 4,
                'post_id' => 61,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            27 => 
            array (
                'id' => 28,
                'letter' => 'J',
                'letter_ar' => 'م',
                'order' => 2,
                'order_ar' => 3,
                'post_id' => 62,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            28 => 
            array (
                'id' => 29,
                'letter' => 'J',
                'letter_ar' => 'م',
                'order' => 1,
                'order_ar' => 2,
                'post_id' => 63,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            29 => 
            array (
                'id' => 30,
                'letter' => 'F',
                'letter_ar' => 'م',
                'order' => 1,
                'order_ar' => 5,
                'post_id' => 64,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            30 => 
            array (
                'id' => 31,
                'letter' => 'E',
                'letter_ar' => 'م',
                'order' => 1,
                'order_ar' => 1,
                'post_id' => 65,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 12:19:22',
            ),
            31 => 
            array (
                'id' => 32,
                'letter' => 'M',
                'letter_ar' => 'ر',
                'order' => 2,
                'order_ar' => 2,
                'post_id' => 66,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 11:55:53',
            ),
        ));
        
        
    }
}
