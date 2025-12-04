<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $data = [
             ["name"=> "About","name_ar"=> "عن المؤسسة","slug" => "about", "page_type" => "main"],
                 ["name"=>"Triennial","name_ar"=> "الترينالي","slug"=>"triennial","parent"=>'about'],
                 ["name"=>"Al-Qasimiyah School","name_ar"=> "مدرسة القاسمية","slug"=>"al-qasimiya-school","parent"=>'about'],
                 ["name"=>"Sharjah","name_ar"=> "الشارقة","slug"=>"sharjah","parent"=>'about'],
                 ["name"=>"Partners","name_ar"=> "الشركاء","slug"=>"partners","parent"=>'about', "page_type" => "list"],
                 ["name"=>"Supporters","name_ar"=> "الداعمون","slug"=>"supporters","parent"=>'about'],
                 ["name"=>"Contributors","name_ar"=> "المساهمون","slug"=>"contributors","parent"=>'about'],
                 ["name"=>"Opportunities","name_ar"=> "فرص العمل","slug"=>"opportunities","parent"=>'about', "page_type" => "list"],
             ["name"=>"Triennial 2019","name_ar"=> "ترينالي 2019","slug"=>"triennial-2019", "page_type" => "main"],
                 ["name"=>"Theme","name_ar"=> "الموضوع","slug"=>"theme","parent"=>'triennial-2019'],
                 ["name"=>"Curator","name_ar"=> "القيّم","slug"=>"curator","parent"=>'triennial-2019'],
                 ["name"=>"Participants","name_ar"=> "المشاركون","slug"=>"participants","parent"=>'triennial-2019', "page_type" => "list"],
                 ["name"=>"Venues and Times","name_ar"=> "المواقع والأوقات","slug"=>"venues-and-times","parent"=>'triennial-2019', "page_type" => "list"],
             ["name"=>"Programs","name_ar"=> "البرامج","slug"=>"programs", "page_type" => "main"],
                 ["name"=>"Calendar","name_ar"=> "الجدول","slug"=>"calendar","parent"=>'programs'],
                     ["name"=>"Previous Events","name_ar"=> "الفعاليات السابقة","slug"=>"previous-events","parent"=>'calendar', "page_type" => "list-image"],
                     ["name"=>"Upcoming Events","name_ar"=> "الفعاليات المقبلة","slug"=>"upcoming-events","parent"=>'calendar', "page_type" => "list-image"],
                 ["name"=>"Library","name_ar"=> "المكتبة","slug"=>"library","parent"=>'programs'],
                 ["name"=>"Archive","name_ar"=> "الأرشيف","slug"=>"archive","parent"=>'programs'],
                 ["name"=>"Projects","name_ar"=> "المشاريع","slug"=>"projects","parent"=>'programs',"page_type" => "list"],
             ["name"=>"Media","name_ar"=> "الإعلام","slug"=>"media", "page_type" => "main"],
                 ["name"=>"Releases","name_ar"=> "البيانات الصحفية","slug"=>"releases","parent"=>'media', "page_type" => "list-image"],
                 ["name"=>"Coverage","name_ar"=> "التغطية الصحفية","slug"=>"coverage","parent"=>'media',"page_type" => "list-one-lang"],
                 ["name"=>"Press Kit","name_ar"=> "ملفات الصحافة","slug"=>"press-kit","parent"=>'media'],
             ["name"=>"Contact","name_ar"=> "اتصل بنا","slug"=>"contact", "page_type" => "main"],
             ["name"=>"Terms and Conditions","name_ar"=> "الأحكام والشروط","slug"=>"terms-and-conditions"],
             ["name"=>"Website Credits","name_ar"=> "مصادر الموقع الإلكتروني","slug"=>"website-credits"],
        ];

        foreach ($data as $item){

            $newPage = \App\Models\Page::create( \Illuminate\Support\Arr::except($item, 'parent'));

            if(isset($item['parent']) && $newPage){
                $parent_id = \App\Models\Page::where('slug',$item['parent'])->select('id')->first();

                if($parent_id)
                    $newPage->parent()->create(['page_parent_id'=>$parent_id->id]);
            }

        }
    }
}
