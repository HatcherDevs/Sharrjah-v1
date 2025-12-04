<?php

use Illuminate\Database\Seeder;

class PodcastTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = ["name"=> "ARCHITECTURE+","name_ar"=> "عمارة وأكثر","slug" => "architecture-plus", "page_type" => "column-3",
            'content'=>'<b>Architecture+</b> is a series of online conversations that aim to create dialogues exploring the social responsibilities of architects, urban planners, academics and their multidisciplinary interlocutors. Times of crisis, such as the current pandemic, demand that we question what we value in our respective disciplines and collectively rethink environmental and social sustainability at various scales.',
            'content_ar'=>'عمارة وأكثرهي سلسلة من المحادثات التي تعقد عبر الإنترنت بهدف خلق حوارٍ يستكشف المسؤولية الاجتماعية لدى المعماريين ومخططي العمران الحضري والأكاديميين ومحاوريهم ذوي التخصصات المتعددة. حيث أنَ أوقات الأزمات، كما هو الحال في ظل الجائحة الحالية، تتطلب منا أن نبحث في القيم التي تنطوي عليها تخصصاتنا وأن نعيد التفكير جميعاً في سبل الاستدامة الاجتماعية والبيئية في مختلف النطاقات.'
        ];

            $newPage = \App\Models\Page::create($item);
            $parent_id = \App\Models\Page::where('slug','programs')->select('id')->first();

            if($parent_id)
                $newPage->parent()->create(['page_parent_id'=>$parent_id->id]);
    }
}
