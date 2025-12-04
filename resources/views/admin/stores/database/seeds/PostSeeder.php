<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // PARTNERS
            ["title"=>"Sharjah Urban Planning Council (SUPC)","title_ar"=> "مجلس الشارقة للتخطيط العمراني","slug"=>"sharjah-urban-planning-council","post_type"=>'partners'],
            ["title"=>"Sharjah Art Foundation (SAF)","title_ar"=> "مؤسسة الشارقة للفنون","slug"=>"sharjah-art-foundation","post_type"=>'partners'],
            ["title"=>"Directorate of Town Planning and Survey (DTPS)","title_ar"=> "دائرة التخطيط والمساحة","slug"=>"directorate-of-town-planning-and-survey","post_type"=>'partners'],
            ["title"=>"Bee'ah","title_ar"=> "بيئة","slug"=>"beeah","post_type"=>'partners'],
            ["title"=>"College of Architecture, Art and Design, American University of Sharjah (CAAD)","title_ar"=> "كلية العمارة والفنون والتصميم، الجامعة الأميركية في الشارقة ","slug"=>"american-university-of-sharjah","post_type"=>'partners'],

            // HOME POSTS
            ["title"=>"Lecture: Adrian Lahoud<br/>Details to be announced soon","title_ar"=> "محاضرة: أدريان لحود<br>سنعلن عن التاريخ والمكان قريباً","slug"=>"","post_type"=>'home'],
            ["title"=>"Open Call: Sharjah Shorts","title_ar"=> "دعوة مفتوحة: أفلام الشارقة القصيرة","slug"=>"sharjah-art-foundation","post_type"=>'home'],
            ["title"=>"Previous Lecture:<br/>The Global Climate Ghetto)","title_ar"=> "المحاضرة السابقة:<br>عشوائية المناخ العالمي","slug"=>"directorate-of-town-planning-and-survey","post_type"=>'home'],
            ["title"=>"Previous Panel: <br/>Shifting Morphology of Gulf Cities","title_ar"=> "النقاش السابق:<br/>تشكّل مدن الخليج المتبدل","slug"=>"beeah","post_type"=>'home'],

            // OPPORTUNITIES
            ["title"=>"Online Content Coordinator","title_ar"=> "منسق محتوى إلكتروني","slug"=>"online-content-coordinator","post_type"=>'opportunities'],
            ["title"=>"Program Assistant (Arabic Language)","title_ar"=> "مساعد إعداد برامج باللغة العربية","slug"=>"program-assistant","post_type"=>'opportunities'],
            ["title"=>"Architect and Project Leader","title_ar"=> "معماري ومدير مشاريع","slug"=>"architect-and-project-leader","post_type"=>'opportunities'],

            // CALENDAR EVENTS 2018-11-01
            ['publish_date'=>'2018/04/07',"title"=>"Shifting Morphology of Gulf Cities ","title_ar"=> "تشكّل مدن الخليج المتبدل ","slug"=>"shifting-morphology-of-gulf-cities","post_type"=>'calendar'],
            ['publish_date'=>'2018/05/25',"title"=>"Sharjah Architecture Triennial Theme Announcement","title_ar"=> "ترينالي الشارقة للعمارة: البيان الترحيبي","slug"=>"sharjah-architecture-triennial-theme-announcement","post_type"=>'calendar'],
            ['publish_date'=>'2018/10/04',"title"=>"The Global Climate Ghetto","title_ar"=> "عشوائية المناخ العالمي ","slug"=>"the-global-climate-gheto","post_type"=>'calendar'],
            ['publish_date'=>'12/04/2018',"title"=>"Rights of Future Generations","title_ar"=> "حقوق الأجيال القادمة","slug"=>"rights-of-future-generations","post_type"=>'calendar'],

            // PROJECTS
            ["title"=>"Sharjah Shorts: Open Call","title_ar"=> "أفلام الشارقة القصيرة: دعوة مفتوحة","slug"=>"sharjah-shorts-open-call","post_type"=>'projects'],

            // RELEASES
            ["title"=>"AMIN ALSADEN APPOINTED AS THE DIRECTOR OF SHARJAH ARCHITECTURE TRIENNIAL","title_ar"=> "تعيين أمين السادن مديراً لترينالي الشارقة للعمارة","slug"=>"amin-alsaden-appointed-as-the-director-of-sharjah-architecture-triennial","post_type"=>'releases'],
            ["title"=>"RIGHTS OF FUTURE GENERATIONS ANNOUNCED AS THE THEME OF THE FIRST SHARJAH ARCHITECTURE TRIENNIAL","title_ar"=> "حقوق الأجيال القادمة موضوع النسخة الأولى من ترينالي الشارقة للعمارة","slug"=>"rights-of-future-generations-announced-as-the-theme-of-the-first-sharjah-architecture-triennial","post_type"=>'releases'],
            ["title"=>"ADRIAN LAHOUD APPOINTED CURATOR OF THE INAUGURAL SHARJAH ARCHITECTURE TRIENNIAL","title_ar"=> "أدريان لحّود قيّماً للنسخة الأولى من ترينالي الشارقة للعمارة","slug"=>"adrian-lahoud-appointed-curator-of-the-inaugural-sharjah-architecture-triennial","post_type"=>'releases'],
            ["title"=>"SHARJAH ARCHITECTURE TRIENNIAL: THE FIRST INTERNATIONAL PLATFORM ON ARCHITECTURE IN THE MENASA REGION","title_ar"=> "ترينالي الشارقة للعمارة هي المنصة المعمارية الدولية الأولى في منطقة الشرق الأوسط وشمال إفريقيا وجنوب آسيا","slug"=>"sharjah-architecture-triennial-the-first-international-platform-on-architecture-in-the-menasa-region","post_type"=>'releases'],

            // COVERAGE
            ["title"=>"","title_ar"=> "أمين السادن مديراً لترينالي الشارقة للعمارة",
                //'link_ar'=>"http://www.alkhaleej.ae/alkhaleej/page/fb8668a1-a4da-4f66-bc60-d268429c429b",
                'description_ar'=>"الخليج",
                "slug"=>"","post_type"=>'coverage'],
            [
                "title"=>"AMIN ALSADEN APPOINTED DIRECTOR OF SHARJAH ARCHITECTURE TRIENNIAL","title_ar"=> "",
                //'link'=>"https://www.artforum.com/news/amin-alsaden-appointed-director-of-sharjah-architecture-triennial-75911",
                'description'=>"Art Forum",
                'description_ar'=>"",
                "slug"=>"","post_type"=>'coverage'],

            ["title"=>"Sharjah Architecture Triennial to Open as First Major Platform on Middle Eastern Architecture",
                //'link'=>"https://www.archdaily.com/895729/sharjah-architecture-triennial-to-open-as-first-major-platform-on-middle-eastern-architecture",
                "title_ar"=> "",'description'=>"Arch Daily",'description_ar'=>"","slug"=>"","post_type"=>'coverage'],

            ["title"=>"Sharjah Architecture Triennial will seek to overturn orientalist cliches",
                //'link'=>"https://www.dezeen.com/2018/06/04/sharjah-architecture-triennial-interview-adrian-lahoud-curator/",
                "title_ar"=> "",'description'=>"Dezeen",'description_ar'=>"","slug"=>"","post_type"=>'coverage'],

            ["title"=>"Sharjah Architecture Triennial",
                //'link'=>"http://client.mediaobserver-me.com/article/?slng=en&id=7808287&qk=DfwPiiobIXgNvE7WRtu0ortYtvpa9GwW0WKvZLSOBg4=",
                "title_ar"=> "",'description'=>"MiddleeastArchitect",'description_ar'=>"","slug"=>"","post_type"=>'coverage'],

            ["title"=>"Theme announced for the inaugural 2019 Sharjah Architecture Triennale",
                //'link'=>"https://www.wallpaper.com/architecture/sharjah-architecture-triennale-2019",
                "title_ar"=> "",'description'=>"Wallpaper",'description_ar'=>"","slug"=>"","post_type"=>'coverage'],

            ["title"=>"","title_ar"=> "أدريان لحّود قيّماً للنسخة الأولى من ترينالي الشارقة للعمارة",
                //'link_ar'=>"http://www.alhayat.com/article/4579809/%D8%AB%D9%82%D8%A7%D9%81%D8%A9-%D9%88-%D9%85%D8%AC%D8%AA%D9%85%D8%B9/%D9%85%D9%86%D9%88%D8%B9%D8%A7%D8%AA/%D8%A3%D8%AF%D8%B1%D9%8A%D8%A7%D9%86-%D9%84%D8%AD%D9%88%D8%AF-%D9%82%D9%8A%D9%85%D8%A7-%D9%84%D9%84%D9%86%D8%B3%D8%AE%D8%A9-%D8%A7%D9%84%D8%A3%D9%88%D9%84%D9%89-%D9%85%D9%86-%D8%AA%D8%B1%D9%8A%D9%86%D8%A7%D9%84%D9%8A-%D8%A7%D9%84%D8%B4%D8%A7%D8%B1%D9%82%D8%A9-%D9%84%D9%84%D8%B9%D9%85%D8%A7%D8%B1%D8%A9",
                'description'=>"",'description_ar'=>"الحياة","slug"=>"","post_type"=>'coverage'],

            ["title"=>"What the New Sharjah Architecture Triennial Means for the Middle East",
                //'link'=>"https://www.architecturaldigest.com/story/sharjah-architecture-triennial-means-for-the-middle-east",
                "title_ar"=> "",'description'=>"Architectural Digest",'description_ar'=>"","slug"=>"","post_type"=>'coverage'],

            ["title"=>"","title_ar"=> "ترينالي الشارقة للعمارة» يبحث التغيرات في مدن الخليج العربي",
                //'link_ar'=>"http://www.alkhaleej.ae/economics/page/fa492741-cc23-46a1-96c7-5559b7e5e831",
                'description'=>"",'description_ar'=>"","slug"=>"","post_type"=>'coverage'],
            ["title"=>"","title_ar"=> " الشارقة تطلق ترينالي للعمارة",
                //'link_ar'=>"https://www.emaratalyoum.com/life/culture/2018-04-04-1.1086450",
                'description'=>"",'description_ar'=>"الخليج","slug"=>"","post_type"=>'coverage'],

            ["title"=>"Sharjah Architecture Triennial Hosts First Public Programme",
                //'link'=>"https://www.harpersbazaararabia.com/art/fairs-and-events/sharjah-architecture-triennial-hosts-first-public-programme\"",
                "title_ar"=> "",'description'=>"Harpers Bazaar Arabia",'description_ar'=>"","slug"=>"","post_type"=>'coverage'],

            ["title"=>"First Sharjah Architecture Triennial set for 2019",
                //'link'=>"https://www.hospitality-interiors.net/news/articles/2018/04/1175409363-first-sharjah-architecture-triennial-set-2019",
                "title_ar"=> "",'description'=>"Hospitality Interiors",'description_ar'=>"","slug"=>"","post_type"=>'coverage'],

            ["title_ar"=>"سلطان  القاسمي يصدر مرسوماً اميريا بإنشاء وتنظيم «ترينالي» الشارقة للعمارة",
                //'link'=>"http://alwatannewspaper.ae/?p=308240",
                'description_ar'=>"جريدة الوطن","slug"=>"","post_type"=>'coverage'],

            // CONTRIBUTORS
            ["contributor"=>["letter"=>"A","letter_ar"=>"خ"],"title"=>"Khalid Al Ali ","title_ar"=> "خالد العلي","slug"=>"khalid-al-ali","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"A","letter_ar"=>"أ"],"title"=>"Amin Alsaden","title_ar"=> "أمين السادن","slug"=>"amin-alsaden","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"E","letter_ar"=>"ع"],"title"=>"Abdellah El-Soussi","title_ar"=> "عبد الله السوسي","slug"=>"abdellah-el-soussi","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"K","letter_ar"=>"ع"],"title"=>"Ali Ismail Karimi ","title_ar"=> "علي إسماعيل كريمي","slug"=>"ali-ismail-karimi","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"A","letter_ar"=>"خ"],"title"=>"Khalid Bin Butti Al Muhairi","title_ar"=> "خالد بن بطي المهيري","slug"=>"khalid-bin-butti-al-muhairi","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"B","letter_ar"=>"ح"],"title"=>"Hamed Bukhamseen ","title_ar"=> "حامد بوخمسين","slug"=>"hamed-bukhamseen","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"P","letter_ar"=>"ف"],"title"=>"Varkki Pallathucheril","title_ar"=> "فاركي بالاثوتشيريل ","slug"=>"varkki-pallathucheril","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"P","letter_ar"=>"ر"],"title"=>"Rafael Pizaro","title_ar"=> "رافاييل بيزارو","slug"=>"rafael-pizaro","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"S","letter_ar"=>"م"],"title"=>"Maysa Sabah","title_ar"=> "ميساء صباح","slug"=>"maysa-sabah","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"L","letter_ar"=>"أ"],"title"=>"Anum Laghari","title_ar"=> "آنوم لاغاري","slug"=>"anum-laghari","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"L","letter_ar"=>"أ"],"title"=>"Adrian Lahoud","title_ar"=> "أدريان لحود","slug"=>"adrian-lahoud","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"D","letter_ar"=>"ل"],"title"=>"Lumumba Di-Aping","title_ar"=> "لومومبا دي-أبينغ","slug"=>"lumumba-di-aping","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"O","letter_ar"=>"ع"],"title"=>"Atif Osman ","title_ar"=> "عاطف عثمان","slug"=>"atif-osman","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"M","letter_ar"=>"د"],"title"=>"Diane Mehanna","title_ar"=> "ديان مهنا","slug"=>"diane-mehanna","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"W","letter_ar"=>"أ"],"title"=>"Ellis Woodman","title_ar"=> "إليس وودمان","slug"=>"ellis-woodman","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"A","letter_ar"=>"ف"],"title"=>"Farah Alkhoury","title_ar"=> "فرح الخوري","slug"=>"farah-alkhoury","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"G","letter_ar"=>"ف"],"title"=>"Fermin Guerrero","title_ar"=> "فيرمين غيريرو","slug"=>"fermin-guerrero","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"H","letter_ar"=>"ف"],"title"=>"Farah Hamdan","title_ar"=> "فرح حمدان","slug"=>"farah-hamdan","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"K","letter_ar"=>"ج"],"title"=>"George Katodrytis","title_ar"=> "جورج كاتودريتيس","slug"=>"george-katodrytis","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"A","letter_ar"=>"ج"],"title"=>"Gina Allaf ","title_ar"=> "جينا علاف","slug"=>"gina-allaf","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"A","letter_ar"=>"ح"],"title"=>"Hoor Al Qasimi","title_ar"=> "حور القاسمي","slug"=>"hoor-al-qasimi","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"H","letter_ar"=>"ح"],"title"=>"Hatem Hatem","title_ar"=> "حاتم حاتم","slug"=>"hatem-hatem","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"S","letter_ar"=>"ه"],"title"=>"Hisham Sayed ","title_ar"=> "هشام سيد","slug"=>"hisham-sayed","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"S","letter_ar"=>"أ"],"title"=>"Ieva Saudargaite ","title_ar"=> "إيفا ساودارجيته","slug"=>"ieva-saudargaite","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"A","letter_ar"=>"خ"],"title"=>"Khuloud Al Ali ","title_ar"=> "خلود العلي","slug"=>"khuloud-al-ali","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"H","letter_ar"=>"خ"],"title"=>"Khaled Al Huraimel","title_ar"=> "خالد الحريمل ","slug"=>"khaled-al-huraimel","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"A","letter_ar"=>"خ"],"title"=>"Khalid bin Sultan Al Qasimi","title_ar"=> "خالد القاسمي","slug"=>"khalid-bin-sultan-al-qasimi","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"J","letter_ar"=>"م"],"title"=>"Manaswi Jinadra","title_ar"=> "مناسوي جينادرا","slug"=>"manaswi-jinadra","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"J","letter_ar"=>"م"],"title"=>"Mariam Janjelo","title_ar"=> "مريم جنجلو","slug"=>"mariam-janjelo","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"F","letter_ar"=>"م"],"title"=>"Mahnaz Fancy ","title_ar"=> "ماهناز فانسي","slug"=>"mahnaz-fancy","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"E","letter_ar"=>"م"],"title"=>"Mona El Mousfy","title_ar"=> "منى المصفي","slug"=>"mona-el-mousfy","post_type"=>'contributors'],
            ["contributor"=>["letter"=>"M","letter_ar"=>"ر"],"title"=>"Ryan Miglinczky","title_ar"=> "رايان ميغلنكزكي","slug"=>"ryan-miglinczky","post_type"=>'contributors']
        ];

        foreach ($data as $item){
            $page_id = \App\Models\Page::where('slug',$item['post_type'])->select('id')->first();


            if(isset($item['publish_date'])){
                $item['publish_date'] = strtotime($item['publish_date']);
            }

            if(!$page_id){
                $item['page_id'] = 0;
                \App\Models\Post::create( \Illuminate\Support\Arr::except($item, ['post_type','contributor']));
            }

            if($item['slug']){
                $slug = $item['slug'];
                $existFlag = true;
                $index = 1;
                $temp_slug = $slug;

                while($existFlag==true){
                    $existFlag=false;
                    $check = \App\Models\Post::where('slug' , $temp_slug)->count();

                    if($check) {
                        $existFlag = true;
                        $temp_slug = $slug."-".$index;
                    }

                    $index++;
                }

                $item['slug'] = $temp_slug;
            }

            if($page_id){
                $item['page_id'] = $page_id->id;
                $newPost = \App\Models\Post::create( \Illuminate\Support\Arr::except($item, ['post_type','contributor']));

                if(isset($item['contributor'])){
                    $newPost->contributor()->create($item['contributor']);
                }
            }


        }
    }
}
