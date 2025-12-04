<?php

use Illuminate\Database\Seeder;
use \App\Traits\CanCreateSlug;

class ResearchTypeSeeder extends Seeder
{
    use CanCreateSlug;

    public function __construct(\App\Models\ResearchType $model)
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

        $dummy = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
        $dummyAr = 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال "lorem ipsum" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.';
        $data = [
            ['title' => 'Housing','title_ar' => 'الإسكان ','slug'=>'housing','color'=>'#ed220b'],
            ['title' => 'Schools','title_ar' => 'المدارس ','slug'=>'schools','color'=>'#00a1ff'],
            ['title' => 'Parks','title_ar' => 'الحدائق ','slug'=>'parks','color'=>'#60d836'],
        ];

        foreach ($data as $item){
            $item['content_ar'] = $item['title_ar'].' '.$dummyAr;
            $item['content'] = $item['title'].' '.$dummy;
            $item['pre-1960'] = $item['title'].' '.'pre-1960 '.$dummy;
            $item['pre-1960_ar'] = $item['title'].' '.'pre-1960 '.$dummyAr;
            $item['1960-1980'] = $item['title'].' '.'1960-1980 '.$dummy;
            $item['1960-1980_ar'] = $item['title'].' '.'1960-1980 '.$dummyAr;
            $item['1981-2000'] = $item['title'].' '.'1981-2000 '.$dummy;
            $item['1981-2000_ar'] = $item['title'].' '.'1981-2000 '.$dummyAr;
            $item['2001-2020'] = $item['title'].' '.'2001-2020 '.$dummy;
            $item['2001-2020_ar'] = $item['title'].' '.'2001-2020 '.$dummyAr;
            $item['post-2020'] = $item['title'].' '.'post-2020 '.$dummy;
            $item['post-2020_ar'] = $item['title'].' '.'post-2020 '.$dummyAr;
            $this->model->create($item);
        }
    }
}
