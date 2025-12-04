<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('posts')->delete();
        
        \DB::table('posts')->insert(array (
            0 => 
            array (
                'id' => 1,
            'title' => 'Sharjah Urban Planning Council (SUPC)',
                'title_ar' => 'مجلس الشارقة للتخطيط العمراني',
                'slug' => 'sharjah-urban-planning-council',
                'description' => 'Partner',
                'description_ar' => 'شريك',
                'publish_date' => '2018-11-21',
            'content' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Urban Planning Council (SUPC)</span><span style="color: rgb(33, 37, 41); font-family: Roboto;"> </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Founded in 2006, and recognized by Emiri Decree No. 5 of 2014, the Sharjah Urban Planning Council aims to develop a comprehensive strategy for urban development and infrastructure projects in Sharjah. Its responsibilities include overseeing the preparation, execution, and maintenance of strategic plans for government entities concerned with urban development, infrastructure, and environmental issues. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">With Sheikh </span><a href="http://sharjaharchitecture.org/pages/about/contributors/khalid-bin-sultan-al-qasimi" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Khalid Bin Sultan Al Qasimi</a><span style="color: rgb(33, 37, 41); font-family: Roboto;"> as Chairman, SUPC complements Sharjah\'s efforts to shape and keep pace with the overall volume and direction of local urban development. SUPC works closely with several government departments and authorities, including the Directorate of Planning and Survey, Sharjah Electricity and Water Authority, Roads and Transport Authority, Directorate of Housing, Sharjah Economic Development Department, Sharjah Department of Statistics and Community Development, Environment and Protected Areas Authority, and Sharjah Commerce and Tourism Development Authority, as well as representatives of the private sector. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">For more information, please visit:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><a href="https://supc.shj.ae/" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">supc.shj.ae</a>

',
            'content_ar' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">مجلس الشارقة للتخطيط العمراني</span><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"> </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تأسس مجلس الشارقة للتخطيط العمراني في عام 2006، وتم إشهاره رسمياً بموجب المرسوم الأميري رقم 5 للعام 2014. ويهدف المجلس إلى تطوير استراتيجية شاملة لمشاريع التنمية الحضرية والبنية التحتية في الشارقة. وتتضمن مسؤولياته الإشراف على إعداد الخطط الاستراتيجية وصيانتها وتنفيذها لصالح الجهات الحكومية المعنية بالتنمية الحضرية، والبنية التحتية والقضايا البيئية.</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><p style="color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;">ومع وجود الشيخ<a href="http://sharjaharchitecture.org/pages/about/contributors/khalid-bin-sultan-al-qasimi" style="font-weight: bold; color: rgb(0, 0, 0) !important;"><span style="font-weight: bolder;"> خالد بن سلطان القاسمي</span></a> رئيساً، فإنّ مبادرات مجلس الشارقة للتخطيط العمراني سوف تتكامل مع جهود كافة الجهات الحكومية في الإمارة لمواءمة ومواكبة التوسع الكلّي والتوجه التنموي الحضري المحلي. كما يتعاون المجلس بشكل وثيق مع العديد من الإدارات والهيئات الحكومية، بما في ذلك دائرة التخطيط والمساحة، وهيئة كهرباء ومياه الشارقة، وهيئة الطرق والمواصلات، ومديرية الإسكان، ودائرة التنمية الاقتصادية، ودائرة الإحصاء والتنمية المجتمعية، وهيئة البيئة والمحميات الطبيعية وهيئة الإنماء التجاري والسياحي، فضلاً عن مؤسسات من القطاع الخاص.</p><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">للمزيد من المعلومات، يرجى زيارة الموقع الإلكتروني:</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><a href="https://supc.shj.ae/" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Tahoma; text-align: right; color: rgb(0, 0, 0) !important;">supc.shj.ae</a>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 5,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 06:38:30',
            ),
            1 => 
            array (
                'id' => 2,
            'title' => 'Sharjah Art Foundation (SAF)',
                'title_ar' => 'مؤسسة الشارقة للفنون',
                'slug' => 'sharjah-art-foundation',
                'description' => 'PARTNER',
                'description_ar' => 'شريك',
                'publish_date' => '2018-11-21',
            'content' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Art Foundation (SAF)</span><span style="color: rgb(33, 37, 41); font-family: Roboto;"> </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Established in 2009, and recognized by an Emiri Decree as an independent public body, Sharjah Art Foundation builds on the history of cultural collaboration and exchange that began with the first Sharjah Biennial in 1993. Since Sharjah Biennial 6 in 2003, the program has been led by SAF\'s President and Director Sheikha </span><a href="http://sharjaharchitecture.org/pages/about/contributors/hoor-al-qasimi" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Hoor Al Qasimi</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">. In response to a growing interest in contemporary art, SAF ensures continuity with the history of the Biennial while offering a year-round program of exhibitions and events. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">With a network of spaces spread across the Arts and Heritage areas, and expanding gradually across Sharjah, SAF brings a broad range of contemporary art and cultural programs to communities in the region. Cultivating a spirit of research, experimentation, and excellence, SAF offers support to artists and art practitioners, while acting as a catalyst for collaboration within the Middle East and beyond. Inspired by the cross-fertilization and rich cultural diversity of the country, SAF also provides both national and international leadership in the production and presentation of contemporary visual arts. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">For more information, please visit: </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><a href="http://sharjahart.org/" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">sharjahart.org</a>

',
            'content_ar' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">مؤسسة الشارقة للفنون</span><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"> </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><p style="color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;">تأسست مؤسسة الشارقة للفنون في عام 2009، وتم الاعتراف بها كهيئة عامة مستقلة بموجب مرسوم أميري. وقد نشأت مؤسسة الشارقة للفنون على تاريخ من التعاون والتبادل الثقافي منذ انطلاق بينالي الشارقة في دورته الأولى عام 1993. ومنذ الدورة السادسة من بينالي الشارقة في عام 2003، تولّت الشيخة<a href="http://sharjaharchitecture.org/pages/about/contributors/hoor-al-qasimi" style="font-weight: bold; color: rgb(0, 0, 0) !important;"><span style="font-weight: bolder;">حور القاسمي</span></a> رئاسة المؤسسة والإشراف على برامجها، وذلك استجابة للاهتمامات المتزايدة التي يحظى بها الفن المعاصر. وتحرص مؤسسة الشارقة للفنون على استمرارية دورات البينالي، فيما تواصل برنامجها من المعارض والفعاليات التي تستمر على مدار العام.</p><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">وتقدم مؤسسة الشارقة للفنون للمجتمعات في المنطقة مجموعة واسعة من البرامج الثقافية والفنية المعاصرة، من خلال مواقع العرض الموزعة في منطقة الفنون ومنطقة التراث، والتي تتوسع رقعة انتشارها تدريجياً حول أرجاء الشارقة. ومن خلال تعزيز روح البحث والتجريب والمغايرة، تمنح المؤسسة الدعم للفنانين وممارسي الفنون، فيما تسعى إلى تعميق سبل التعاون داخل منطقة الشرق الأوسط وخارجها، والتي تستلهم التواشج والتنوع الثقافي التي تحفل به الإمارة. كذلك تقوم مؤسسة الشارقة بتزويد المحافل الفنية الوطنية والدولية على حد سواء بنتاجات وعروض الفنون البصرية المعاصرة. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">للمزيد من المعلومات، يرجى زيارة الموقع الإلكتروني: </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><a href="http://sharjahart.org/" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Tahoma; text-align: right; color: rgb(0, 0, 0) !important;">sharjahart.org</a>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 5,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 06:42:04',
            ),
            2 => 
            array (
                'id' => 3,
            'title' => 'Directorate of Town Planning and Survey (DTPS)',
                'title_ar' => 'دائرة التخطيط والمساحة',
                'slug' => 'directorate-of-town-planning-and-survey',
                'description' => 'PARTNER',
                'description_ar' => 'شريك',
                'publish_date' => '2018-11-21',
            'content' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Directorate of Town Planning and Survey (DTPS)</span><span style="color: rgb(33, 37, 41); font-family: Roboto;"> </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">The Directorate of Town Planning and Survey was established by Law No. 2 of 1998, as a government organization responsible for overseeing the comprehensive planning of Sharjah, including its cities and districts. DTPS prepares planning standards and regulations, including coordination of basic utilities and infrastructure, and keeps land records and data across the emirate. It also implements housing policy, and allocates residential, industrial, agricultural and commercial plots to Sharjah citizens. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">An essential dimension of DTPS\'s mission is to conduct studies on transport and traffic planning, urban renewal projects and the re-planning of old cities, and ways of ensuring that urban and housing indicators are respected throughout Sharjah. The preservation of local construction heritage is also part of its responsibilities, as well as monitoring and ensuring that major building projects adhere to the traditions of Islamic architecture. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">For more information, please visit: </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><a href="https://www.sdtps.gov.ae/" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">sdtps.gov.ae</a>

',
            'content_ar' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">دائرة التخطيط والمساحة </span><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"></span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تأسست دائرة التخطيط والمساحة بموجب القانون رقم 2 للعام 1998، كمنظمة حكومية مسؤولة عن الإشراف على التخطيط الشامل في الشارقة، بما في ذلك مدنها ومناطقها المختلفة. وتتولى الدائرة إعداد معايير التخطيط ولوائحه، بما في ذلك تنسيق المرافق الأساسية والبنية التحتية، وحفظ سجلات الأراضي وبياناتها على امتداد الإمارة. وتطبّق سياسة الإسكان وتخصيص مواطني الشارقة بقطع من الأراضي السكنية والصناعية والزراعية والتجارية. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يتمثل البعد الأساسي لمهمة دائرة التخطيط والإسكان في إجراء دراسات حول النقل وتخطيط المرور، ومشاريع التجديد الحضري وإعادة تخطيط المدن القديمة، وطرق ضمان احترام المؤشرات المدنية والإسكانية في جميع أنحاء الشارقة. كما يعدّ الحفاظ على التراث العمراني المحلي أيضا جزءاً من مسؤولياتها، علاوة على مراقبة وضمان التزام مشاريع البناء الكبرى بتقاليد العمارة الإسلامية. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">للمزيد من المعلومات، يرجى زيارة الموقع الإلكتروني: </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><a href="https://www.sdtps.gov.ae/" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Tahoma; text-align: right; color: rgb(0, 0, 0) !important;">sdtps.gov.ae</a>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 5,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 06:41:34',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Bee\'ah',
                'title_ar' => 'بيئة',
                'slug' => 'beeah',
                'description' => 'PARTNER',
                'description_ar' => 'شريك',
                'publish_date' => '2018-11-21',
            'content' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Bee\'ah</span><span style="color: rgb(33, 37, 41); font-family: Roboto;"> </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Bee\'ah was founded in 2007, and has become one of the Middle East\'s fastest growing environmental management companies. Bee\'ah\'s primary goal is to create a sustainable future through creative and resourceful solutions. Its approach and consistent drive towards excellence has helped the company to make rapid progress toward elevating Sharjah to the position of Environmental Capital of the Middle East. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Bee\'ah\'s success lies in the guidance of its visionary leaders and in the tireless efforts of its workforce, consisting of more than 6000 employees, all united in the pursuit of an environmentally viable future. Through revolutionary environmental management practices, systematic waste management, sustainability strategies for key resources and utilization of renewable energy sources, as well as community engagement initiatives, Bee\'ah seeks to set a benchmark for sustainability, for cities and communities in the UAE and beyond. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">For more information, please visit: </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><a href="https://www.beeah.ae/" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">www.beeah.ae</a>

',
            'content_ar' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">بيئة</span><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"> </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تأسست شركة بيئة في عام 2007، لتصبح واحدة من أسرع شركات الإدارة البيئية نمواً في الشرق الأوسط. وتهدف الشركة بشكل رئيسي لخلق مستقبل مستدام من خلال ابتكار حلول عصرية ومبتكرة. وقد ساهم توجه الشركة وميلها إلى التفوق في تحقيقها تقدماً سريعاً نحو رفع الشارقة إلى مصاف أهم العواصم البيئية في الشرق الأوسط. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يكمن نجاح شركة بيئة في التوجه الرؤيوي لقياداتها والجهود الدؤوبة لقوتها العاملة المكوّنة من أكثر من 6000 موظف، جميعهم متحدون في السعي لتحقيق مستقبل بيئي مستدام. ومن خلال تبني ممارسات إدارية بيئية ثورية، وتدوير النفايات بشكل منتظم، واستراتيجيات الاستدامة للموارد الأساسية والاستفادة من مصادر الطاقة المتجددة، بالإضافة إلى مبادرات المشاركة المجتمعية. وتسعى بيئة لإرساء معيار معتمد للاستدامة داخل مدن ومجتمعات الإمارات العربية المتحدة وخارجها. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">للمزيد من المعلومات، يرجى زيارة الموقع الإلكتروني: </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><a href="https://www.beeah.ae/" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Tahoma; text-align: right; color: rgb(0, 0, 0) !important;">www.beeah.ae</a>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 5,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 06:40:33',
            ),
            4 => 
            array (
                'id' => 5,
            'title' => 'College of Architecture, Art and Design, American University of Sharjah (CAAD)',
                'title_ar' => 'كلية العمارة والفنون والتصميم، الجامعة الأميركية في الشارقة ',
                'slug' => 'american-university-of-sharjah',
                'description' => 'PARTNER',
                'description_ar' => 'شريك',
                'publish_date' => '2018-11-21',
            'content' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">College of Architecture, Art and Design, American University of Sharjah (CAAD)</span><span style="color: rgb(33, 37, 41); font-family: Roboto;"> </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">With world-class facilities and a dynamic body of faculty and students, the College of Architecture, Art and Design, American University of Sharjah has become one of the foremost architecture programs in the region. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Founded in 1997, CAAD offers several programs in design, as well as a graduate program in urban planning. The curriculum integrates liberal studies with professional education, starting with a unified design foundations programs and ending in advanced studios that prepare students for practice. CAAD has been committed to providing a comprehensive education that enables its graduates to make significant contributions to the Gulf region and the broader global community, through conscientious participation in the making of the built environment, relying on a deep understanding of culture, ethical engagement in society, and respect for the creative skills needed to establish sustainable and livable cities. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">CAAD\'s commitment to excellence has been acknowledged internationally, with the architecture degree program becoming the first program of its kind outside North America to be given accreditation by the National Architectural Accrediting Board (NAAB) of the United States.</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">For more information, please visit:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><a href="https://www.aus.edu/caad" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">www.aus.edu/caad</a>

',
            'content_ar' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">كلية العمارة والفنون والتصميم، الجامعة الأميركية في الشارقة </span><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"></span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">بمنشآتها عالمية المستوى وطاقمها الديناميكي المؤلّف من أعضاء هيئة التدريس والطلاب، أصبحت كلية العمارة والفنون والتصميم، في الجامعة الأميركية في الشارقة واحدة من أبرز مرافق تدريس العمارة في المنطقة. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تأسست كلية العمارة والفنون والتصميم في عام 1997، حيث تقدم العديد من البرامج في حقل التصميم، فضلاَ عن برنامج الدراسات العليا في التخطيط الحضري. يدمج المنهج الأكاديمي الدراسات الليبرالية بالتعليم المهني، بدءاً من تدريس أسس التصميم وصولًا إلى دراسات متقدمة احترافية تعدّ الطلاب للانخراط في سوق العمل. واظبت الكلية بتوفير التعليم الشامل الذي يتيح لخريجيها تقديم إسهامات نوعية كبيرة لمنطقة الخليج والعالم، وذلك من خلال المشاركة الواعية في صنع البيئة العمرانية، والاعتماد على فهم عميق للثقافة والانخراط الأخلاقي في المجتمع واحترام المهارات الإبداعية اللازمة لإنشاء مدن مستدامة ونابضة بالحياة. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">وقد تم الاعتراف دولياً بجودة الكلية، حيث أصبح برنامج العمارة الخاص بها الأول من نوعه خارج أميركا الشمالية والذي منحه الاعتماد من قبل المجلس الوطني للاعتماد المعماري (NAAB) في الولايات المتحدة. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">للمزيد من المعلومات، يرجى زيارة الموقع الإلكتروني: </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><a href="https://www.aus.edu/caad" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Tahoma; text-align: right; color: rgb(0, 0, 0) !important;">www.aus.edu/caad</a>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 5,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 06:39:50',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Lecture: Adrian Lahoud<br/>Details to be announced soon',
                'title_ar' => 'محاضرة: أدريان لحود<br>سنعلن عن التاريخ والمكان قريباً',
                'slug' => '',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-21',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 0,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-21 14:22:19',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => ' ',
                'title_ar' => ' ',
                'slug' => '-6',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-21',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 0,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:24:53',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'Previous Lecture:<br/>The Global Climate Ghetto',
                'title_ar' => 'المحاضرة السابقة:<br>عشوائية المناخ العالمي',
                'slug' => 'previous-lecturebrthe-global-climate-ghetto',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-21',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 0,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-21 14:23:18',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Previous Panel: <br/>Shifting Morphology of Gulf Cities',
                'title_ar' => 'النقاش السابق:<br/>تشكّل مدن الخليج المتبدل',
                'slug' => 'beeah',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-21',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 0,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-21 14:23:07',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'Online Content Coordinator',
                'title_ar' => 'منسق محتوى إلكتروني',
                'slug' => 'online-content-coordinator',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-21',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Architecture Triennial is hiring an Online Content Coordinator to join our growing team. The position entails handling our public communication, including our online platforms, such as our website and social media outlets, as well as communication with our local, regional, and international audiences and stakeholders. Familiarity with the culture of the UAE and Gulf region, and/or the Global South, is desirable, as this role requires awareness of the specificity of our place while drawing meaningful links with the rest of the world. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">You will work closely with the Director, communications and research staff, and other members of the team, toward fulfilling our mission and sharing our knowledge with the public. We aim to garner a substantial following over the next few months as we evolve into the premier forum for discussions around architecture and urbanism in the region. Therefore, this position offers the right candidate an exciting opportunity to play a key role in the growth of our organization. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Your primary responsibilities involve creating, editing, and disseminating content across various online communication channels as well as investigating opportunities for increasing the organization’s online visibility. Additional tasks include technical maintenance and coordination of our online platforms, and ensuring that our image and content conform to our vision and research strategy. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Architecture Triennial offers a dynamic creative work environment that is simultaneously locally and internationally oriented, and a competitive salary commensurate with experience and skills. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Responsibilities include:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; color: rgb(33, 37, 41); font-family: Roboto; font-size: 16px;"><li style="margin-bottom: 10px;">Conduct own research, coordinate with other researchers, and share findings and news with the public.<br></li><li style="margin-bottom: 10px;">Manage social media and website engagement including responding to posted questions, comments, and messages.<br></li><li style="margin-bottom: 10px;">Create, coordinate, and edit content for newsletters and press releases in collaboration with the team.<br></li><li style="margin-bottom: 10px;">Remain updated on the latest developments in online communication and publishing, and apply this knowledge toward the upkeep of our online platforms.<br></li><li style="margin-bottom: 10px;">Manage and edit submissions by external collaborators and explore the most appropriate online publishing methods.</li></ul><span style="color: rgb(33, 37, 41); font-family: Roboto;">Requirements include:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; color: rgb(33, 37, 41); font-family: Roboto; font-size: 16px;"><li style="margin-bottom: 10px;">An advanced degree (master\'s or bachelor\'s degree) in architecture or art, with a marketing or public relations experience desirable. <br>If you have a different background that you believe qualifies you for the job, please apply and elaborate.<br></li><li style="margin-bottom: 10px;">Excellent communication skills and proficiency in written English. Knowledge of Arabic is highly desirable.<br></li><li style="margin-bottom: 10px;">Excellent writing and editing skills, for creating original content as well as modifying and refining contributions by others.<br></li><li style="margin-bottom: 10px;">Attentive to detail, accuracy, and quality of all content. Highly disciplined, and aware of international copyright standards.<br></li><li style="margin-bottom: 10px;">Working knowledge of graphics software such as Adobe CS, and of MS Office, especially Word and Excel.<br></li><li style="margin-bottom: 10px;">Ability to maintain content and functionality on both website and social media accounts, troubleshooting and devising solutions, with or without the support of IT staff.<br></li><li style="margin-bottom: 10px;">Proactive, resourceful, and able to thrive in the demanding work environment of a young organization. Flexible in terms of working hours, especially closer to deadlines.</li></ul><span style="color: rgb(33, 37, 41); font-family: Roboto;">To apply, please email:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">One-page cover letter (highlighting your experience, strengths, and explaining your interest in this position), resume, names and contacts of two professional or academic references, two short writing samples, and any other relevant supporting documents. Everything should be combined into one PDF file no larger than 2mb. Applications, and all enquiries, should be emailed to </span><a href="mailto:careers@sharjaharchitecture.org?subject=Online%20Content%20Coordinator" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">careers@sharjaharchitecture.org</a><span style="color: rgb(33, 37, 41); font-family: Roboto;"> with "Online Content Coordinator" as the subject heading. Only those shortlisted for interviews will be contacted.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يعلن ترينالي الشارقة للعمارة عن حاجته إلى منسق محتوى إلكتروني عبر الإنترنت للانضمام إلى فريقنا المتنامي. ويتطلب المنصب إدارة الاتصال، بما فيها منصاتنا عبر الإنترنت، مثل الموقع الإلكتروني ووسائل التواصل الاجتماعي، وكذلك التواصل مع جمهورنا المحلي و الإقليمي والدولي بالإضافة لأطراف معينة أخرى. إن الإلمام بثقافة دولة الإمارات ومنطقة الخليج و/أو مناطق الجنوب أمر مرغوب به، لأن هذا الدور يتطلب إدراكاً لخصوصية مكانتنا المحلية مع حرصنا على إرساء روابط قيّمة مع بقية العالم </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">سوف تتعاون عن قرب وبشكل مكثّف مع المدير، وموظفي الاتصالات والأبحاث، وأعضاء الفريق الآخرين، بغية إيصال رسالتنا ومشاركة معارفنا مع الجمهور. نحن نطمح إلى حصد نسب متابعة كبيرة خلال الأشهر القليلة المقبلة، عن طريق تكريس منتدانا الرئيسي للمناقشات حول العمارة والتحضّر في المنطقة. لذا، يشكّل هذا المنصب للمرشح المناسب فرصة مثيرة للعب دور رئيسي في تنامي مؤسستنا. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تتضمن مهامك الأساسية إنشاء المحتوى الإلكتروني وتعديله ونشره على مختلف قنوات الاتصال عبر شبكة الإنترنت، بالإضافة إلى التحقق من الفرص المتاحة لتفعيل ورفع نسبة مشاهدة المؤسسة عبر الإنترنت. هذا وتشمل المهام الإضافية الصيانة الفنية والتنسيق لمنصاتنا عبر الإنترنت، وضمان توافق صورتنا والمحتوى المعروض مع رؤيتنا واستراتيجية البحث. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يوفر ترينالي الشارقة للعمارة بيئة عمل إبداعية ديناميكية موجّهة محلياً وعالمياً في الوقت ذاته، بالإضافة إلى راتب تنافسي يتناسب مع الخبرة والمهارات. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تشمل المسؤوليات ما يلي:</span><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; padding-right: 18px; color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;"><li style="margin-bottom: 10px;">إجراء البحوث الخاصة، التنسيق مع الباحثين الآخرين ومشاركة النتائج والأخبار مع الجمهور.<br></li><li style="margin-bottom: 10px;">إدارة شبكات التواصل الاجتماعي والموقع الإلكتروني بما في ذلك الرد على الأسئلة والتعليقات والرسائل المنشورة.<br></li><li style="margin-bottom: 10px;">إنشاء وتنسيق وتحرير محتوى النشرات الإخبارية والبيانات الصحفية بالتعاون مع الفريق.<br></li><li style="margin-bottom: 10px;">المواظبة على الاطلاع على آخر التطورات في مجال الاتصال والنشر عبر الإنترنت، وتطبيق هذه المعرفة في تطوير منصاتنا عبر الإنترنت.<br></li><li style="margin-bottom: 10px;">إدارة وتحرير مساهمات المتعاونين الخارجيين واستكشاف أنسب أساليب النشر على الإنترنت.</li></ul><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تشمل المتطلبات:</span><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; padding-right: 18px; color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;"><li style="margin-bottom: 10px;">درجة تعليمية متقدمة (الماجستير أو البكالوريوس) في العمارة أو الفنون. والخبرة في مجالَي التسويق أو العلاقات العامة مرغوبة. إذا كانت لديك خلفية مختلفة تعتقد أنها تؤهلك للحصول على الوظيفة، يرجى طرحها مع تقديم شرح وافٍ عنها.<br></li><li style="margin-bottom: 10px;">مهارات تواصل كتابية ممتازة وكفاءة في اللغة الإنجليزية. إجادة اللغتين العربية والإنجليزية تعد مهارة تنافسية.<br></li><li style="margin-bottom: 10px;">مهارات ممتازة في الكتابة والتحرير بهدف ضمان إنشاء المحتوى الصحيح بالإضافة إلى تعديل وتنقيح المساهمات الكتابية المرسلة من قبل الآخرين.<br></li><li style="margin-bottom: 10px;">الاهتمام بالتفاصيل ومراعاة الدقة والجودة في كتابة كافة المحتويات مع درجة عالية من الالتزام بالقواعد اللغوية، ووعي تام بمعايير حقوق النشر الدولية.<br></li><li style="margin-bottom: 10px;">معرفة في العمل على برامج التصميم مثل Adobe CS، و MS Office، مثل Word و Excelبالتحديد.<br></li><li style="margin-bottom: 10px;">القدرة على متابعة المحتوى وآلية نشره على الموقع الإلكتروني ومواقع التواصل الاجتماعي، والقدرة على تحديد الأخطاء وتصحيحها ووضع الحلول سواء توفر دعم موظفي تكنولوجيا المعلومات أو لم يتوفر..<br></li><li style="margin-bottom: 10px;">المبادرة، وسرعة البديهة، والقدرة على مواكبة متطلبات بيئة العمل النشطة في مؤسسة شابّة. علاوة على المرونة من حيث ساعات العمل، لا سيما عند اقتراب حلول المواعيد النهائية لتسليم المواد.</li></ul><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">رسالة تمهيدية مؤلفة من صفحة واحدة (تعرض فيه مجال خبرتك ونقاط القوة لديك مع توضيح أسباب اهتمامك بالحصول على فرصة العمل هذه)، بالإضافة إلى السيرة الذاتية والمهنية، ودعمها بمعلومات اتصال لجهتين من المراجع المهنية أو الأكاديمية التي سبق لك التعامل معها، وعيّنتين كتابيتين قصيرتين، بالإضافة إلى أية مستندات داعمة أخرى ذات صلة. يجب دمج كل شيء في ملف PDF واحد لا تزيد سعته على 2 ميغابايت. وإرسال الطلبات، وجميع الاستفسارات عبرعنوان البريد الإلكتروني </span><a href="mailto:careers@sharjaharchitecture.org?subject=%D9%85%D9%86%D8%B3%D9%82%20%D9%85%D8%AD%D8%AA%D9%88%D9%89%20%D8%A5%D9%84%D9%83%D8%AA%D8%B1%D9%88%D9%86%D9%8A" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Tahoma; text-align: right; color: rgb(0, 0, 0) !important;">careers@sharjaharchitecture.org</a><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"> مع إدراج مسمّى "منسق محتوى إلكتروني" عنواناً للبريد. سيتم الاتصال فقط بمن يتم اختيارهم لإجراء المقابلات.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 8,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 11:06:49',
            ),
            10 => 
            array (
                'id' => 11,
            'title' => 'Program Assistant (Arabic Language)',
                'title_ar' => 'مساعد إعداد برامج باللغة العربية',
                'slug' => 'program-assistant',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-21',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Architecture Triennial is hiring a Program Assistant with proficiency in spoken and written Arabic to join our growing team. The position entails performing various administrative duties in support of the team, such as data entry, management of our records and databases, and occasional research, as well as producing English-Arabic translations on a regular basis. Familiarity with the UAE and Arab culture is highly desirable, as this role requires sensitivity to how we communicate as an organization with our local, regional, and international audiences.	</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">You will work closely with the Director, management staff, and other members of the team, towards producing Arabic-language content for our various projects including our website and social media platforms. You will also support the team in ensuring that miscellaneous office logistics and institutional operations are conducted smoothly and in a timely fashion. The ideal candidate is an articulate, proactive, and resourceful problem-solver who can take initiative, preempt and facilitate the needs of a young organization. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Architecture Triennial offers a dynamic creative work environment that is simultaneously locally and internationally oriented, and a competitive salary commensurate with experience and skills. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Responsibilities include:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; color: rgb(33, 37, 41); font-family: Roboto; font-size: 16px;"><li style="margin-bottom: 10px;">Translate a variety of English texts, from brief social media posts and official correspondence, to press releases and essays, in excellent and clear Arabic.</li><li style="margin-bottom: 10px;">Data entry, creation, and maintenance of various databases, including our library and archive. Coordinate collection and organization of data from members of our team, as well as our partners and collaborators.</li><li style="margin-bottom: 10px;">Support the team in handling various internal and external logistics, including payments, orders, deliveries, travel, and hospitality, among others.</li><li style="margin-bottom: 10px;">Handle our Arabic communications, from responding to emails and phone calls in Arabic to coordinating with various Arabic speaking public audiences as well as individuals and agencies in the UAE and region.</li><li style="margin-bottom: 10px;">Maintain and expand our glossary of specialized architecture and urbanism terms and their translation into Arabic. Apply this evolving knowledge toward streamlining and standardizing our translations.</li><li style="margin-bottom: 10px;">Conduct research on Arabic publications and media outlets, and on how to increase the reach of the Triennial across Arabic speaking populations worldwide.</li><li style="margin-bottom: 10px;">Maintain our library database, in English and Arabic, and assist in mapping, collecting, and annotating publications and other resources in Arabic.</li></ul><span style="color: rgb(33, 37, 41); font-family: Roboto;">Requirements include:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; color: rgb(33, 37, 41); font-family: Roboto; font-size: 16px;"><li style="margin-bottom: 10px;">Degree (master\'s or bachelor\'s) in translation, languages, Arabic literature, or related fields; alternatively, a degree in an administration field, with proven proficiency in written Arabic.</li><li style="margin-bottom: 10px;">Minimum two years of relevant experience in translation, especially of academic and literary texts, and administrative support. Previous experience in translating art, architecture, or cultural texts is an added advantage.</li><li style="margin-bottom: 10px;">Excellent Arabic communication, writing, and translation skills. Good communication skills in English also required.</li><li style="margin-bottom: 10px;">Expert knowledge in MS Office, especially Word and Excel. Familiarity with graphics software such as Adobe CS is an added advantage.</li><li style="margin-bottom: 10px;">Attentive to detail, accuracy, and quality of all content. Highly disciplined, and aware of local business, academic, and cultural customs.</li><li style="margin-bottom: 10px;">Willingness to perform a wide variety of tasks is crucial. Flexible in terms of working hours, especially closer to deadlines.</li></ul><span style="color: rgb(33, 37, 41); font-family: Roboto;">To apply, please email:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">One-page cover letter (highlighting your experience, strengths, and explaining your interest in this position), resume, names and contacts of two references, two short translations and/or Arabic writing samples, and any other relevant supporting documents. Everything should be combined into one PDF file no larger than 2MB. Applications, and all inquiries, should be emailed to </span><a href="mailto:careers@sharjaharchitecture.org?subject=Program%20Assistant%20(Arabic%20Language)" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">careers@sharjaharchitecture.org</a><span style="color: rgb(33, 37, 41); font-family: Roboto;"> with "Program Assistant" as the subject heading. Only those shortlisted for interviews will be contacted.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يعلن ترينالي الشارقة للعمارة عن حاجته إلى مساعد إعداد برامج يتقن اللغة العربية حديثاً وكتابةً للانضمام إلى فريقنا المتنامي. يتطلب المنصب أداء مهام إدارية مختلفة لدعم الفريق، مثل إدراج البيانات، إدارة السجلات وقواعد البيانات، والأبحاث الفصلية، بالإضافة إلى إجراء ترجمات من الإنجليزية إلى العربية بشكل منتظم. يحبّذ للغاية إلمام المرشّح بالثقافة العربية وثقافة الإمارات العربية المتحدة، حيث أن أحد شروط هذا المنصب هو أالحرص على كيفية تواصلنا كمؤسسة مع جمهورنا المحلي والإقليمي والدولي. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">سوف يتم التعاون مباشرة مع المدير، وموظفي الإدارة وكافة أعضاء الفريق، في إنتاج محتوى باللغة العربية لمشاريعنا المختلفة بما في ذلك الموقع الإلكتروني ووسائل التواصل الاجتماعي. ودعم الفريق في إجراء العمليات اللوجستية المتنوعة للمكاتب والعمليات المؤسسية بسلاسة وإتمامها في الوقت المناسب. يجب أن يمتاز المرشح بقدرته على التعامل مع الصعوبات وتجاوزها، والأخذ بزمام المبادرات الإبداعية، وتسهيل الاحتياجات العملية في هذه المؤسسة الشابّة. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يوفر ترينالي الشارقة للعمارة بيئة عمل إبداعية ديناميكية موجّهة محلياً وعالمياً في الوقت ذاته، بالإضافة إلى راتب تنافسي يتناسب مع الخبرة والمهارات. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تشمل المسؤوليات ما يلي:</span><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; padding-right: 18px; color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;"><li style="margin-bottom: 10px;">إترجمة مجموعة متنوعة من النصوص الإنجليزية، بدءاً من المنشورات القصيرة على وسائل التواصل الاجتماعية، والمراسلات الرسمية، وصولاً إلى النشرات الصحفية والمقالات، وإعادة صياغتها بلغة عربية سليمة وواضحة.</li><li style="margin-bottom: 10px;">إدراج البيانات، وإنشاء وصيانة قواعد البيانات المختلفة، بما في ذلك المكتبة والأرشيف. علاوة على تنسيق وتجميع وتنظيم البيانات من أعضاء الفريق والشركاء وكافة الجهات المتعاونة مع المؤسسة.</li><li style="margin-bottom: 10px;">دعم الفريق في التعامل مع مختلف الخدمات اللوجستية الداخلية والخارجية، بما في ذلك المدفوعات والأوامر وبيانات التسليم والسفر والضيافة وغيرها.</li><li style="margin-bottom: 10px;">التعامل مع عمليات الاتصال التي تتم بالعربية، من الرد على رسائل البريد الإلكتروني والمكالمات الهاتفية باللغة العربية وصولًا إلى التنسيق والتواصل مع مختلف متابعينا الناطقين باللغة العربية وكذلك الأفراد والوكالات في دولة الإمارات العربية المتحدة والمنطقة.</li><li style="margin-bottom: 10px;">تحسين المستوى اللغوي لقاموس المصطلحات المعمارية والحضرية الخاص بالمنظمة، وإضافة مصطلحات جديدة عليه وترجمتها إلى اللغة العربية. مع استخدام هذه المعرفة المتطورة أيضاً في تبسيط وتوحيد إصداراتنا المترجمة على تنوعها.</li><li style="margin-bottom: 10px;">إجراء البحوث على المطبوعات العربية والمنشورات الإعلامية، وابتكار طرق جديدة لتنشيط وضمان تعريف أكبر شريحة ممكنة من الجهات الناطقة بالعربية في جميع أنحاء العالم بالترينالي.</li><li style="margin-bottom: 10px;">صيانة قاعدة بيانات المكتبة لدينا، وتطويرها باللغتين الإنجليزية والعربية، والمساهمة في رسم خرائط بيانية وتجميع المنشورات وكافة الموارد التحريرية باللغة العربية وتذييلها بتعليقات وافية.</li></ul><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تشمل المتطلبات:</span><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; padding-right: 18px; color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;"><li style="margin-bottom: 10px;">درجة (الماجستير أو البكالوريوس) في الترجمة، أواللغات، أوالأدب العربي أو أية مجالات ذات صلة؛ أو الاستعاضة عنها بشهادة في مجال الإدارة، مع كفاءة مثبتة في اللغة العربية المكتوبة.</li><li style="margin-bottom: 10px;">خبرة لا تقل عن سنتين في مجال الترجمة، خصوصاً فيما يتعلق بالنصوص الأكاديمية والأدبية، والدعم الإداري. ويفضّل توافر خبرة مسبقة في ترجمة نصوص تتمحور حول الفن أو العمارة أو الثقافة بشكل عام.</li><li style="margin-bottom: 10px;">إتقان مهارات الكتابة والترجمة باللغة العربية. مع ضرورة توار مهارات تواصل جيدة باللغة الإنجليزية.</li><li style="margin-bottom: 10px;">معرفة عالية في استخدام Microsoft office، لا سيّما برنامجَي Word وExcel. ويفضّل الإلمام بكيفية استخدام برامج الرسومات مثل Adobe CS.</li><li style="margin-bottom: 10px;">مراعاة الاهتمام بالتفاصيل والدقة والجودة في تجميع المحتويات. مع توافر درجة عالية من التنظيم، والوعي بكافة الأعمال التجارية المحلية والأكاديمية والعادات الثقافية للبيئة المحيطة.</li><li style="margin-bottom: 10px;">المبادرة، وسرعة البديهة، والقدرة على مواكبة متطلبات بيئة العمل النشطة في هذه المؤسسة الشابّة. علاوة على المرونة من حيث ساعات العمل، لا سيما عند اقتراب حلول المواعيد النهائية لتسليم المواد.</li></ul><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">للتقدم بطلب، يرجى إرسال بريد إلكتروني مرفق طيّه ما يلي:</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">رسالة تمهيدية مؤلفة من صفحة واحدة (تعرض فيه مجال خبرتك ونقاط القوة لديك مع توضيح أسباب اهتمامك بالحصول على فرصة العمل هذه)، بالإضافة إلى السيرة الذاتية والمهنية، ودعمها بمعلومات اتصال لجهتين من المراجع المهنية أو الأكاديمية التي سبق لك التعامل معها، وعيّنتين كتابيتين قصيرين، بالإضافة إلى أية مستندات داعمة أخرى ذات صلة. يجب دمج كل شيء في ملف PDF واحد لا تزيد سعته على 2 ميغابايت. وإرسال الطلبات، وجميع الاستفسارات عبرعنوان البريد الإلكتروني </span><a href="mailto:careers@sharjaharchitecture.org?subject=%D9%85%D8%B3%D8%A7%D8%B9%D8%AF%20%D8%A5%D8%B9%D8%AF%D8%A7%D8%AF%20%D8%A8%D8%B1%D8%A7%D9%85%D8%AC%20%D8%A8%D8%A7%D9%84%D9%84%D8%BA%D8%A9%20%D8%A7%D9%84%D8%B9%D8%B1%D8%A8%D9%8A%D8%A9" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Tahoma; text-align: right; color: rgb(0, 0, 0) !important;">careers@sharjaharchitecture.org</a><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"> مع وضع مسمّى "مساعد إعداد برامج باللغة العربية" عنواناً للموضوع. سيتم الاتصال فقط بمن يتم اختيارهم لإجراء المقابلات.</span>',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 8,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 11:06:10',
            ),
            11 => 
            array (
                'id' => 12,
                'title' => 'Architect and Project Leader',
                'title_ar' => 'معماري ومدير مشاريع',
                'slug' => 'architect-and-project-leader',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-21',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Architecture Triennial is looking for an Architect and Project Leader to join our growing team. This multifaceted position is an exciting opportunity for the right candidate to contribute to the organization\'s evolving vision, develop new initiatives, and participate in realizing various upcoming projects, including the inaugural edition. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">The ideal candidate is knowledgeable about historical and contemporary global architectural culture; has a high level of design sophistication; proficiency in conceptualizing, planning, and representing projects at a variety of scales; and experience in leading complex projects, and strong time management skills. The candidate possesses not only exceptional skills in architecture, but is also talented in writing and communication, photography, and graphics. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">You will work closely with the Director and coordinate with the rest of the team as well as local and international collaborators. You will conduct a broad range of research, oversee projects through to production, manage relationships with consultants, manufacturers, and suppliers, and ensure timely delivery. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Architecture Triennial offers a dynamic creative work environment that is simultaneously locally and internationally oriented, and a competitive salary commensurate with experience and skills. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Responsibilities include:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; color: rgb(33, 37, 41); font-family: Roboto; font-size: 16px;"><li style="margin-bottom: 10px;">Research, including data collection, interpretation, and visualization, and guiding more junior staff or interns studying a variety of subjects, from the history and theory of architecture, to materials, products, and potential collaborators and suppliers.<br></li><li style="margin-bottom: 10px;">Apply analytic and representational skills in studying fields beyond and yet inextricably linked to architecture, including sociopolitics, environment, art, media, technology, and curating, among others.<br></li><li style="margin-bottom: 10px;">Translate the Triennial\'s and collaborators\' visions by realizing and coordinating projects on the ground. This will involve working independently, or within a team(s) on projects in all work stages, from conceptual design through to construction phases.<br></li><li style="margin-bottom: 10px;">Draft architectural drawings and renders, prepare presentations, technical documentation, and build physical models.<br></li><li style="margin-bottom: 10px;">Draft architectural drawings and renders, prepare presentations, technical documentation, and build physical models.<br></li><li style="margin-bottom: 10px;">Monitor the quality and consistency of projects produced by the Triennial, in line with our overall mission and highest global standards.<br></li></ul><span style="color: rgb(33, 37, 41); font-family: Roboto;">Requirements include:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; color: rgb(33, 37, 41); font-family: Roboto; font-size: 16px;"><li style="margin-bottom: 10px;">Master\'s degree in Architecture, Landscape Architecture, Urban Planning, or other relevant fields, from a reputable international program.<br></li><li style="margin-bottom: 10px;">Minimum 2 years of post-graduate experience in an internationally recognized design practice or cultural institution, and strong interest in research-based architecture.<br></li><li style="margin-bottom: 10px;">Strong research, conceptual, and design abilities demonstrated in a portfolio representative of the applicant\'s range of skills.<br></li><li style="margin-bottom: 10px;">Proficiency in 3D software (e.g. AutoCAD, Revit, Rhino), Adobe CS, and MS Office is required. Experience in project management software is highly desirable.<br></li><li style="margin-bottom: 10px;">Excellent communication skills and proficiency in English. Basic knowledge of Arabic is desirable but not required. Other languages are an added advantage.<br></li><li style="margin-bottom: 10px;">Intelligent understanding of and interest in addressing the specificities of the culture and environment of Sharjah, UAE, and Global South.<br></li><li style="margin-bottom: 10px;">Experience working on complex and large scale projects on tight deadlines, and confidence in working in a demanding and fast-paced environment. Flexible in terms of working hours, especially closer to deadlines.<br></li><li style="margin-bottom: 10px;">Self-motivated, resourceful, organized, and highly-disciplined, and capable of leading projects and guiding others.<br></li></ul><span style="color: rgb(33, 37, 41); font-family: Roboto;">To apply, please email:</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">One-page cover letter (highlighting your experience, strengths, and explaining your interest in this position), curriculum vitae, names and contacts of at least two references, work samples and/or links to an online website or portfolio, and any other relevant supporting documents. Everything should be combined into one PDF file no larger than 2MB. Applications, and all inquiries, should be emailed to </span><a href="mailto:careers@sharjaharchitecture.org?subject=Architect%20and%20Project%20Leader" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">careers@sharjaharchitecture.org</a><span style="color: rgb(33, 37, 41); font-family: Roboto;"> with "Architect and Project Leader" as the subject heading. Only those whose skills and backgrounds fit the description above and shortlisted for interviews will be contacted.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يبحث ترينالي الشارقة للعمارة عن معماري ومدير مشاريع للانضمام إلى فريقنا المتنامي. هذه الوظيفة المتعددة الأوجه تمثل فرصة مثيرة للمرشح المناسب للمساهمة في الرؤية المتطورة للمنظمة، وتتطوير مبادرات جديدة، والمشاركة في تحقيق العديد من المشاريع المقبلة بما في ذلك الدورة الافتتاحية. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">على المرشح المثالي امتلاك معرفة جيدة بثقافة العمارة العالمية التاريخية والمعاصرة، مستوى عال من التصميم، الكفاءة في وضع المفاهيم، التخطيط، وتقديم المشاريع ذات المقاييس المختلفة، مع خبرة في قيادة المشاريع المعقدة، ومهارات عالية في إدارة الوقت. لا يمتلك المرشح الذي نسعى إليه مهارات استثنائية في العمارة فحسب، ولكن لديه موهبة في الكتابة والتواصل والتصوير والغرافيك. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">سيجري العمل عن قرب مع المدير والتنسيق مع باقي أعضاء الفريق بالإضافة إلى المتعاونين المحليين والدوليين. سوف تساهم في إجراء مجموعة واسعة من الأبحاث، قيادة على المشاريع الى الإنتاج، وإدارة العلاقات مع الاستشاريين والمصنّعين والمورّدين مع ضمان التسليم في الوقت المناسب. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يوفر ترينالي الشارقة للعمارة بيئة عمل إبداعية ديناميكية موجّهة محليًّا وعالميًّا في الوقت ذاته، بالإضافة إلى راتب تنافسي يتناسب مع الخبرة والمهارات. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تشمل المسؤوليات ما يلي:</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; padding-right: 18px; color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;"><li style="margin-bottom: 10px;">إجراء البحوث، بما في ذلك جمع البيانات، التفسير، التصور، وتوجيه الموظفين المبتدئين أو المتدربين الذين يدرسون مجموعة متنوعة من المواضيع، والتي قد تشمل تاريخ ونظريات العمارة، فضلا عن المواد والمنتجات، والمتعاونين والمورّدين المحتملين.<br></li><li style="margin-bottom: 10px;">تطبيق المهارات التحليلية والتمثيلية الاستثنائية بذكاء في دراسة المجالات التي لا يمكن فك ارتباطها بالعمارة، بما في ذلك الاجتماعية السياسية، البيئة، الفنون، الاعلام، التكنولوجيا، مفاهيم العرض، وغيرها.<br></li><li style="margin-bottom: 10px;">ترجمة رؤية الترينالي والمتعاونين من خلال إرساء المفاهيم وصياغة المقترحات، وتنسيق التنفيذ اليومي واحتياجات المشاريع على أرض الواقع. العمل بشكل مستقل، أو ضمن فريق على المشاريع في جميع مراحل العمل، من التصميم النظري وحتى مراحل البناء.<br></li><li style="margin-bottom: 10px;">وضع مسودات مشاريع الرسومات والمخططات المعمارية، وإعداد العروض التقديمية، والوثائق الفنية، وبناء النماذج العينيّة.<br></li><li style="margin-bottom: 10px;">وضع تصوُّر لمجموعة من المطبوعات واللافتات وحزم الاتصالات وتنسيقها والإشراف عليها.<br></li><li style="margin-bottom: 10px;">مراقبة جودة واتساق المشروعات التي ينتجها الترينالي بما يتماشى مع رؤيتنا الشاملة ونخبة المعايير العالمية.<br></li></ul><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">الخبرات التعليمية والمهارات المطلوبة:</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; padding-right: 18px; color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;"><li style="margin-bottom: 10px;">درجة الماجستير في العمارة، عمارة المساحات الخضراء، التخطيط الحضري أو أية مجالات أخرى ذات صلة، من برنامج دولي حسن السمعة.<br></li><li style="margin-bottom: 10px;">خبرة لا تقل عن سنتين في مرحلة ما بعد التخرج في ممارسة التصميم أو العمل في مؤسسة ثقافية معروفة دوليًا، مع اهتمام قوي بالعمارة القائمة على الأبحاث.<br></li><li style="margin-bottom: 10px;">قدرات بحثية ومفاهيمية وتصميمية متينة، تظهر في ملف تصاميم يبرز مهارات المتقدم.<br></li><li style="margin-bottom: 10px;">إجادة البرامج ثلاثية الأبعاد مثل AutoCAD، Revit، Rhino، Adobe CS وَMS Office الخبرة في برمجيات إدارة المشاريع مرغوبة للغاية.<br></li><li style="margin-bottom: 10px;">مهارات اتصال ممتازة وكفاءة في اللغة الإنجليزية. المعرفة الأساسية للغة العربية أمر مرغوب فيه ولكن غير مطلوب بالضرورة. توافر إلمام بلغات أخرى هو ميزة إضافية.<br></li><li style="margin-bottom: 10px;">الفهم الذكي والاهتمام بمعالجة خصوصيات الثقافة والبيئة في الشارقة والإمارات العربية المتحدة ومناطق الجنوب العالمي.<br></li><li style="margin-bottom: 10px;">خبرة في العمل على المشاريع المعقدة والواسعة النطاق في مواعيد نهائية ضيقة، والثقة في العمل في بيئة متطلبة وسريعة الخطى. مع مرونة في ساعات العمل، لا سيما عند اقتراب حلول المواعيد النهائية.<br></li><li style="margin-bottom: 10px;">الاندفاع الذاتي، الذكاء، والتنظيم، مع درجة عالية من الانضباط، والقدرة على قيادة المشاريع وتوجيه الآخرين.<br></li></ul><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">للتقدم بطلب، يرجى إرسال بريد إلكتروني مرفق طيّه ما يلي:</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">رسالة تمهيدية من صفحة واحدة (يسلط الضوء على تجربتك ونقاط القوة لديك مع توضيح أسباب اهتمامك بالحصول على فرصة العمل هذه)، السيرة الذاتية والمهنية، ودعمها بمعلومات اتصال لجهتين من المراجع المهنية أو الأكاديمية التي سبق لك التعامل معها، عينات عن العمل و/ أو روابط لموقع إلكتروني تم العمل عليه فيما سبق أو ملف تصاميم سابقة، وأية مستندات أخرى ذات صلة. يجب دمج كل شيء في ملف PDF واحد لا تزيد سعته على 2 ميغابايت. وإرسال الطلبات، وجميع الاستفسارات عبر عنوان البريد الإلكتروني</span><a href="mailto:careers@sharjaharchitecture.org?subject=%D9%85%D8%B9%D9%85%D8%A7%D8%B1%D9%8A%20%D9%88%D9%85%D8%AF%D9%8A%D8%B1%20%D9%85%D8%B4%D8%A7%D8%B1%D9%8A%D8%B9" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Tahoma; text-align: right; color: rgb(0, 0, 0) !important;">careers@sharjaharchitecture.org</a><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"> مع إدراج مسمّى "معماري ومدير مشاريع" كعنوان للموضوع. سيتم الاتصال فقط بالذين تم اختيارهم لإجراء المقابلات.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 8,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 11:05:50',
            ),
            12 => 
            array (
                'id' => 13,
                'title' => 'Shifting Morphology of Gulf Cities ',
                'title_ar' => 'تشكّل مدن الخليج المتبدل ',
                'slug' => 'shifting-morphology-of-gulf-cities',
                'description' => 'PANEL DISCUSSION',
                'description_ar' => 'جلسة نقاشية',
                'publish_date' => '2018-04-07',
            'content' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Shifting Morphology of Gulf Cities</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">April 7, 2018</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Maraya Art Centre, Sharjah </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Panelists: </span><a href="http://sharjaharchitecture.org/pages/about/contributors/khalid-bin-butti-al-muhairi" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Khalid Bin Butti Al Muhairi</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">, </span><a href="http://sharjaharchitecture.org/pages/about/contributors/hamed-bukhamseen" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Hamed Bukhamseen</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">, </span><a href="http://sharjaharchitecture.org/pages/about/contributors/ali-ismail-karimi" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Ali Ismail Karimi</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">, </span><a href="http://sharjaharchitecture.org/pages/about/contributors/varkki-pallathucheril" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Varkki Pallathucheril</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">, </span><a href="http://sharjaharchitecture.org/pages/about/contributors/rafael-pizaro" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Rafael Pizaro</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">, and </span><a href="http://sharjaharchitecture.org/pages/about/contributors/maysa-sabah" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Maysa Sabah</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Historically concentrated around trading posts and ports along coastal areas, Khaleeji communities shifted from pearl diving and fishing economies to denser cosmopolitan urban centers during the first half of the 20th century. Accelerating population growth and urban development since the 1970s has dramatically reconfigured these cities. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Today, the convergence of various factors including evolving economies, expanding and diversifying expatriate communities, and national housing programs aimed at accommodating successive generations of citizens are progressively shifting those populations inland throughout the Gulf. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Several questions are raised as Khaleeji populations gradually move further away from the coastal settlements in which their social and cultural identities are rooted: How is the shifting morphology of Gulf cities and architecture reflecting these ongoing changes? How do these changes affect social relations amongst the inhabitants of these Gulf cities, both in terms of relations among different cultures and between generations? How can governments and individual communities optimize their response to these changes?</span>

',
            'content_ar' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تشكّل مدن الخليج المتبدل </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">7 أبريل 2018</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">مركز مرايا للفنون، الشارقة </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">المتحدّثون: </span><span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><a href="http://sharjaharchitecture.org/pages/about/contributors/khalid-bin-butti-al-muhairi" style="color: rgb(0, 0, 0) !important;">خالد بن بطي المهيري</a>، <a href="http://sharjaharchitecture.org/pages/about/contributors/hamed-bukhamseen" style="color: rgb(0, 0, 0) !important;">حامد بو خمسين</a>، <a href="http://sharjaharchitecture.org/pages/about/contributors/ali-ismail-karimi" style="color: rgb(0, 0, 0) !important;">علي كريمي</a>، <a href="http://sharjaharchitecture.org/pages/about/contributors/varkki-pallathucheril" style="color: rgb(0, 0, 0) !important;">فاركي بالاثوتشريلز</a>، <a href="http://sharjaharchitecture.org/pages/about/contributors/rafael-pizaro" style="color: rgb(0, 0, 0) !important;">رافاييل بيزارو</a>، <a href="http://sharjaharchitecture.org/pages/about/contributors/maysa-sabah" style="color: rgb(0, 0, 0) !important;">ميساء صباح</a>. </span><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"></span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">على امتداد مناطقها الساحلية، ومع تركز نشاطها تاريخياً حول المراكز التجارية والموانئ، تحول اقتصاد المجتمعات الخليجية من اعتماده على الصيد والغوص بحثاً عن اللؤلؤ ليُنشئ مراكز حضرية عالمية أكثر كثافة خلال النصف الأول من القرن العشرين. وقد أدى تسارع النمو السكاني والتنمية الحضرية منذ سبعينيات القرن إلى إعادة تشكيل ملامح هذه المدن بشكل كبير. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">إن التقاطع الحاصل اليوم بين شتى العوامل، بما فيها الاقتصادات الناشئة، وتزايد وتعددية المجتمعات المغتربة المقيمة في مدن الخليج العربي، وبرامج الإسكان الوطنية التي تهدف إلى احتواء الأجيال المتعاقبة من المواطنين، كان له الأثر الأكبر في تحرّك هؤلاء السكان تدريجياً في جميع أنحاء الخليج. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">مع تحرك السكان الخليجيين بالتدريج بعيداً عن المستوطنات الساحلية التي تتجذر منها هوياتهم الاجتماعية والثقافية ، باتت تطرح عدة تساؤلات: كيف يعكس التحول المورفولوجي لمدن الخليج العربي والعمارة الخليجية هذه التغيرات المستمرة؟ كيف تؤثر هذه التحولات على تواصل قاطني تلك المدن وتفاعلهم مع بعضهم البعض، سواء من ناحية الاحتكاك بين الثقافات المختلفة أو العلاقات بين الأجيال؟ وكيف يمكن للحكومات والمجتمعات الفردية تحسين القدرة الاستيعابية و الاستجابة لهذه التغييرات؟</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '

<p style="text-align: center; "><br></p><p style="text-align: center; "><br></p><p style="text-align: center; "><iframe webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" src="//player.vimeo.com/video/276016725" width="640" height="360" class="note-video-clip"></iframe><br></p>

',
                'page_id' => 15,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 11:34:34',
            ),
            13 => 
            array (
                'id' => 14,
                'title' => 'Sharjah Architecture Triennial Theme Announcement',
                'title_ar' => 'ترينالي الشارقة للعمارة: البيان الترحيبي',
                'slug' => 'sharjah-architecture-triennial-theme-announcement',
                'description' => 'PRESENTATION',
                'description_ar' => 'عرض',
                'publish_date' => '2018-05-25',
            'content' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Architecture Triennial Theme Announcement</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">May 25, 2018</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Circolo Ufficiali Marina Militare, Castello, Venice </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">During the 2018 Venice Biennale, curator </span><a href="http://sharjaharchitecture.org/pages/about/contributors/adrian-lahoud" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Adrian Lahoud</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">announced the theme of the inaugural edition of the Sharjah Architecture Triennial: Rights of Future Generations. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Opening in November 2019, the Triennial will provide the first major platform for dialog on architecture and urbanism focusing on the Middle East, North and East Africa, and South and Southeast Asia. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Lahoud commented: “Rights of Future Generations is an invitation to radically rethink fundamental questions about architecture and its power to create and sustain alternative modes of existence. The last decades have seen a massive expansion in rights, yet this expansion has failed to address long-standing challenges around environmental change and inequality. A focus on rights to health, education, and housing as individual rights has obscured collective rights such as rights of nature and environmental rights. At the same time, the conceptualization of rights as basic standards reduces the diversity of human existence to mere subsistence within a universal minimum." </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">In conversation with Ellis Woodman, Director of the Architecture Foundation, London, Lahoud elaborated that the theme emerged as a radical proposal within indigenous struggles and international law. It aims to fundamentally challenge the way we think about designing societies and environments, with important implications for architecture, urban design, and planning. The inaugural edition will explore this concept within both the Arabic-speaking world and the global south. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Architects, scholars, planners and artists in the region face unique circumstances: fragmented archives, travel restrictions, lack of institutional support. The theme will respond by initiating a body of social-spatial experimentation, a lasting resource and a platform for dialog between an emerging generation of architects from across the Global South and its diaspora.</span>

',
            'content_ar' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">ترينالي الشارقة للعمارة: البيان الترحيبي </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">25 مايو 2018</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">سيركولو أفشالي مرينا مليتاري، كستيلو، البندقية </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><p style="color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;">خلال فعاليات الافتتاح الخاص لبينالي البندقية 2018، أعلن قيّم ترينالي الشارقة للعمارة، <a href="http://sharjaharchitecture.org/pages/about/contributors/adrian-lahoud" style="font-weight: bold; color: rgb(0, 0, 0) !important;"><span style="font-weight: bolder;">أدريان لحود</span></a>، أن "حقوق الأجيال القادمة" سيكون هو عنوان الدورة الأولى للترينالي.</p><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">وستفتتح الدورة في نوفمبر 2019 في إمارة الشارقة، وتستمر لمدة ثلاثة أشهر، لتكون المنصة الرئيسية الأولى للحوار حول العمارة والتحضر في منطقة الشرق الأوسط وشمال وشرق إفريقيا وجنوب وجنوب شرق آسيا. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">وعلّق لحّود قائلاً "إنّ حقوق الأجيال القادمة تدعونا إلى إعادة التفكير جذرياً في أسئلة أساسية في مجال العمارة وقدرتها على ابتكارأنماط وجودية بديلة والحفاظ عليها. لقد شهدت العقود الأخيرة توسعاً حقوقياً هائلاً، ولكن هذا التوسع لم يشمل التحديات البيئية دائمة التغير واللامساواة. لقد تم التركيز على الحقوق الفردية كالصحة والتعليم والسكن، مع تهميش الحقوق العامة كحقوق البيئة والطبيعة. كما أنّ التركيز على الحقوق الأولية فقط من شأنه تقليص التنوع في حياة الإنسان إلى حد الكفاف ضمن الحد الأدنى العالمي". </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">أوضح لحود مدير مؤسسة العمارة في لندن في حوار له مع إليس وودمان، أن موضوع الترينالي يبرز كمقترح جذري وسط تخبط الشعوب الأصلية والقانون الدولي. إذ يهدف الموضوع إلى تحدي الطريقة التي نفكر بها في تصميم المجتمعات والبيئات، مع تداعياتها المهمة على العمارة، التحضر. وهذا المفهوم هو ما ستكتشفه الدورة الافتتاحية الأولى من ترينالي الشارقة للعمارة في كل من العالم العربي ومناطق الجنوب. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يواجه كل من المعماريين والعلماء والمخططين والفنانين في المنطقة عدة عقبات ومنها النقص الكامل أوالجزئي في مخزون الأرشيف، والقيود المفروضة على السفر، وغياب الدعم المؤسسي. ويعتزم الترينالي تخصيص دورته الأولى لإنشاء منصة للحوار بين جيل من المعماريين الناشئين من جميع مناطق الجنوب وشتاتها.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '<div style="text-align: center;"><br></div><div style="text-align: center;"><br></div><div style="text-align: center;"><iframe webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" src="//player.vimeo.com/video/276016725" width="640" height="360" class="note-video-clip"></iframe><br></div>

',
                'page_id' => 15,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 11:35:19',
            ),
            14 => 
            array (
                'id' => 15,
                'title' => 'The Global Climate Ghetto',
                'title_ar' => 'عشوائية المناخ العالمي ',
                'slug' => 'the-global-climate-gheto',
                'description' => 'LECTURE',
                'description_ar' => 'محاضرة',
                'publish_date' => '2018-10-04',
            'content' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">The Global Climate Ghetto</span><span style="color: rgb(33, 37, 41); font-family: Roboto;"> </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">October 4, 2018 </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">V&A Museum, London </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">As a prelude to the inaugural edition of Sharjah Architecture Triennial in November 2019, Curator </span><a href="http://sharjaharchitecture.org/pages/about/contributors/adrian-lahoud" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Adrian Lahoud</a><span style="color: rgb(33, 37, 41); font-family: Roboto;"> organized a lecture entitled ‘The Global Climate Ghetto\' by Ambassador </span><a href="http://sharjaharchitecture.org/pages/about/contributors/lumumba-di-aping" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Lumumba Di-Aping</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">, Chair of the Rights of Future Generations Working Group. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Responding to the catastrophic impact of climate change on our planet with a radical proposal that draws on indigenous struggles and international law, Lahoud’s theme, ‘Rights of Future Generations’ aims to challenge the way we think about designing societies and environments. It questions how inheritance, legacy and the state of the environment are passed from one generation to the next and how present decisions have long-term intergenerational consequences. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Formed with the intention of drafting a Convention on the Rights of Future Generations that will be made public during the opening week of the Triennial, the Working Group will function as an essential link between architecture and questions of the anthropocene, climate justice and global governance, as well as sustainable and green economic development or investment. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">The event was hosted by the V&A Museum and organized by the Royal College of Art and Sharjah Architecture Triennial.</span>

',
            'content_ar' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">عشوائية المناخ العالمي</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">4 أكتوبر 2018</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">متحف V&A لندن </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><p style="color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;">في مستهل الدورة الافتتاحية لترينالي الشارقة للعمارة في نوفمبر 2019، نظمّ القيم <a href="http://sharjaharchitecture.org/pages/about/contributors/adrian-lahoud" style="font-weight: bold; color: rgb(0, 0, 0) !important;"><span style="font-weight: bolder;">أدريان لحود</span></a> محاضرة بعنوان "عشوائية المناخ العالمي" بقلم السفير <a href="http://sharjaharchitecture.org/pages/about/contributors/lumumba-di-aping" style="font-weight: bold; color: rgb(0, 0, 0) !important;"><span style="font-weight: bolder;">لومومبا دي</span></a>، رئيس مجموعة عمل حقوق أجيال القادمة.</p><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">الاستجابة للآثار القاطعة لتغير المناخ على كوكبنا بمقترح جذري يعتمد على نضالات الشعوب الأصلية والقانون الدولي. موضوع لحود "حقوق الأجيال القادمة" يهدف إلى تحدي الطريقة التي نفكر بها في تصميم المجتمعات والبيئة. يشكك في كيفية إرث الميراث وحالة البيئة من جيل إلى جيل وكيف أن القرارات الحالية لها عواقب طويلة الأجل بين الأجيال. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تم تشكيلها بهدف صياغة اتفاقية حول حقوق الأجيال المستقبلية التي سيتم الإعلان عنها خلال الأسبوع الافتتاحي للترينالي، وستعمل مجموعة العمل كحلقة وصل بين العمارة ومسائل الأنثروبوسين والعدالة المناخية والحوكمة العالمية فضلا عن التنمية الاقتصادية المستدامة أو الخضراء أو الاستثمار. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">وقد تم استضافة هذا الحدث من قبل متحف V&A وتم تنظيمه من قبل الكلية الملكية للفن العمارة وترينالي الشارقة للعمارة.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 15,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 11:33:24',
            ),
            15 => 
            array (
                'id' => 16,
                'title' => 'Rights of Future Generations',
                'title_ar' => 'حقوق الأجيال القادمة',
                'slug' => 'rights-of-future-generations',
                'description' => 'LECTURE',
                'description_ar' => 'محاضرة',
                'publish_date' => '2018-12-04',
            'content' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Rights of Future Generations</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Details to be announced soon</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Sharjah </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Marking one year to the opening of the inaugural edition of Sharjah Architecture Triennial and the launch of our Lecture Series, </span><a href="http://sharjaharchitecture.org/pages/about/contributors/adrian-lahoud" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Adrian Lahoud</a><span style="color: rgb(33, 37, 41); font-family: Roboto;"> will introduce his curatorial vision and elaborate on the theme of "Rights of Future Generations." </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Announced as Curator of the 2019 edition in March 2018, Lahoud is Dean of the School of Architecture at the Royal College of Art, London, and an internationally recognized architect, urban designer, and researcher. He has written and lectured extensively on urban spatial forms and large-scale environmental change with a focus on the Arab world and Africa. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Drawing on his previous work on post-colonial nation building projects and environmental research within the context of the Global South, Lahoud\'s theme responds to the catastrophic impact of climate change on our planet with a radical proposal that draws on indigenous struggles and international law. "Rights of Future Generations" aims to challenge the way we think about designing societies and environments and to question how inheritance, legacy, and the state of the environment are passed from one generation to the next. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">The lecture will be followed by a brief conversation with Ambassador </span><a href="http://sharjaharchitecture.org/pages/about/contributors/lumumba-di-aping" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">Lumumba Di-Aping</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">, Chair of the Rights of Future Generations Working Group, a consortium of international experts who will convene over the course of the coming year with the intention of drafting a Convention that will be made public during the opening week of the Triennial.</span>

',
            'content_ar' => '<span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">حقوق الأجيال القادمة </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">سنعلن عن التاريخ والمكان قريباً </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">الشارقة </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><p style="color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;">يصادف في مثل هذه الفترة من العام المقبل الدورة الافتتاحية من برنامج ترينالي الشارقة للعمارة وإطلاق سلسلة محاضراتنا، سيقدم<a href="http://sharjaharchitecture.org/pages/about/contributors/adrian-lahoud" style="font-weight: bold; color: rgb(0, 0, 0) !important;"><span style="font-weight: bolder;">أدريان لحود</span></a> رؤيته المفاهمية للمعرض وسيناقش بالتفصيل موضوع "حقوق الأجيال القادمة".</p><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">أعلن لحود قيّماً على دورة 2019 في مارس 2018، وهو عميد قسم العمارة في الكلية الملكية للفنون في لندن، وهو معماري معروف عالمياً، ومصمم حضري، وباحث. وقد كتب وحاضر بشكل مكثف عن الأشكال المكانية الحضرية والتغيير البيئي الواسع النطاق مع التركيز على العالم العربي وأفريقيا. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">بالاعتماد على بحوثه السابقة حول بناء أمم ما بعد الاستعمار والأبحاث البيئية في سياق مناطق الجنوب العالمي، يستجيب موضوع لحود للأثر الكارثي لتغير المناخ على كوكبنا بمقترح جذري يعتمد على صراعات الشعوب الأصلية والقانون الدولي. يهدف موضوع "حقوق الأجيال القادمة" إلى تحدي الطريقة التي نفكر بها في تصميم المجتمعات والبيئات والتساؤل حول كيفية انتقال الميراث والتراث وحالة البيئة من جيل إلى التالي. </span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><p style="color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;">وستتبع المحاضرة محادثة قصيرة مع السفير <a href="http://sharjaharchitecture.org/pages/about/contributors/lumumba-di-aping" style="font-weight: bold; color: rgb(74, 187, 136) !important;"><span style="font-weight: bolder;">لومومبا دي-أبينغ</span></a>، رئيس مجموعة العمل المعنية بحقوق الأجيال المقبلة، وهي مجموعة من الخبراء الدوليين الذين سيجتمعون على مدار العام القادم بهدف صياغة اتفاقية سيتم نشرها خلال الأسبوع الافتتاحي للترينالي.</p>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 15,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-21 12:36:18',
            ),
            16 => 
            array (
                'id' => 17,
                'title' => 'Sharjah Shorts: Open Call',
                'title_ar' => 'أفلام الشارقة القصيرة: دعوة مفتوحة',
                'slug' => 'sharjah-shorts-open-call',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-21',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Sharjah Architecture Triennial invites young filmmakers to submit short films that explore unique aspects of Sharjah\'s architecture and urbanism.	</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">The project aims to generate a wide range of responses, capturing the participating filmmakers\' distinct perspectives and experiences, and revealing a Sharjah that cannot be represented through conventional architectural media like drawings or photography. Equally, it is one of the Triennial’s community outreach initiatives, engaging upcoming filmmakers and sharing with our audiences, alternative ways of understanding the built environment. The project is open to both professional filmmakers and enthusiasts, including residents of the United Arab Emirates and those who developed an affinity and profound understanding of Sharjah through prolonged sojourns or frequent travel. </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Submissions will be accepted on a rolling basis and reviewed by Sharjah Architecture Triennial. Selected films will receive an honorarium and may be shown by the Triennial at exhibitions, online, or for marketing and promotional purposes. Only selected participants will be contacted, and instructions will be provided on how to develop, finalize, and transfer a digital file. As a first step, the filmmaker is asked to submit a brief biography (100 word), brief description of the concept (150 words), dates of shooting, along with links to the submitted films, sent to </span><a href="mailto:submissions@sharjaharchitecture.org?subject=Sharjah%20Shorts%20Submission" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Roboto; color: rgb(0, 0, 0) !important;">submissions@sharjaharchitecture.org</a><span style="color: rgb(33, 37, 41); font-family: Roboto;">, with "Sharjah Shorts Submission" as the subject line.	</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Requirements</span><span style="color: rgb(33, 37, 41); font-family: Roboto;"> </span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; color: rgb(33, 37, 41); font-family: Roboto; font-size: 16px;"><li style="margin-bottom: 10px;">Films must be exactly 1 minute long. Therefore, filmmakers should ideally focus on one theme (such as a building, road, neighborhood, urban node, landscape, or spatial experience).</li><li style="margin-bottom: 10px;">Film credits must be included at the end, not exceeding 1 second, and written in in a sans serif English and/or Arabic font.</li><li style="margin-bottom: 10px;">The films must be produced at the highest possible resolution (minimum 1080p, that is, Full HD).</li><li style="margin-bottom: 10px;">In case a filmmaker chooses to include dialog or voice-over, subtitles in a sans serif font, in Arabic and/or English, must be placed at the bottom tenth of the screen.</li><li style="margin-bottom: 10px;">Each filmmaker can submit up to five different films for consideration. If these films are posted among other clips on a video channel like YouTube or Vimeo, the participant must send links to individual films.</li></ul><span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Guidelines</span><span style="color: rgb(33, 37, 41); font-family: Roboto;"></span><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; color: rgb(33, 37, 41); font-family: Roboto; font-size: 16px;"><li style="margin-bottom: 10px;">The films are meant to explore and convey the vitality and diversity of Sharjah\'s built environment and landscapes. While the theme and subject matter of each submission is determined by the participant, preference will be given to those films that capture: how Sharjah is inhabited and embraced by its residents; highlight unique aspects of Sharjah’s spaces, civic facilities, and infrastructure, and how these make the urban experience of this emirate distinct from other cities around the world; films that speak to the layers of Sharjah’s history, growth, and mix of population; and films that examine rapidly changing aspects, those worth preserving and conveying through this medium.</li><li style="margin-bottom: 10px;">Submissions should express the filmmaker’s interests and artistic perception of Sharjah. This is not a call for promotional, commercial, or touristic films. Likewise, these films are not expected to hire actors, but consider Sharjah as the main protagonist.</li><li style="margin-bottom: 10px;">Filmmakers are encouraged to capture the authentic sounds, colors, movements, and overall ambience of Sharjah.</li><li style="margin-bottom: 10px;">Filmmakers are urged to explore the quotidian and humbler parts of Sharjah, where patterns of use have already developed and matured.</li><li style="margin-bottom: 10px;">Because we envision featuring these films in exhibitions and on our website, filmmakers should consider how they begin and end, and anticipate how they might loop.</li></ul><span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Roboto;">Rights</span><span style="color: rgb(33, 37, 41); font-family: Roboto;"></span><ul style="margin-top: 10px; margin-bottom: 0px; padding-left: 18px; color: rgb(33, 37, 41); font-family: Roboto; font-size: 16px;"><li style="margin-bottom: 10px;">Participating filmmakers are responsible for crediting and obtaining permissions for any copyrighted material that might appear in their submissions, including text, images, art works, music, or other filmmakers\' work. Participants must also be attentive to the cultural sensitivities of filming people and private or public property, and must obtain written permissions in advance, from all subjects or institutions that might appear in the film. The participant must provide evidence of these permissions along the submitted entry.</li><li style="margin-bottom: 0px;">Once Sharjah Architecture Triennial commissions a film, the participant grants the Triennial the right to display the film in part or in whole, including screen shots or film segments, at exhibitions, online, and any other media and location, and for marketing and promotional purposes, without any restrictions. While the Triennial will credit the participant whenever using the selected film, the participant will only display the film, in any and all formats and media, after obtaining the Triennial’s written permission, and by mentioning "Commissioned by Sharjah Architecture Triennial" and stating the date of the signed agreement.</li></ul>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يدعو ترينالي الشارقة للعمارة صنّاع السينما الشباب إلى تقديم أفلام قصيرة تستكشف جوانب فريدة من العمارة والتحضّر في الشارقة	</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يهدف المشروع إلى استقطاب مجموعة واسعة من المشاركات التي تعكس تجارب صنّاع الأفلام ورؤاهم المختلفة، حول تقديم لمحة عن الشارقة التي لا يمكن تجسيدها عبر وسائط معمارية تقليدية كالرسومات أو التصوير الفوتوغرافي. وتُعد هذه الدعوة إحدى مبادرات التواصل المجتمعي للترينالي، والتي تجذب صنّاع الأفلام المستقبليين وتشارك مع جمهورنا طرقًا بديلة لفهم البيئة العمرانية. إن المشاركة متاحة لصنّاع الأفلام المحترفين والهواة في آنٍ معاً، بمن فيهم سكان الإمارات العربية المتحدة وأولئك الذين طوّروا فهماً تقريبياً عميقاً للشارقة من خلال الرحلات المطوّلة أو السفر المتكرر.	</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">سيتم قبول الطلبات بناءً على مبدأ التصنيف وتتم مراجعتهامن قبل ترينالي الشارقة للعمارة. وسوف تحصل الأفلام المختارة على جوائز عينية وقد يتم عرضها من قبل الترينالي في المعارض، أو في المواقع الإلكترونية، أو لأغراض التسويق والترويج. سيتم التواصل مع المشاركين الذين يتم اختيارهم، وإبلاغهم عن كيفية تطوير الملف الرقمي في صيغته النهائية ونقله. وكخطوة أولى، سوف يُطلب من المخرج تقديم سيرة ذاتية مختصرة (100 كلمة)، وإعطاء وصف مختصر لموضوع الفيلم (150 كلمة) وتحديد مواعيد التصوير، إلى جانب روابط للأفلام المقدمة، وإرسالها إلى البريد الإلكتروني: </span><a href="mailto:submissions@sharjaharchitecture.org?subject=%D8%A3%D9%81%D9%84%D8%A7%D9%85%20%D8%A7%D9%84%D8%B4%D8%A7%D8%B1%D9%82%D8%A9%20%D8%A7%D9%84%D9%82%D8%B5%D9%8A%D8%B1%D8%A9" style="background-color: rgb(255, 255, 255); font-weight: bold; font-family: Tahoma; text-align: right; color: rgb(0, 0, 0) !important;">submissions@sharjaharchitecture.org</a><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">، مع إدراج "أفلام الشارقة القصيرة" عنواناً للبريد.	</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">المتطلبات</span><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"></span><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; padding-right: 18px; color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;"><li style="margin-bottom: 10px;">ألا تزيد مدة الفيلم عن دقيقة واحدة. لذا، ينبغي أن يعرض الفيلم موضوعاً واحداً (مثل مبنى أو طريق أو حي أو تقاطع عمراني أو مسطح طبيعي أو تجربة مكانية).</li><li style="margin-bottom: 10px;">إدراج الأسماء في نهاية الفيلم، وألا تتجاوز مدتها الثانية الواحدة، وتكتب بخط san serif باللغة الإنجليزية وَ/أو العربية.</li><li style="margin-bottom: 10px;">يجب إنتاج الأفلام بأعلى دقة ممكنة (بحد أدنى 1080 بيكسل، أوبدقة عالية HD).</li><li style="margin-bottom: 10px;">في حال تضمن الفيلم على حوار أو صوت، فيجب إدراج الترجمة أو النصوص المراد إضافتها بخط san serif باللغة الإنجليزية و/ أو العربية، وفي العُشر الأسفل من الشاشة.</li><li style="margin-bottom: 10px;">يحقّ لكل مخرج أن يشارك بخمسة أفلام مختلفة. إذا كان قد سبق نشر هذه الأفلام من بين مقاطع أخرى على قناة فيديو مثل YouTube أو Vimeo، فيجب على المشارك إرسال روابط الأفلام منفردة.</li></ul><span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">القواعد الإرشادية</span><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"></span><ul style="margin-top: 10px; margin-bottom: 20px; padding-left: 18px; padding-right: 18px; color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;"><li style="margin-bottom: 10px;">تهدف الأفلام إلى استكشاف حيوية وتنوع البيئتين العمرانية والطبيعية في الشارقة وإبرازها. . وعلى الرغم من أن تحديد سياق الفيلم وموضوعه هو قرار تابع للمشارك، إلا أنه سيتم منح الأفضلية للأفلام التي تعكس كيف أصبحت الشارقة آهلة بالسكان، وكيف يراها سكانها، تسليط الضوء على الجوانب الفريدة من مساحات الشارقة، مثل المرافق المدنية، والبنية التحتية، وكيف ميّزت هذه العناصر التجربة الحضرية لهذه الإمارة عن غيرها من المدن في جميع أنحاء العالم؛ والأفلام التي تتحدث عن تاريخ الشارقة ونموها ومزيجها السكاني؛ والأفلام التي تدرس الجوانب العمرانية سريعة التغير، تلك التي تستحق الحفاظ عليها ونقلها من خلال هذه الوسيلة.</li><li style="margin-bottom: 10px;">يجب أن تعبر المشاركات عن اهتمامات صانعي الأفلام وإدراكهم الفني للشارقة. إنها ليست دعوة للأفلام الترويجية أو التجارية أو السياحية. وبالمثل، لا يُتوقع من هذه الأفلام توظيف الممثلين، بل يجب أن تعتبر الشارقة البطل الرئيس فيها.</li><li style="margin-bottom: 10px;">يمكن لصانعي الأفلام التقاط الأصوات والألوان والحركات والجو العام في الشارقة.</li><li style="margin-bottom: 10px;">تحفيزصانعي الأفلام على استكشاف الأماكن البسيطة والمتواضعة في الشارقة، حيث تطورت ونضجت أنماط استخدامها.</li><li style="margin-bottom: 10px;">نظرًا لوجود إمكانية عرض هذه الأفلام في المعارض وعلى الموقع الإلكتروني، يتحتّم على المشاركين التفكير في كيفية البدء بالأفلام واختتامها، بحيث تكون ملائمة للعرض المتكرر.</li></ul><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="font-weight: bolder; color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">الحقوق</span><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"></span><ul style="margin-top: 10px; margin-bottom: 0px; padding-left: 18px; padding-right: 18px; color: rgb(33, 37, 41); font-family: Tahoma; font-size: 16px; text-align: right;"><li style="margin-bottom: 10px;">يتحمل صنّاع الأفلام المشاركون المسؤولية عن الحصول على أذونات وتصاريح استخدام أية مواد محمية بحقوق النشر قد تظهر في مشاركاتهم، بما في ذلك النصوص أو الصور أو الأعمال الفنية أو الموسيقى أو أية أعمال فيلمية لأشخاص آخرين. يجب على المشاركين مراعاة الحساسيات الثقافية أثناء تصوير الأشخاص والملكيّات الخاصة أو العامة، ويجب عليهم الحصول على تصاريح كتابية مسبقاً، من جميع المواد أو المؤسسات التي قد تظهر في الفيلم. يجب على المشارك تقديم هذه التصاريح مرفقة مع طلب المشاركة.</li><li style="margin-bottom: 0px;">عند تفويض ترينالي الشارقة للعمارة إنتاج فيلم بعينه، فإن المشارك يمنح الترينالي الحق في عرض الفيلم بشكل كامل أو بشكل مجزوء، بما في ذلك لقطات تصويرية أو أية أجزاء من الفيلم، سواء في المعارض، أو على الإنترنت، أو عبر أي وسيلة إعلام أخرى، إضافة إلى استخدامه لأغراض التسويقية والترويجية، بلا أية قيود. سيتم ذكر اسم المشارك بالفيلم عند كل مرة يُعرض فيها، وبالمقابل، يجب على المشارك الحصول على إذن خطي من إدارة الترينالي لغرض عرضه في أي وسيلة، مع ذكر عبارة: "بتكليف من ترينالي الشارقة للعمارة" وتاريخ الاتفاقية الموقَّعة.</li></ul>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 20,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:00:23',
            ),
            17 => 
            array (
                'id' => 18,
                'title' => 'AMIN ALSADEN APPOINTED AS THE DIRECTOR OF SHARJAH ARCHITECTURE TRIENNIAL',
                'title_ar' => 'تعيين أمين السادن مديراً لترينالي الشارقة للعمارة',
                'slug' => 'amin-alsaden-appointed-as-the-director-of-sharjah-architecture-triennial',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-22',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 22,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:23:02',
            ),
            18 => 
            array (
                'id' => 19,
                'title' => 'RIGHTS OF FUTURE GENERATIONS ANNOUNCED AS THE THEME OF THE FIRST SHARJAH ARCHITECTURE TRIENNIAL',
                'title_ar' => 'حقوق الأجيال القادمة موضوع النسخة الأولى من ترينالي الشارقة للعمارة',
                'slug' => 'rights-of-future-generations-announced-as-the-theme-of-the-first-sharjah-architecture-triennial',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-22',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 22,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:23:08',
            ),
            19 => 
            array (
                'id' => 20,
                'title' => 'ADRIAN LAHOUD APPOINTED CURATOR OF THE INAUGURAL SHARJAH ARCHITECTURE TRIENNIAL',
                'title_ar' => 'أدريان لحّود قيّماً للنسخة الأولى من ترينالي الشارقة للعمارة',
                'slug' => 'adrian-lahoud-appointed-curator-of-the-inaugural-sharjah-architecture-triennial',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-22',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 22,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:23:15',
            ),
            20 => 
            array (
                'id' => 21,
                'title' => 'SHARJAH ARCHITECTURE TRIENNIAL: THE FIRST INTERNATIONAL PLATFORM ON ARCHITECTURE IN THE MENASA REGION',
                'title_ar' => 'ترينالي الشارقة للعمارة هي المنصة المعمارية الدولية الأولى في منطقة الشرق الأوسط وشمال إفريقيا وجنوب آسيا',
                'slug' => 'sharjah-architecture-triennial-the-first-international-platform-on-architecture-in-the-menasa-region',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-11-22',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 22,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:23:23',
            ),
            21 => 
            array (
                'id' => 22,
                'title' => ' ',
                'title_ar' => 'أمين السادن مديراً لترينالي الشارقة للعمارة',
                'slug' => '-1',
                'description' => '',
                'description_ar' => 'الخليج',
                'publish_date' => '2018-07-03',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:09:51',
            ),
            22 => 
            array (
                'id' => 23,
                'title' => 'AMIN ALSADEN APPOINTED DIRECTOR OF SHARJAH ARCHITECTURE TRIENNIAL',
                'title_ar' => ' ',
                'slug' => '',
                'description' => 'Art Forum',
                'description_ar' => '',
                'publish_date' => '2018-07-02',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:10:22',
            ),
            23 => 
            array (
                'id' => 24,
                'title' => 'Sharjah Architecture Triennial to Open as First Major Platform on Middle Eastern Architecture',
                'title_ar' => ' ',
                'slug' => '',
                'description' => 'Arch Daily',
                'description_ar' => '',
                'publish_date' => '2018-06-09',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:10:33',
            ),
            24 => 
            array (
                'id' => 25,
                'title' => 'Sharjah Architecture Triennial will seek to overturn orientalist cliches',
                'title_ar' => ' ',
                'slug' => '',
                'description' => 'Dezeen',
                'description_ar' => '',
                'publish_date' => '2018-06-09',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:10:46',
            ),
            25 => 
            array (
                'id' => 26,
                'title' => 'Sharjah Architecture Triennial',
                'title_ar' => ' ',
                'slug' => '',
                'description' => 'MiddleeastArchitect',
                'description_ar' => '',
                'publish_date' => '2018-06-03',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:10:59',
            ),
            26 => 
            array (
                'id' => 27,
                'title' => 'Theme announced for the inaugural 2019 Sharjah Architecture Triennale',
                'title_ar' => ' ',
                'slug' => '',
                'description' => 'Wallpaper',
                'description_ar' => '',
                'publish_date' => '2018-05-25',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:11:16',
            ),
            27 => 
            array (
                'id' => 28,
                'title' => ' ',
                'title_ar' => 'أدريان لحّود قيّماً للنسخة الأولى من ترينالي الشارقة للعمارة',
                'slug' => '-2',
                'description' => '',
                'description_ar' => 'الحياة',
                'publish_date' => '2018-05-10',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:11:41',
            ),
            28 => 
            array (
                'id' => 29,
                'title' => 'What the New Sharjah Architecture Triennial Means for the Middle East',
                'title_ar' => ' ',
                'slug' => '',
                'description' => 'Architectural Digest',
                'description_ar' => '',
                'publish_date' => '2018-05-02',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:11:52',
            ),
            29 => 
            array (
                'id' => 30,
                'title' => ' ',
                'title_ar' => 'ترينالي الشارقة للعمارة» يبحث التغيرات في مدن الخليج العربي',
                'slug' => '-3',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '2018-04-04',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:12:23',
            ),
            30 => 
            array (
                'id' => 31,
                'title' => ' ',
                'title_ar' => ' الشارقة تطلق ترينالي للعمارة',
                'slug' => '-4',
                'description' => '',
                'description_ar' => 'الخليج',
                'publish_date' => '2018-05-04',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:12:43',
            ),
            31 => 
            array (
                'id' => 32,
                'title' => 'Sharjah Architecture Triennial Hosts First Public Programme',
                'title_ar' => ' ',
                'slug' => '',
                'description' => 'Harpers Bazaar Arabia',
                'description_ar' => '',
                'publish_date' => '2018-04-04',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:13:07',
            ),
            32 => 
            array (
                'id' => 33,
                'title' => 'First Sharjah Architecture Triennial set for 2019',
                'title_ar' => ' ',
                'slug' => '',
                'description' => 'Hospitality Interiors',
                'description_ar' => '',
                'publish_date' => '2018-04-03',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:13:26',
            ),
            33 => 
            array (
                'id' => 34,
                'title' => ' ',
                'title_ar' => 'سلطان  القاسمي يصدر مرسوماً اميريا بإنشاء وتنظيم «ترينالي» الشارقة للعمارة',
                'slug' => '-5',
                'description' => '',
                'description_ar' => 'جريدة الوطن',
                'publish_date' => '2018-03-14',
                'content' => '',
                'content_ar' => '',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 23,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-22 12:13:52',
            ),
            34 => 
            array (
                'id' => 35,
                'title' => 'Khalid Al Ali ',
                'title_ar' => 'خالد العلي',
                'slug' => 'khalid-al-ali',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">His Excellency Khalid Al Ali, the Secretary General of the Sharjah Urban Planning Council (SUPC), is a nationally and internationally recognized leader in Urban Planning and Engineering. Since assuming the management of the SUPC as Secretary General in 2014, Al Ali has overseen the inception and growth of the organization as a key player in the positive development of Sharjah. Before working at the SUPC, Al Ali began his career at the Directorate of Town Planning and Survey as an Architectural Engineer and progressed on to become the Head of the Planning Studies office. In addition to his Master\'s Degree in Urban Planning from the American University of Sharjah and a Bachelor\'s Degree in Architectural Engineering from UAE University in Al Ain, Al Ali has completed a variety of training course workshops including the Urban Planning Workshop with the United Nations Economic and Social Commission for Western Asia. He is a member of the UAE Society of Engineers, where he serves as the Chairman of the Urban Planning Committee.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">سعادة خالد العلي، الأمين العام لمجلس الشارقة للتخطيط العمراني (SUPC)، رائد معترف به محلياً ودولياً في مجال التخطيط الحضري والهندسة. منذ توليه إدارة مجلس الشارقة للتخطيط العمراني كأمين عام في عام 2014، أشرف العلي على انطلاق ونمو المؤسسة كفاعلٍ رئيس في التطور الإيجابي في الشارقة. قبل العمل في المجلس، بدأ العمل في دائرة التخطيط والمساحة كمعماري ثم أصبح رئيس مكتب دراسات التخطيط. بالإضافة إلى حصوله على درجة الماجستير في التخطيط الحضري من الجامعة الأميركية في الشارقة ودرجة البكالوريوس في العمارة من جامعة الإمارات في العين، أكمل العلي مجموعة متنوعة من ورش العمل التدريبية بما في ذلك ورشة التخطيط الحضري مع الأمم المتحدة، واللجنة الاقتصادية والاجتماعية لغربي آسيا. وهو عضو في جمعية المهندسين في الإمارات العربية المتحدة، ويشغل منصب رئيس لجنة التخطيط العمراني.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-21 10:48:22',
            ),
            35 => 
            array (
                'id' => 36,
                'title' => 'Amin Alsaden',
                'title_ar' => 'أمين السادن',
                'slug' => 'amin-alsaden',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Amin Alsaden is the Director of Sharjah Architecture Triennial, contributing to the organization\'s growth, sustainability and long-term mission, as well as launching one of the Triennial\'s core initiatives, a research program. He also oversees programming and related activities, including outreach and external relations with local, regional, and international partners. An Architect and Scholar whose work focuses on the global exchanges of ideas and expertise across cultural boundaries, Alsaden\'s interests include modern art and architecture, especially in the Muslim and Arab worlds; questions of globalism and universalism in art and architectural history and theory; politics and aesthetics; cultural production in conflict zones; sociopolitical, epistemological, and disciplinary agency of cultural institutions; and monumentality in modern and contemporary art and architecture. His current research investigates a crucible moment in post-WWII Baghdad, when the city became a locus of unprecedented encounters, contributing to the profound transformation of art and architecture globally all the while engendering unique local movements. Alsaden holds a PhD and MA from Harvard University, MArch from Princeton University and BArch from the American University of Sharjah. He has practiced as a designer at various firms such as OMA and MVRDV in the Netherlands.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">أمين السادن مدير ترينالي الشارقة للعمارة، حيث يساهم في نمو المنظمة واستدامتها ومهمتها على المدى الطويل، بالإضافة إلى إطلاق إحدى المبادرات الجوهرية للترينالي، ألا وهو البرنامج البحثي. كما يشرف السادن على البرمجة والأنشطة المختلفة، بما في ذلك التواصل والعلاقات الخارجية مع الشركاء المحليين والإقليميين والدوليين. وهو معماري وباحث يركز من خلال عمله على التبادل العالمي للأفكار والخبرات عبر الحدود الثقافية، وتشمل اهتماماته الفن الحديث والعمارة، تحديدًا في العالمين العربي والإسلامي، والمسائل الكونية والعالمية في تاريخ ونظريات الفن والعمارة، والسياسة وعلم الجمال، والإنتاج الثقافي في مناطق النزاع، والقوة الاجتماعية والمعرفية والتأديبية للمؤسسات الثقافية وأثرها في الفن والعمارة الحديثة والمعاصرة. يركز بحثه الحالي على اللحظة الحاسمة في بغداد في فترة ما بعد الحرب العالمية الثانية، عندما أصبحت المدينة مركزًا لمواجهات غير مسبوقة، مما ساهم في التحول العميق للفن والعمارة على مستوى العالم، ومما أوجد حركات محلية فريدة. السادن حاصل على درجتي الدكتوراه والماجستير من جامعة هارفارد، وماجستير من جامعة برينستون، وبكالوريوس من الجامعة الأمريكية في الشارقة. وقد مارس عمله كمصمم في العديد من الشركات منها OMA وَMVRDV في هولندا.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:11',
                'updated_at' => '2018-11-21 10:48:49',
            ),
            36 => 
            array (
                'id' => 37,
                'title' => 'Abdellah El-Soussi',
                'title_ar' => 'عبد الله السوسي',
                'slug' => 'abdellah-el-soussi',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Abdellah El-Soussi is a recent graduate of the American University of Sharjah with a bachelor\'s degree in Architecture. He has contributed to Sharjah Architecture Triennial by interning at the organization, assisting with architectural research. Abdellah has previously interned at several firms such as Adnan Saffarini, Callison Rtkl, and Rmjm. He has also participated in workshops with EMBT architects in Barcelona and Studio X Amman in collaboration with Bartlett University in Amman.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">عبد الله السوسي خريج حديث من الجامعة الأميركية في الشارقة حاصل على درجة البكالوريوس في العمارة. ساهم في ترينالي الشارقة للعمارة كمتدرب في مجال البحث المعماري. شارك عبد الله مؤخراً في شركات عدة منها مكتب عدنان سفاريني، شركة Callison Rtkl و Rmjm. كما شارك أيضاً في ورش مع معماريي EMBT في برشلونة وَStudio X في عمّان بالتعاون مع جامعة Bartlett في عمّان.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:49:26',
            ),
            37 => 
            array (
                'id' => 38,
                'title' => 'Ali Ismail Karimi ',
                'title_ar' => 'علي إسماعيل كريمي',
                'slug' => 'ali-ismail-karimi',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Ali Ismail Karimi is a Bahraini architect whose work explores social housing, public space, and the urban landscape of the GCC countries. Ali received his Master in Architecture from the Harvard Graduate School of Design (M.Arch I \'16). Ali is, along with Hamed Bukhamseen, the co-founder of Civil Architecture, an architecture office based in Manama and Kuwait City. Together they curated the Kuwait Pavilion titled "Between East and West: A Gulf" at the 2016 Venice Biennale. Ali previously worked in Brussels with OFFICE KGDVS, in New York with SO-IL, and in Santiago, Chile with Elemental. Karimi has conducted research on government-built housing in the GCC with the Affordable Housing Institute in Boston as a Joint Center for Housing Studies Fellow; and in Havana with a grant from the David Rockefeller Center for Latin American Studies. His work and writings have been published in various academic journals including San Rocco, CLOG, and he teaches architecture design studio at the University of Bahrain.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">علي إسماعيل كريمي، معماري بحريني تتركز اهتماماته على مشاريع الإسكان الاجتماعية، والمساحات العامة، والمساحات الحضرية الخضراء في دول الخليج. حاصل على درجة الماجستير في العمارة من كلية الدراسات العليا للتصميم في جامعة هارفارد. ويدير علي، جنباً إلى جنب مع زميله حامد بوخمسين مكتب "العمارة المدنية" الخاص بهما بين المنامة ومدينة الكويت. كما قاما معاً بتنسيق جناح دولة الكويت والذي حمل شعار"بين الشرق والغرب: خليج" وكان ذلك في معرض العمارة الدولي الخامس عشر في بينالي البندقية. عمل كريمي سابقاً في بروكسل لصالح OFFICE KGDVS، وفي نيويورك مع SO-IL ، وفي سانتياغو، تشيلي مع Elemental. أجرى كريمي أبحاثاً على مشاريع الإسكان الحكومية في دول الخليج العربية بالتعاون مع معهد الإسكان الميسّر في بوسطن، حيث كان يشغل منصب زميل للمركز المشترك لدراسات الإسكان، وفي هافانا بعد حصوله على منحة مركز ديفيد روكفيلر للدراسات الأمريكية اللاتينية. نُشرت أعماله في مجلات أكاديمية مثل San Rocco وَ CLOG. ويدرّس كريمي حالياً في مجال استديوهات تصميم العمارة في جامعة البحرين.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:49:57',
            ),
            38 => 
            array (
                'id' => 39,
                'title' => 'Khalid Bin Butti Al Muhairi',
                'title_ar' => 'خالد بن بطي المهيري',
                'slug' => 'khalid-bin-butti-al-muhairi',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">HE Khalid Bin Butti Al Muhairi is the Chairman of the Directorate of Town Planning and Survey (DTPS) and has been a member of the Executive Council of the Emirate of Sharjah since January 2017. He boasts extensive experience in the field of housing, having served as Vice Chairman of the Housing Committee in the emirate and member of the Sheikh Zayed Housing Programme from 2002 to 2010. He was the Director of DTPS from 2006 to 2017, where he supervised the management of GIS Center and managed the first program to qualify citizens in the field of surveying in coordination with the American University in Sharjah. In addition, he chaired the task forces in charge of developing strategies, which include: Sharjah Housing Master Plan, Service &amp; Infrastructure Provision Plan, and the Central Region Comprehensive Development Plan. He holds an MSc in Urban Planning from the American University of Sharjah and has participated in several conferences inside and outside the country. Since 2017, he has been keen to develop human capital and support new, innovative ideas including the modernization of public services by achieving the digital transformation of services. Having adopted an open-door policy, the Chairman is known for meeting DTPS visitors on a weekly basis to listen to their observations. He and his team have significantly contributed to the development of an ambitious strategic plan to ensure the comprehensive development of Sharjah up to the year 2021 and to achieve a sustainable urban environment through the application of the best international practices and collaboration with all departments concerned in order.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">سعادة خالد بن بطي المهيري، رئيس دائرة التخطيط والمساحة في الشارقة. شغل عضوية المجلس التنفيذي لإمارة الشارقة منذ يناير من عام 2017. وهو يتمتع بخبرة واسعة في مجال الإسكان، بعد أن عمل نائباً لرئيس لجنة الإسكان في الإمارة وعضواً في برنامج الشيخ زايد للإسكان بين العامين 2002 و2010. شغل منصب رئيس دائرة التخطيط والمساحة في الشارقة بين العامين 2006 و2017، حيث أشرف على إدارة مركز GIS وقاد البرنامج الأول لتأهيل المواطنين في مجال المسح البياني بالتنسيق مع الجامعة الأميركية في الشارقة. بالإضافة إلى ذلك، ترأس فرق العمل المسؤولة عن تطوير استراتيجيات شملت الخطة الرئيسية للإسكان في الشارقة، وخطة تقديم الخدمات والبنية التحتية وخطة التنمية الشاملة للمنطقة الوسطى. حاصل على درجة الماجستير في التخطيط الحضري من الجامعة الأميركية في الشارقة وشارك في العديد من المؤتمرات داخل الإمارات وخارجها. منذ عام 2017، حرص على تطوير رأس المال البشري ودعم الأفكار الجديدة والمبتكرة بما في ذلك تحديث الخدمات العامة إلى النظام الرقمي. وعملاً بسياسة الباب المفتوح، يُعرف عن رئيس دائرة التخطيط والمساحة في الشارقة اجتماعه شخصياً وبشكل أسبوعي بزوار الدائرة للاستماع إلى ملاحظاتهم. ساهم مع فريقه بشكل كبير في تبني وتطوير خطة استراتيجية تنموية شاملة خاصة بالشارقة تمتد حتى عام 2021 بهدف تحقيق بيئة حضرية مستدامة من خلال تطبيق أفضل الممارسات الدولية والتعاون تراتبياً مع كافة الإدارات المعنية بهذا المجال.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:50:17',
            ),
            39 => 
            array (
                'id' => 40,
                'title' => 'Hamed Bukhamseen ',
                'title_ar' => 'حامد بوخمسين',
                'slug' => 'hamed-bukhamseen',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Hamed Bukhamseen is an architect and educator based in Kuwait City, Kuwait. He is a graduate of the Rhode Island School of Design and Harvard University - Graduate School of Design, earning degrees in architecture, the fine arts and urban design. He has practiced locally and internationally within the US, Germany and Japan, where he was involved in various curatorial and design projects. Aimed primarily at the merger of interests in art and architecture across the urban realm, his work has been published in numerous media outlets and has been exhibited in Cambridge, Rome, Venice, and Dublin. Alongside Ali Ismail Karimi, he is a co-founder of Civil Architecture, a practice based between Kuwait and Bahrain. Together they have overseen Kuwait\'s participation in the 15th International Architecture Exhibition – La Biennale di Venezia, with a pavilion titled "Between East &amp; West: A Gulf". He is currently a faculty member at the Kuwait University – College of Architecture where he teaches design studios and a seminar on Kuwait City\'s urban fabric.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">حامد بوخمسين، معماري وأستاذ جامعي مقيم في الكويت. تخرج من كلية التصميم في جامعة رود آيلاند وجامعة هارفارد، كلية الدراسات العليا للتصميم وحاصل على شهادات في العمارة، والفنون الجميلة والتصميم الحضري. وقد عمل محلياً ودولياً في الولايات المتحدة وألمانيا واليابان، حيث شارك في مشاريع تصميمية مختلفة تهدف في المقام الأول إلى دمج الفن بالعمارة في المجال الحضري العمراني، وقد نشرت أعماله في العديد من المنافذ الإعلامية المرموقة، وعرض أعماله في كامبريدج وروما والبندقية ودبلن. وشارك زميله البحريني علي اسماعيل كريمي في تأسيس مكتب "العمارة المدنية" القائم بين الكويت والبحرين. كما أشرف كلاهما على مشاركة جناح دولة الكويت في معرض العمارة الدولي الخامس عشر في بينالي البندقية، والذي حمل شعار: "بين الشرق والغرب: خليج". ويشغل بوخمسين حاليًا عضوية هيئة التدريس في كلية العمارة في جامعة الكويت، ويدرّس في مجال استديوهات التصميم ويقيم ندوات حول النسيج الحضري لمدينة الكويت.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:50:35',
            ),
            40 => 
            array (
                'id' => 41,
                'title' => 'Varkki Pallathucheril',
                'title_ar' => 'فاركي بالاثوتشيريل ',
                'slug' => 'varkki-pallathucheril',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Varkki Pallathucheril is Professor and Dean of the College of Architecture, Art and Design at the American University of Sharjah (AUS), which includes degree programs in architecture and urban planning. Educated as an architect and urban planner, Dr Pallathucheril\'s teaching and research interests lie in urban design and the use of information technologies in urban planning and design. With his students at AUS, he has looked at the morphological and social evolution of residential neighborhoods in Sharjah and factors that drive the quality of life in them. While at the University of Illinois at Urbana-Champaign, he was part of a research group that developed and applied a dynamic-spatial model of urban evolution and its consequences as well as integrating intelligence from these analyses into real-world urban planning processes.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">فاركي بالاثوتشيريل، أستاذ وعميد كلية العمارة والفنون والتصميم في الجامعة الأميركية في الشارقة، والتي تقدم برامج دراسية في درجة في العمارة والتخطيط الحضري. خلفيته التعليمية كمعماري ومخطط حضري، مكّنته من التدريس والاهتمام في التصميم الحضري واستخدام تقنيات المعلومات في التخطيط الحضري والتصميم. رصد بالاثوتشيريل بمرافقة طلابه في الجامعة الأميركية، التطور المورفولوجي والاجتماعي للأحياء السكنية في الشارقة والعوامل التي تحدد نوعية الحياة فيها. كذلك شارك ضمن مجموعة من الباحثين في جامعة إلينوي في أوربانا-شامبين، في العمل على تطوير نموذج ديناميكي مكانيّ حول التطور العمراني وتداعياته ودمج هذه الأبحاث الذكية في عمليات التخطيط الحضري القابلة للتطبيق الفعلي.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:50:51',
            ),
            41 => 
            array (
                'id' => 42,
                'title' => 'Rafael Pizaro',
                'title_ar' => 'رافاييل بيزارو',
                'slug' => 'rafael-pizaro',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Rafael Pizaro is an Associate Professor at the Department of Architecture in the College of Architecture, Art and Design of the American University of Sharjah. Pizarro has previously taught urban planning, urban design and architecture for 14 years at the Technical University of Berlin (Germany), at the University of Sydney (Australia) and at Texas Southern University (USA). He teaches and conducts research on physical urban planning and ecological urbanism with special emphasis on green neighborhood design. He is the author or co-author of more than 25 peer-reviewed journal articles, book chapters and two books. He has been an urban planner for the City of Phoenix (Arizona) and a practicing architect in Bogota, Colombia. He received his PhD in Urban Planning, University of Southern California, Los Angeles, USA.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">رافاييل بيزارو، أستاذ معاون في قسم العمارة في كلية العمارة والفنون والتصميم في الجامعة الأمريكية في الشارقة. درس بيزارو التخطيط والتصميم الحضري والعمارة على مدى 14 عاماً في جامعة برلين التقنية (ألمانيا)، وفي جامعة سيدني (أستراليا) وفي جامعة تكساس الجنوبية (الولايات المتحدة الأمريكية). ويقوم حالياً بتدريس وإجراء الأبحاث حول التخطيط الحضري والتحضر البيئي مع التركيز بشكل خاص على تصميم الأحياء الخضراء. ألّف وشارك في تأليف أكثر من 25 مقالة في المجلات العلمية، وفي فصول لكتب متخصصة، إضافة إلى المشاركة في كتابين اثنين في هذا المجال. عمل بيزارو مخططاً حضرياً لمدينة فينيكس (أريزونا)، بالإضافة إلى أنه قد مارس العمارة في بوغوتا، كولومبيا. وهو حاصل على درجة الدكتوراه في التخطيط الحضري من جامعة جنوب كاليفورنيا، لوس أنجلوس، الولايات المتحدة الأميركية.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:51:45',
            ),
            42 => 
            array (
                'id' => 43,
                'title' => 'Maysa Sabah',
                'title_ar' => 'ميساء صباح',
                'slug' => 'maysa-sabah',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Maysa Sabah is an Urban Planner/Housing Specialist. She is also an Advisor to the Affordable Housing Institute (AHI). Previously she was AHI’s Managing Director for the Arab World. Under her leadership, AHI worked on a variety of housing related projects in the United Arab Emirates, Saudi Arabia, Kuwait, Qatar, Lebanon, Morocco and Algeria. She has experience in the US where she worked for NYC\'s Phipps Houses Group, a large nonprofit housing developer; Mass Housing, a state housing bank; and Fenway CDC, a community based affordable housing builder. Maysa has a Bachelor of Architecture degree from the American University of Beirut, a Masters degree in City Planning from the Massachusetts Institute of Technology and an MPhil degree in Real Estate Finance from the University of Cambridge.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">ميساء صباح، متخصصة في التخطيط الحضري/الإسكاني. وهي أيضاً مستشارة لمعهد الإسكان الميَسر (AHI)، حيث شغلت سابقاً منصب المدير الإداري للمعهد في العالم العربي. وقد عمل معهد AHI تحت إدارتها على مجموعة متنوعة من المشاريع المتعلقة بالإسكان في الإمارات العربية المتحدة والمملكة العربية السعودية والكويت وقطر ولبنان والمغرب والجزائر. ولديها خبرة في الولايات المتحدة حيث عملت مع مجموعة Phipps Houses في نيويورك، وهي شركة غير ربحية لتطوير الإسكان، وMass Housing بنك الإسكان الشامل، وFenway CDC، وهي مؤسسة تعنى بتوفير السكن مَيسر الدفع. حصلت صباح على درجة البكالوريوس في العمارة من الجامعة الأميركية في بيروت، ودرجة الماجستير في تخطيط المدن من معهد ماساتشوستس للتكنولوجيا، ودرجة الماجستير في التمويل العقاري من جامعة كامبريدج.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:52:04',
            ),
            43 => 
            array (
                'id' => 44,
                'title' => 'Anum Laghari',
                'title_ar' => 'آنوم لاغاري',
                'slug' => 'anum-laghari',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Anum Laghari is a Communications and Programs Assistant at Sharjah Architecture Triennial. She graduated with a Bachelor\'s degree in Architectural Engineering from United Arab Emirates University. She has previously worked at both contracting and consulting firms in the UAE and has participated in several research projects in the field of research, with a particular focus on sustainability and social housing. She interned for the National Pavilion UAE at the 15th International Architecture Exhibition of Venice Biennial in Italy and has completed stints at both Art Dubai and Dubai Design Week in the area of programming and community outreach.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">آنوم لاغاري تدعم حالياً البرمجة والاتصالات في ترينالي الشارقة للعمارة، وقد تخرجت بدرجة البكالوريوس في العمارة من جامعة الإمارات العربية المتحدة. عملت سابقاً في شركات للمقاولات والاستشارات في الإمارات العربية المتحدة، وشاركت في العديد من المشاريع البحثية في مجال الأبحاث، مع التركيز بشكل خاص على الاستدامة والإسكان الاجتماعي. كما شاركت في الجناح الوطني الإماراتي في معرض العمارة الدولي الخامس عشر لبينالي البندقية في إيطاليا، وعملت في كل من آرت دبي وأسبوع دبي للتصميم في مجال البرمجة والتواصل المجتمعي.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:52:28',
            ),
            44 => 
            array (
                'id' => 45,
                'title' => 'Adrian Lahoud',
                'title_ar' => 'أدريان لحود',
                'slug' => 'adrian-lahoud',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Adrian Lahoud is the Curator of the first edition of Sharjah Architecture Triennial that will launch in November 2019. Dean of the School of Architecture at the Royal College of Art, London, since 2015, Lahoud is an internationally recognized Architect, Urban Designer, and Researcher who has written and lectured extensively on urban spatial forms and large-scale environmental change with a focus on the Arab world and Africa. Drawing on nation building projects in the post-colonial period and the mobilization of climate research by the Global South, Lahoud\'s PhD titled The Problem of Scale: The City, the Territory, the Planetary sets out a theory of scale drawn from architectural practice in the context of emancipatory struggles. Further recent exhibits include: The Shape of the Eclipse at Let\'s Talk about the Weather; Art and Ecology in a Time of Crisis, Sursock Museum Beirut; Secular Cosmologies in After Belonging, Triennial of Architecture Oslo. Recent lectures include: Architecture and the Social Imagination at City Debates, American University of Beirut; Fallen Cities: Architecture and Reconstruction at The Arab City; Architecture and Representation, Columbia University, and Floating Bodies at Conflict Shorelines Princeton University. Recent publications include: The Mediterranean: A New Imaginary in New Geographies, Harvard University Press; The Bodele Declaration in Grain, Vapour, Ray: Textures of the Anthropocene MIT Press; Nomos and Cosmos in Supercommunity, MIT Press.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">أدريان لحود، القيّم على الدورة الأولى من ترينالي الشارقة للعمارة المزمع انطلاقه في نوفمبر 2019. عميد كلية العمارة في الكلية الملكية للفنون في لندن منذ العام 2015، وهو معماري معروف عالمياً، ومصمم حضري، وباحث قام بالتأليف والتدريس في مجال الأشكال المكانية الحضرية والتغير البيئي الحاصل على نطاق واسع مع التركيز على منطقتي العالم العربي وأفريقيا. بالاستناد إلى مشاريع بناء الأمة في فترة ما بعد الاستعمار والبحوث المناخية التي عقدت في الجنوب العالمي، عالجت رسالة الدكتوراه الخاصة بلحّود "إشكالية الحجم: المدينة، الإقليم، الكوكب" نظرية للمقاييس مستمدة من الممارسة المعمارية في سياق الصراعات التحررية. من أعماله الأخيرة: "شكل الكسوف" في معرض "دعونا نتحدث عن الطقس: الفن والإيكولوجيا في زمن الأزمة"، متحف سرسق في بيروت، وعمل "كوزمولوجيا علمانية فيما بعد الانتماء" في ترينالي أوسلو للعمارة. كما تشمل محاضراته الأخيرة: "العمارة والخيال الاجتماعي في مناظرات المدينة" في الجامعة الأميركية في بيروت، "مدن متساقطة: العمارة والتعمير" في مؤتمر المدينة العربية: العمارة والتمثيل في جامعة كولومبيا وَ"أجسام طافية" في معرض "سواحل النزاع" في جامعة برينستون. نُشر له مؤخراً: "البحر الأبيض المتوسط: وهم جديد في جغرافيات جديدة"، مطبعة جامعة هارفارد، "إعلان بودلي في الحبوب، والبخار، والشعاع: قوام الأنثروبوسين"، مطبعة معهد ماساشوستس للتكنولوجيا، "القانون والكون في المجتمع العالمي الكبير"، مطبعة معهد ماشوستس للتكنولوجيا.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:53:08',
            ),
            45 => 
            array (
                'id' => 46,
                'title' => 'Lumumba Di-Aping',
                'title_ar' => 'لومومبا دي-أبينغ',
                'slug' => 'lumumba-di-aping',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Lumumba Di-Aping has dedicated his career in both the public and private sectors to addressing the inequality that hinders the development of the Global South. From his early career as a strategy consultant and investment banker at Greenwich Capital Group, McKinsey and Company, and DL Jay Investment Bank from 1993 to 2004, he moved on to serving as ambassador and deputy head of the Sudan mission to the United Nations from 2006 to 2012. During that tenure, he was Lead Negotiator for Developing Countries on Energy, Environment, Trade and Global Governance and Chairman of the G77+China group of 132 developing nations and led the block\'s negotiation on reform of the International Financial Institutions (IMF/WB) and at the Copenhagen climate conference. He served as chairman of the African Group and chief negotiator for developing countries. He is a member of the National Liberation Council of the Sudan People\'s Liberation Movement and political Bureau, a group that helped end 20 years of civil war when it signed the comprehensive Peace Agreement in 2005.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">كرّس لومومبا دي-أبينغ مسيرته المهنية في كل من القطاعين العام والخاص لمعالجة اللامساواة التي تعوق تنمية مناطق الجنوب العالمي. وعقب عمله كمستشار استراتيجي واستثماري مصرفي في مجموعة غرينوتش كابيتال، ومكنسي وشركائه، والبنك الاستثماري دي ال جاي (1993 - 2004) ، انتقل للعمل كسفير ونائب رئيس لبعثة السودان لدى الأمم المتحدة للعام 2006 حتى 2012. وخلال تلك الفترة، كان المفاوض الرئيس للدول النامية حول الطاقة والبيئة والتجارة والحوكمة العالمية ورئيس مجموعة "جي 77+ الصين" المكونة من 132 دولة نامية، وقاد مفاوضات الكتلة حول إصلاح المؤسسة المالية الدولية(IMF/WB) وفي مؤتمر كوبنهاغن للمناخ. وشغل منصب رئيس المجموعة الأفريقية وكبير المفاوضين في البلدان النامية. وهو عضو في المجلس الوطني للتحرير في الحركة الشعبية لتحرير السودان والمكتب السياسي، وهي جماعة ساعدت على إنهاء 20 عاماً من الحرب الأهلية في توقيعها اتفاقية السلام الشامل في عام 2005.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:53:27',
            ),
            46 => 
            array (
                'id' => 47,
                'title' => 'Atif Osman ',
                'title_ar' => 'عاطف عثمان',
                'slug' => 'atif-osman',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Atif Osman is a Senior Legal Consultant at Sharjah Urban Planning Council (SUPC) and Sharjah Architecture Triennial. He has contributed to the establishment of the Triennial by providing legal advice for the institution\'s activities. In addition, Osman handles the preparation and drafting of legislations, by-laws, contracts, and agreements in coordination with the departments concerned at the Triennial. Osman is a qualified Legal Consultant with over 13 years of experience in managing legal affairs for the Government of Sharjah, UAE, and corporate enterprises. Before joining SUPC, Osman worked as a Legal Consultant in City International Advocates &amp; Legal Consultants, Abdullah Group for General Enterprises, and Emirates International Law Firm in Abu Dhabi, UAE.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">عاطف عثمان مستشار قانوني في مجلس الشارقة للتخطيط العمراني وترينالي الشارقة للعمارة. وقد ساهم في تأسيس الترينالي من خلال تقديم المشورة القانونية لأنشطة المؤسسة. بالإضافة إلى ذلك، يتولى عثمان إعداد وصياغة التشريعات، والعقود الداخلية والاتفاقيات بالتنسيق مع الإدارات المعنية في الترينالي. وعثمان مستشار قانوني يتمتع بخبرة تصل إلى 13عاماً في إدارة الشؤون القانونية لحكومة الشارقة والإمارات العربية المتحدة والشركات المؤسساتية. وقبل انضمامه إلى مجلس الشارقة للتخطيط العمراني، عمل عثمان مستشاراً قانونياً في سيتي إنترناشونال للمحاماة والاستشارات القانونية، ومجموعة عبد الله للمشاريع العامة، وشركة الإمارات الدولية للمحاماة في أبوظبي، الإمارات العربية المتحدة.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:53:44',
            ),
            47 => 
            array (
                'id' => 48,
                'title' => 'Diane Mehanna',
                'title_ar' => 'ديان مهنا',
                'slug' => 'diane-mehanna',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Diane Mehanna is a Project Coordinator at Sharjah Architecture Triennial, and has over four years of experience in architectural design and construction. Her previous experience includes managing Hadjithomas and Joreige\'s Art Studio where she assisted in scenography and exhibition design. Mehanna holds a Master\'s degree in Architecture from the Academie Libanaise des Beaux-Arts (ALBA) and is presently completing her thesis as part of a second Master\'s degree in Art Criticism and Curatorial Studies at USJ in Beirut, Lebanon. Mehanna is a co-founder and co-writer of "Losing Touch, Beyrouth des petits métiers", a book on Lebanese traditional craftsmen, published by Tamyras in 2011.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تقوم ديان مهنا بتنسيق المشاريع كمهندس معماري في ترينالي الشارقة للعمارة، وتتمع بخبرة تزيد على 4 سنوات في التصميم المعماري والبناء. وتتضمن خبرتها السابقة إدارة محترف حاجي توما وجريج للفن التشكيلي، حيث ساعدت في تصميم المعارض والتصوير. تحمل مهنا درجة الماجستير في العمارة من الأكاديمية اللبنانية للفنون الجميلة (ALBA) وتكمل حالياً أطروحتها كجزء من درجة الماجستير الثانية في النقد الفني ودراسات التنظيم في جامعة القديس يوسف في بيروت، لبنان. وتعدّ مهنّا إحدى المؤسسين والمشاركين في تأليف كتاب "Losing Touch، Beyrouth des petits métiers"، وهو كتاب عن الحرفيين اللبنانيين التقليديين، والذي صدر في عام 2011 عن دارTamyras.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:54:10',
            ),
            48 => 
            array (
                'id' => 49,
                'title' => 'Ellis Woodman',
                'title_ar' => 'إليس وودمان',
                'slug' => 'ellis-woodman',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Ellis Woodman is the director of the Architecture Foundation in London and an internationally acclaimed critic and curator. He writes regularly about architecture for The Daily Telegraph and the Architect\'s Journal and has contributed essays to monographic publications on the work of architects from across the world, including Carmody Groarke (El Croquis, 2018), Robbrecht en Daem (An Architectural Anthology, 2017), Office Kersten Geers David van Severen (Vol. 3, 2017 and 2G, 2012), Pezo von Ellrichshausen (Exterior, 2017), Peter Märkli, (Everything One Invents is True, 2017) and Biq (Habitat: Biq Builds the City, 2013). Ellis was curator of the exhibition Home/Away: British Architects Build Housing in Europe at the 2008 Venice Architecture Biennale and has more recently co-curated the Office Kersten Geers David van Severen retrospective, Everything Architecture, at Bozar in Brussels (2016) and James Gowan &amp; Alvaro Siza: Housing and the City at the Architectural Association in London (2017). He is a jury member of the biannual European Urban Public Space Awards, a trustee of Docomomo UK and a member of the advisory board to the British Library\'s Architects\' Lives program. He has lectured in schools of architecture, across Europe and in the United States.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">إليس وودمان، مدير مؤسسة العمارة في لندن وناقد وقيَم معروف عالمياً. يكتب بانتظام عن العمارة لصحيفة الديلي تلغراف ومجلة Architect\'s Journal وقد ساهم بمقالات أدرجت في منشورات علمية عن أعمال المعماريين من جميع أنحاء العالم، بما في ذلك: كارمودي غرورك (ال كروكيس 2018)، روبرخت ان دايم (ان اركيتيكتشر انثولوجي، 2017)، مكتب كيرستن غييرس دافيد فان سيفيرن (العدد الثالث من G2، 2017)، بيزو فون الركشاوسن (اكستيرير، 2017)، بيتر ماركلي (ايفريثنك وان انفنتس از ترو، 2017)، بيك (هابيتات: بيك بلدز ذا سيتي، 2013). كان وودمان قيّماً على معرض "في الوطن/خارجه: معماريون بريطانيون يبنون مساكن في أوروبا"، والذي عرض في بينالي البندقية للعمارة في عام 2008، كما شارك مؤخراً في تقييم معرض استعادي لكيرستن جييرز ديفيد فان سيفرين، بعنوان "كل شيء معماري" في بوزار في بروكسل (2016) و"السكن والمدينة" لجيمس غوان وألفارو سيزا في الرابطة المعمارية في لندن (2017). يشغل وودمان منصب عضو لجنة تحكيم في جوائز بينالي الفضاء العام الأوروبي، ووكيل شركة دوكومومو في المملكة المتحدة، وكان عضواً في المجلس الاستشاري لبرنامج حياة المعماريين في المكتبة البريطانية. وهو يحاضر في كافة مدارس العمارة في جميع أنحاء أوروبا والولايات المتحدة.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:54:28',
            ),
            49 => 
            array (
                'id' => 50,
                'title' => 'Farah Alkhoury',
                'title_ar' => 'فرح الخوري',
                'slug' => 'farah-alkhoury',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Farah Alkhoury is an Architect and Project Coordinator at Sharjah Architecture Triennial. Born in Iraq and raised in Dubai, Alkhoury earned a Bachelor\'s degree in Architecture from the American University of Sharjah in 2016. Upon her graduation, Alkhoury has been practicing architecture in Dubai and Sharjah. She is also a co-founder of "Bites of Architecture", a platform for critical discussion on Architecture in the UAE.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">فرح الخوري معمارية ومنسقة مشاريع في ترينالي الشارقة للعمارة، ولدت في العراق وترعرعت في دبي، وحصلت على درجة البكالوريوس في العمارة من الجامعة الأميركية في الشارقة في عام 2016. بعد تخرجها عملت فرح في الهندسة المعمارية في دبي والشارقة. وهي أيضاً مؤسِّسة مشاركة لـ"Bites of Architecture"، وهي منصة للمناقشة النقدية حول العمارة في الإمارات العربية المتحدة.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:54:45',
            ),
            50 => 
            array (
                'id' => 51,
                'title' => 'Fermin Guerrero',
                'title_ar' => 'فيرمين غيريرو',
                'slug' => 'fermin-guerrero',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Fermín Guerrero is a Senior Graphic Designer at Sharjah Architecture Triennial. Born in Uruguay, he has practiced as a Graphic and Typeface Designer for several years. After he completed his bachelor\'s degree in Industrial Design in 2010, he moved to Switzerland to study Visual Communication at the Haute École d\'Art et de Design (HEAD), Geneva, where he received his BA with first class honours. He subsequently went on to completing a Master\'s degree in Typeface Design at the University of Reading, UK, for which he received a Distinction in 2015. He has worked on a wide range of projects across different disciplines and has won several prestigious prizes and commissions, with his work featured in the most relevant design publications.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">فيرمين غيريرو مصمم جرافيك أول في تيرنالي الشارقة للعمارة. ولد في أوروغواي، وعمل مصمماً غرافيكياً ومصمماً للخطوط لعدة سنوات. وفي عام 2010 وبعد أن أكمل شهادة البكالوريوس في التصميم الصناعي، انتقل إلى سويسرا لدراسة التواصل المرئي في كلية التصميم والجرافيك (HEAD) في جنيف، حيث حصل على درجة البكالوريوس مع مرتبة الشرف الأولى. ثم ذهب بعد ذلك لإكمال درجة الماجستير في تصميم الخطوط في جامعة ريدينغ، في المملكة المتحدة. وفي سبتمبر من عام 2015 حاز درجة امتياز. وقد عمل في مجموعة واسعة من المشاريع في مختلف التخصصات وحصل على العديد من الجوائز المرموقة والتكليفات الفنية، كما توجد أعماله في العديد من مطبوعات التصميم التخصصية.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:55:01',
            ),
            51 => 
            array (
                'id' => 52,
                'title' => 'Farah Hamdan',
                'title_ar' => 'فرح حمدان',
                'slug' => 'farah-hamdan',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Farah Hamdan is an architect with a BArch from the American University of Sharjah. She contributed to Sharjah Architecture Triennial by interning in architectural research in Sharjah. Hamdan is currently conducting an independent study on her ever-growing passion and curiosity towards urban growth and decay. She has also participated in multiple workshops in cities like Olot, Spain, and Amman, Jordan, on topics relevant to Space and Domesticity with RCR Arquitectes and Studio X Amman.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">فرح حمدان معمارية حاصلة على شهادة البكالوريوس من الجامعة الأميركية في الشارقة. وقد تدربت في ترينالي الشارقة للعمارة للمساهمة في مجال البحث حول عمارة الشارقة. وتقوم حالياً بإجراء دراسة مستقلة حول شغفها وفضولها المتنامي نحو النمو والتدهور الحضري. كما شاركت في ورش عمل متعددة في موضوعات ذات صلة بالفضاء والحياة الأسرية مع RCR Arquitectes في مدينة أولوت، إسبانيا، وStudio X Amman في عمان، الأردن.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:55:17',
            ),
            52 => 
            array (
                'id' => 53,
                'title' => 'George Katodrytis',
                'title_ar' => 'جورج كاتودريتيس',
                'slug' => 'george-katodrytis',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">George Katodrytis is an architect involved in practice, teaching and research. He is a Professor and Head of the Department of Architecture at the American University of Sharjah in the United Arab Emirates. He studied and taught at the Architectural Association in London and he has been a visiting professor at various schools around the world. He built a number of projects in Europe and the Middle East as well as published widely on contemporary architecture, urbanism, cultural theory and digital media. The work addresses the ‘city’, especially as it is evolving in the 21st century. He employs digital technology and scripting as tools for establishing new formal and performative language. He is the co-editor of the Architectural Design issue ‘UAE and the Gulf: Architecture and Urbanism Now’. He co-curated an architectural exhibition on Dubai at the 2017 Seoul Biennale of Architecture and Urbanism.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">جورج كاتودريتيس، معماري وباحث أكاديمي. وهو أستاذ ورئيس قسم العمارة في الجامعة الأميركية في الشارقة،الإمارات العربية المتحدة. درس ودرّس في جمعية العمارة في لندن، وعمل أستاذاً زائراً في العديد من المدارس حول العالم. وقام بتنفيذ عدد من المشاريع في أوروبا والشرق الأوسط، كما نشرت له أبحاث في العمارة المعاصرة، والبناء الحضري، والنظرية الثقافية ووسائل الإعلام الرقمية. تتركز مشاريعه حول "المدينة" وتحولاتها في القرن الحادي والعشرين. ويوظف كاتودريتيس التكنولوجيا الرقمية والبرمجة كأدوات لابتكار لغة رسم وأداء جديدين. يشغل حالياً منصب المحرر المشارك في كتاب التصميم المعماري "الإمارات العربية المتحدة والخليج: العمارة والتوسع العمراني الراهن" في عام 2007، وشارك في تنظيم معرض معماري حول دبي في بينالي سيئول العمارة والتحضّر.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:55:35',
            ),
            53 => 
            array (
                'id' => 54,
                'title' => 'Gina Allaf ',
                'title_ar' => 'جينا علاف',
                'slug' => 'gina-allaf',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Gina Allaf is the Marketing Manager at Sharjah Urban Planning Council (SUPC). She has contributed to the establishment of Sharjah Architecture Triennial by supporting its project management since inception in 2017. With over 14 years of experience in communications and brand management across the Middle East in the property and real estate, telecom, banking and government sectors, Allaf has been developing and managing the marketing communications strategy of SUPC since joining in 2014. Allaf has an educational background in graphic design and also performs as a creative consultant, ensuring the brand\'s image is protected and compliant with the strategic objectives of the Council.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">جينا علاف مديرة التسويق في مجلس الشارقة للتخطيط العمراني. ساهمت في تأسيس ترينالي الشارقة للعمارة من خلال دعم إدارة مشاريعه منذ إنشائه في عام 2017. مع أكثر من 14 عاماً من الخبرة في مجال الاتصالات وإدارة العلامات التجارية في جميع أنحاء الشرق الأوسط في قطاعات العقار والاتصالات والقطاع المصرفي والقطاعات الحكومية، طوّرت علاف وأدارت استراتيجية الاتصالات التسويقية الخاصة بمجلس الشارقة للتخطيط العمراني منذ انضمامها إليه في عام 2014. ولدى علاف خلفية علمية في التصميم الغرافيكي وتعمل أيضاً كمستشارة إبداعية، لضمان تكوين صورة علامة تجارية محميّة ومتوافقة مع الأهداف الاستراتيجية للمجلس.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:56:03',
            ),
            54 => 
            array (
                'id' => 55,
                'title' => 'Hoor Al Qasimi',
                'title_ar' => 'حور القاسمي',
                'slug' => 'hoor-al-qasimi',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Sheikha Hoor Al Qasimi, President and Director of Sharjah Art Foundation, is a curator and practicing artist who received her BFA from the Slade School of Fine Art, London (2002), a Diploma in Painting from the Royal Academy of Arts, London (2005) and an MA in Curating Contemporary Art from the Royal College of Art, London (2008). In 2003, she was appointed curator of Sharjah Biennial 6 and has since continued as the Biennial Director.&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Al Qasimi serves on the Board of Directors for MoMA PS1, New York; KW Institute for Contemporary Art, Berlin; Ashkal Alwan, Beirut and Darat Al Funun, Amman. She is President of the International Biennial Association; Chair of the Advisory Board for the College of Art and Design, University of Sharjah and member of the Advisory Board for Khoj International Artists’ Association, New Delhi.&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">She is currently a member of the Prince Claus Award Committee (2016–current) and served as a member of the jury for the Bonnefanten Award for Contemporary Art (2018).&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Al Qasimi has previously served on the juries and prize panels for the Maria Lassnig Prize (2017), Mediacity Seoul Prize (2016), Hepworth Wakefield Prize for Sculpture (2016), Berlin International Film Festival – Berlinale Shorts (2016), Videobrasil (2015), Dubai International Film Festival (2014) and the Benesse Prize (2013).&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Recent curatorial projects include major retrospectives Hassan Sharif: I Am The Single Work Artist (2017–2018), Yayoi Kusama: Dots Obsession (2016–2017), Robert Breer: Time Flies (2016–2017), Simone Fattal (2016) and Farideh Lashai (2016) as well as 1980–Today: Exhibitions in the United Arab Emirates, UAE Pavilion, 56th Venice Biennale (2015); Rasheed Araeen: Before and After Minimalism (2014) and Susan Hefuna: Another Place (2014). Al Qasimi was co-curator for Joana Hadjithomas and Khalil Joreige: Two Suns in a Sunset (2016), exhibited not only in Sharjah but also at Jeu de Paume, Paris; Haus der Kunst, Munich and IVAM, Valencia. She co-curated the major survey shows When Art Becomes Liberty: The Egyptian Surrealists (1938–1965) (2016) and The Khartoum School: The Making of the Modern Art Movement in Sudan (1945–Present) (2016–2017).</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">الشيخة حور بنت سلطان القاسمي، رئيسة ومديرة مؤسسة الشارقة للفنون، قيّمة وفنانة حاصلة على درجة بكالوريوس في الفنون من كلية سليد للفنون الجميلة، لندن (2002)، دبلوم في الرسم من الأكاديمية الملكية للفنون، لندن (2005) وماجستير في تقييم الفن المعاصر من الكلية الملكية للفنون، لندن (2008). جرى تعيينها في عام 2003 قيّمة على بينالي الشارقة بنسخته السادسة، وتشغل منصب مديرة البينالي حتى اليوم.&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تشغل القاسمي منصب عضو مجلس إدارة متحف الفن المعاصر موما بي إس1 في نيويورك، معهد KW للفن المعاصر في برلين، أشكال ألوان في بيروت ودارة الفنون في عمان. هذا وتترأس القاسمي كلًّا من الرابطة الدولية للبينالي، والمجلس الاستشاري لكلية الفنون والتصميم في جامعة الشارقة، وهي عضو في المجلس الاستشاري في رابطة الخوج الدولية للفنانين في الهند، نيودلهي.&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">تشارك القاسمي حاليًا في عضوية كلٍّ من لجنة جائزة الأمير كلاوس (منذ عام 2016)، ولجنة التحكيم لجائزة بونيفانتن للفن المعاصر (منذ عام 2018). وبعد أن كانت لها مشاركات سابقة ضمن لجنة التحكيم لجائزة ماريا لازنج (2017)، جائزة Seoul Mediacity (2016)، جائزة Hepworth Wakefield للنحت (2016)، مهرجان برلين السينمائي الدولي شورت برلينال (2016)، جائزة Videobrasil (2015)، مهرجان دبي السينمائي الدولي (2014) وجائزة بينيس (2013).&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">كذلك سبق للقاسمي الإشراف على تقييم العديد من المعارض الفنية ومن ضمنها: "يايوي كوساما: استحواذ النقاط" (2016-2017)، "روبرت برير.. الوقت يمضي" (2016-2017)، "سيمون فتال" (2016)، "فريدة لاشاي" (2016)، إلى جانب "حول المعارض في الإمارات"، الجناح الوطني لدولة الإمارات في المعرض الدولي للفنون الـ56، بينالي البندقية (2015)، "رشيد أرائين.. قبل وبعد التقليلية" (2014)، "سوزان حفونة.. مكانٌ آخر" (2014). كما شاركت في تقييم معرض "جوانا حاجي توما وخليل جريج: شمسان في المغيب"، والذي أقيم في عام (2016) في الشارقة، وانتقل إلى جو دي بويم في باريس وهاوس دير كونست في ميونخ.&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">كما شاركت الشيخة حور في تقييم عدد من المعارض الاستقصائية الكبرى من بينها: "حين يصبح الفن حرية.. السرياليون المصريون (1938-1965)" في عام 2016، و"مدرسة الخرطوم.. حركة الفن الحديث في السودان (1945 -الحاضر)" والذي امتد عرضه ما بين العامين (2016-2017).</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:56:24',
            ),
            55 => 
            array (
                'id' => 56,
                'title' => 'Hatem Hatem',
                'title_ar' => 'حاتم حاتم',
                'slug' => 'hatem-hatem',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Born in Baghdad, Hatem Hatem is an Architect and Researcher based in the UAE. He completed his bachelor\'s degree in Architecture in 2014 from the American University of Sharjah and has since practiced in a number of UAE based offices. Hatem co-founded A Hypothetical Office (AHO) in 2016 through which he participated in multiple cultural projects, including the design of Abwab pavilions for Dubai Design Week (2016), Al Serkal Residency space (2017) and most recently a courtyard intervention at Warehouse 421 (2018). Hatem was a Fellow of the Salama bint Hamdan Emerging Artists Fellowship (2017) and has exhibited work at Dubai Design Days, UAE Unlimited, Art Dubai and Tashkeel.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">ولد حاتم حاتم في بغداد، وهو معماري وباحث مقيم في الإمارات العربية المتحدة. حاز درجة البكالوريوس في العمارة في عام 2014 من الجامعة الأميركية في الشارقة، ومنذ ذلك الحين وهو يمارس هذا التخصص في عدد من المكاتب في دولة الإمارات العربية المتحدة. شارك حاتم في تأسيس "مكتب افتراضي" (AHO) في عام 2016 شارك من خلاله في العديد من المشاريع الثقافية، بما في ذلك تصميم أجنحة "أبواب" لأسبوع دبي للتصميم (2016)، ومساحة السركال للإقامة الفنية (2017)، وآخرها إدخال فناء على معرض 421 (2018). وكان حاتم زميلاً في منحة سلامة بنت حمدان للفنانين الناشئين (2017) وقد تم عرض أعماله في محافل فنية عدة، مثل أيام دبي للتصميم، والإمارات بلا حدود، وآرت دبي، وتشكيل.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:56:53',
            ),
            56 => 
            array (
                'id' => 57,
                'title' => 'Hisham Sayed ',
                'title_ar' => 'هشام سيد',
                'slug' => 'hisham-sayed',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Hisham Othman Mohammed Sayed is a Financial Controller at Sharjah Urban Planning Council (SUPC) and Sharjah Architecture Triennial. He has contributed to the establishment of the Triennial by providing financial and accounting management for the institution\'s activities. Having worked at the Planning and Survey Department at the Government of Sharjah, UAE, before joining SUPC, Sayed has over 16 years of experience within the finance and budget control sector. Adding to his Bachelor of Economics and Management Sciences from the University of Omdurman Elahalia, Sayed has exponentially expanded his experience by participating in workshops and training courses related to auditing government companies, project management, real estate evaluation and estimation and preparation of budgets.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">هشام عثمان محمد سيد مراقب مالي في مجلس الشارقة للتخطيط العمراني وترينالي الشارقة للعمارة. ساهم في تأسيس الترينالي من خلال توفير الإدارة المالية والمحاسبية لأنشطة المؤسسة. بعد أن عمل لدى دائرة التخطيط والمساحة في حكومة الشارقة، الإمارات العربية المتحدة. قبل الانضمام إلى مجلس الشارقة للتخطيط العمراني، حظي سيد بخبرة تزيد عن 16 عاماً في قطاع الرقابة المالية والموازنة. بالإضافة إلى حصوله على درجة البكالوريوس في الاقتصاد والعلوم الإدارية من جامعة أم درمان الأهلية، فقد وسّع السيد خبرته بشكل كبير من خلال المشاركة في ورش العمل والدورات التدريبية المتعلقة بمراجعة الشركات الحكومية، إدارة المشاريع، التقييم العقاري وتقدير وإعداد الميزانيات.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:57:11',
            ),
            57 => 
            array (
                'id' => 58,
                'title' => 'Ieva Saudargaite ',
                'title_ar' => 'إيفا ساودارجيته',
                'slug' => 'ieva-saudargaite',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Ieva Saudargaite (b. 1988, Lithuania) is a Lithuanian- Lebanes Photographer and visual artist based in Beirut, Lebanon. She grew up between Lithuania, the United Arab Emirates, and Lebanon and studied architecture at the Lebanese American University in Byblos and Ecole Speciale d’Architecture in Paris. Her work has been recently exhibited at the Lebanese Pavilion of the Venice Biennial 2018 and Danish Architecture Center in Copenhagen.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">إيفا ساودارجيته (ولدت في ليتوانيا عام 1919)، مصورة وفنانة بصرية لتوانية لبنانية مقيمة في بيروت لبنان. نشأت ساودارجيته بين ليتوانيا والإمارات العربية المتحدة ولبنان. ودرست العمارة في الجامعة اللبنانية الأميركية في جبيل ومدرسة العمارة الخاصة في باريس. عرضت أعمالها مؤخراً في الجناح اللبناني في بينالي البندقية للعمارة 2018، وفي مركز العمارة الدنماركي في كوبنهاغن.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:57:29',
            ),
            58 => 
            array (
                'id' => 59,
                'title' => 'Khuloud Al Ali ',
                'title_ar' => 'خلود العلي',
                'slug' => 'khuloud-al-ali',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Khuloud Al Ali holds a Bachelor\'s degree in Information Technology - Enterprise Computing from Zayed University in Dubai, UAE. She is an IT Technical Support Officer at Sharjah Urban Planning Council (SUPC) and Sharjah Architecture Triennial where she manages and provides IT services such as handling IT flow, network and Wi-Fi configurations, liaising with different IT companies, managing IOS and Windows installations as well as troubleshooting issues in network, hardware and software.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">حازت خلود العلي على درجة البكالوريوس في تقنية المعلومات وحوسبة المشاريع من جامعة زايد في دبي، الإمارات العربية المتحدة. وهي موظفة دعم فني لتكنولوجيا المعلومات في مجلس الشارقة للتخطيط العمراني وترينالي الشارقة للعمارة، حيث تدير وتقدّم خدمات تكنولوجيا المعلومات مثل: التعامل مع تدفق تكنولوجيا المعلومات، ضبط الشبكات والـ Wi-Fi، والتواصل مع شركات تكنولوجيا المعلومات المختلفة، وإدارة تثبيتات IOS وَ Windows، بالإضافة إلى استكشاف الأخطاء وإصلاحها في الشبكة والأجهزة والبرامج.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:57:49',
            ),
            59 => 
            array (
                'id' => 60,
                'title' => 'Khaled Al Huraimel',
                'title_ar' => 'خالد الحريمل ',
                'slug' => 'khaled-al-huraimel',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Khaled Al Huraimel is the Group Chief Executive Officer of Bee’ah, and has served in this capacity since August 2009. His diligent leadership has accelerated Bee\'ah’s growth from a local waste management company, to an award-winning, integrated environmental management establishment.&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Al Huraimel heads a workforce of 7000 employees, executing Bee’ah’s master plan for sustainability, and of positioning Sharjah as a hub for environmental leadership. His diplomatic skills and innovative business insights have facilitated strategic partnerships and ground-breaking ventures in sustainability. He has worked tirelessly to implement state-of-the-art projects in renewable energy generation, resource recovery and integrated waste management, enabling Bee’ah to achieve landfill diversion rates of up to 76%.&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Roboto;"><br style="color: rgb(33, 37, 41); font-family: Roboto;"><span style="color: rgb(33, 37, 41); font-family: Roboto;">Prior to joining Bee’ah, Al Huraimel spearheaded the growth of companies like ENOC, Nakheel, and Arabian Global Investments, in addition to being a Board Member for Wekaya, AGI, and Alliances for Global Sustainability.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">خالد الحريمل، الرئيس التنفيذي لشركة الشارقة للبيئة "بيئة"، تسلم زمام منصبه منذ أغسطس عام 2009. وقد ساهمت قيادته الرشيدة في تطور الشركة من مجال إدارة النفايات المحلية، إلى مؤسسة إدارة بيئية متكاملة حصدت العديد من الجوائز.&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">يرأس الحريمل قوة عاملة قوامها 7000 موظف، ويقوم بتنفيذ الخطة الرئيسية لشركة بيئة للاستدامة، وهي وضع إمارة الشارقة في مصاف الدول القيادية في مجال الاستدامة البيئية. سهّلت مهاراته الدبلوماسية ورؤاه المبتكرة في مجال ريادة الأعمال حصول "بيئة" على شراكات استراتيجية ومشروعات رائدة في مجال الاستدامة البيئية طويلة الأمد. وقد عمل دون كلل لتنفيذ مشاريع حديثة في مجال توليد الطاقة المتجددة، واستعادة الموارد، وإدارة النفايات المتكاملة، مما مكّن "بيئة" من تحقيق معدلات تحويل للطمر بنسبة 76٪.&nbsp;</span><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><br style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;"><span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">قبيل انضمامه إلى "بيئة"، شغل الحريمل منصب الرئيس التنفيذي لنخبة من الشركات المرموقة مثل شركة "إينوك"، "نخيل"، "أريبيان جلوبال انفستمنتس"، بالإضافة إلى كونه عضواً في مجلس إدارة في كل من شركة"ويكايا"، "إيه جي آي" و "تحالف الاستدامة العالمية".</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:58:11',
            ),
            60 => 
            array (
                'id' => 61,
                'title' => 'Khalid bin Sultan Al Qasimi',
                'title_ar' => 'خالد القاسمي',
                'slug' => 'khalid-bin-sultan-al-qasimi',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Sheikh Khalid Bin Sultan Al Qasimi is Chairman of Sharjah Architecture Triennial and Sharjah Urban Planning Council. Drawing on his academic background in architecture and design at the Architectural Association and Central Saint Martins in London, Al Qasimi oversees integrated inter-governmental efforts to introduce a new vitality into Sharjah\'s architecture and urban development. Under his leadership, Sharjah Urban Planning Council ensures that Sharjah and its residents have access to a future with sustainable economic growth and social wellbeing. Building on this foundation, Sharjah Architecture Triennial serves as the first major platform to address critical reflection on the architecture and urbanism in the Middle East, North and East Africa and South and South East Asia, placing Sharjah\'s development in dialogue with the wider region. Al Qasimi is also the Founder and Creative Director of critically-acclaimed London based men\'s fashion brand Qasimi which combines modern minimalism and timeless tradition with architectural shapes. Furthermore, his photography was recognized by two golden prizes at the first Arab-Euro Festival for Photography organised by the Arab Photographers Union in in 2004.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">الشيخ خالد بن سلطان القاسمي رئيس مجلس إدارة ترينالي الشارقة للعمارة ومجلس الشارقة للتخطيط العمراني، ونظراً لمرجعيته الأكاديمية في العمارة والتصميم من الجمعية المعمارية وسان مارتينز المركزية في لندن، يشرف القاسمي على جهود حكومية متكاملة لإدخال روح جديدة على العمارة والتنمية الحضرية في الشارقة. يضمن مجلس الشارقة للتخطيط العمراني تحت قيادته حصول الشارقة ومقيميها على مستقبل يتمتع بنمو اقتصادي مستدام ورفاهية اجتماعية. ومن هذا المنطلق، فإن ترينالي الشارقة للعمارة هو أول منصة رئيسية تتعامل مع التفكير النقدي في العمارة و التحضر في منطقة الشرق الأوسط وشمال وشرق أفريقيا وجنوب وجنوب شرق آسيا، مما يضع تنمية الشارقة في حوار مع المنطقة الأوسع. كما أن القاسمي هو أيضاً المؤسس والمدير الإبداعي لعلامة Qasimi التجارية الرجالية في لندن والتي نالت إشادة النقاد، وتجمع بين البساطة العصرية والتقاليد الخالدة مع أشكال هندسية. وعلاوة على ذلك، تمت تزكية موهبته في التصوير باثنتين من الجوائز الذهبية في أول مهرجان عربي ـ أوروبي للتصوير الفوتوغرافي نظمه اتحاد المصورين العرب في العام 2004.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:58:32',
            ),
            61 => 
            array (
                'id' => 62,
                'title' => 'Manaswi Jinadra',
                'title_ar' => 'مناسوي جينادرا',
                'slug' => 'manaswi-jinadra',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">In search of an alternative point of view, Manaswi Jinadra experiments with drone photography to capture the world from above. Jinadra has contributed to Sharjah Architecture Triennial by producing the video clips featured on the website\'s homepage. He was born and brought up in Sharjah, where he studied and now works. Jinadra started to experiment with photography from the age of 16, inspired by one of his peers. He received the Mansoor Bin Mohammed Short Film Award in two different categories in 2018, and was short listed in the finals for the 2018 Abu Dhabi Through Your Eyes competition amongst 4,000 entries and reached the final round of judging in the Hamdan Bin Mohammed Bin Rashid Al Maktoum International Photography Awards (HIPA).</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">بحثًا عن وجهة نظر بديلة، يختبر ماناسوي جينادرا التصوير الفوتوغرافي الجوي لالتقاط صورة العالم من الأعلى. ساهم جينادرا في ترينالي الشارقة للعمارة من خلال إنتاج مقاطع الفيديو المعروضة على الصفحة الرئيسية للموقع. ولد وترعرع في الشارقة، حيث درس ويعمل الآن. بدأت تجربة جينادرا في التصوير الفوتوغرافي منذ سن 16 مستلهماً من أحد أقرانه. حاز على جائزة منصور بن محمد للفيلم القصير عن فئتين مختلفتين في عام 2018، وأدرج ضمن القائمة النهائية لمسابقة "أبوظبي من خلال عيونكم" للعام 2018 من بين 4000 مشاركة، ووصل إلى الجولة النهائية من التحكيم في جائزة حمدان بن محمد بن راشد آل مكتوم الدولية للتصوير الضوئي (HIPA).</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:58:50',
            ),
            62 => 
            array (
                'id' => 63,
                'title' => 'Mariam Janjelo',
                'title_ar' => 'مريم جنجلو',
                'slug' => 'mariam-janjelo',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Mariam Janjelo is a specialist in Arabic translation, editing, and proofreading, having graduated with a Bachelor of Arabic Literature from the Lebanese University in Beirut. She has also studied Arabic music at the Lebanese National Higher Conservatory of Music. Her passion for reading and writing has been foundational for her career, which started in 2006 as a journalist in the Cultural Department, Al-Safir Lebanese newspaper, with responsibilities including editing articles, conducting interviews, and covering cultural events in Beirut. Janjelo moved to Kuwait in 2008 to work with several renowned periodicals, including the monthly Al-Hadaf, and Al-Qabas, Awan, and Al-Nahar newspapers, as well as the Arabic edition of Marie Claire. In 2012, she worked with several companies including Al-Hudhud Advertising and Marketing, Tamdin Al-Qabidah, and Burson-Marsteller for public relations, as a manager of client relations for high profile accounts including Turkish Airlines, Warbah Bank, Al-Tashilat Trading, and Al-Arjan Real Estate, where she supervised media and marketing activities and provided linguistic and practical consultation. In 2014, she became an freelance consultant for Barjeel Art Foundation in the UAE, and she worked on editing two books that covered the careers and works of two visual arts icons in the Arab world, the Kuwaiti Sami Mohammed and Iraqi Dia Azzawi.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">مريم جنجلو متخصصة في الترجمة والتحرير باللغة العربية، حاصلة على بكالوريوس في الأدب العربي من الجامعة اللبنانية في بيروت، بالإضافة إلى دراسة الموسيقى الشرقية في الكونسرفاتوار اللبناني. شكّل شغفها بالمطالعة والكتابة أساساً لمسيرتها المهنية التي بدأتها في العام 2006 كصحافية في القسم الثقافي في جريدة السفير اللبنانية، وشملت مهامها تحرير المقالات وإجراء الحوارات وتغطية الفعاليات الثقافية في بيروت. انتقلت في العام 2008 إلى الكويت للعمل مع صحف ومجلات كويتية معروفة منها مجلة الهدف الشهرية، صحف القبس وأوان والنهار ودورية ماري كلير بنسختها العربية. في العام 2012، عملت مع عدة شركات منها شركة الهدهد للإعلان والتسويق، وتمدين القابضة، ووكالة أصداء بيرسون مارستيلر العالمية للعلاقات العامة، بصفتها مدير ملفات لعملاء مرموقين مثل الخطوط الجوية التركية، وبنك وربة، والتسهيلات التجارية والأرجان العقارية الدولية، حيث أشرفت على فعالياتهم الإعلامية والتسويقية وتقديم الاستشارات اللغوية والعملية. وفي العام 2014، باشرت العمل اللغوي بشكل مستقل مع مؤسسة بارجيل للفنون في الإمارات، وكذلك عملت على تحرير كتابين يتناول كل منهما سيرة وإنجازات اثنين من أشهر أعلام الفنون البصرية العرب، وهم الكويتي سامي محمد والعراقي ضياء العزاوي.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:59:13',
            ),
            63 => 
            array (
                'id' => 64,
                'title' => 'Mahnaz Fancy ',
                'title_ar' => 'ماهناز فانسي',
                'slug' => 'mahnaz-fancy',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Raised in Karachi, Paris, Abu Dhabi and New York, Mahnaz Fancy is a Cultural Critic with over 15 years of experience in leading nonprofit institutions. After pursuing a PhD in Comparative Literature at the University of Chicago that concentrated on colonialism and aesthetics, she launched several initiatives for supporting contemporary arts communities in the Middle East, North Africa and South Asia (MENASA). Most recently, she served as Executive Director of ArteEast, the leading US-based organization in the field. Working closely with local, regional, and international stakeholders from philanthropic, academic, and creative sectors, Fancy has organized exhibitions, festivals, conferences, professional workshops, and public educational programs. She continues to write and speak on regional arts and their social impact in an interconnected world.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">نشأت فانسي بين كراتشي وباريس وأبوظبي ونيويورك، وهي ناقدة ثقافية تتمتع بخبرة تمتد لأكثر من 15 عاماً في قيادة المؤسسات غير الربحية الرائدة. بعد متابعة الدكتوراه في الأدب المقارن من جامعة شيكاغو، والتي ركزت فيها على الاستعمار وعلم الجمال، أطلقت عدة مبادرات لدعم مجتمعات الفنون المعاصرة في الشرق الأوسط وشمال أفريقيا وجنوب آسيا. وقد شغلت في الآونة الأخيرة منصب المدير التنفيذي لـِ ArteEast، المنصة الرائدة في الولايات المتحدة في هذا المجال. كما عملت بشكل وثيق مع المعنيين من الشركاء المحليين والإقليميين والدوليين من القطاعات الخيرية والأكاديمية والإبداعية، على تنظيم المعارض والمهرجانات والمؤتمرات وورش العمل المهنية والبرامج التعليمية العامة. وهي مستمرة في الكتابة وإلقاء المحاضرات حول الفنون الإقليمية وأثرها الاجتماعي في عالم مترابط.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:59:31',
            ),
            64 => 
            array (
                'id' => 65,
                'title' => 'Mona El Mousfy',
                'title_ar' => 'منى المصفي',
                'slug' => 'mona-el-mousfy',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Mona El Mousfy is the Advisor to Sharjah Architecture Triennial, and has played a key role in founding the initiative since 2017. She is an architect whose work focuses on cultural spaces and dwellings. She has served as the Architecture Consultant for Sharjah Art Foundation since 2005. In this capacity, she has not only worked on all successive editions of Sharjah Biennial but also designed Sharjah Art Foundation galleries in Al Mureijah Square and the Rain Room building in Al Mujarrah, Sharjah. After twelve years at the faculty of the College of Architecture, Art and Design, American University of Sharjah (2002–2014), El Mousfy founded the UAE research-based architecture studio SpaceContinuum in 2014. The practice centers on creating new spatial possibilities across scales, for shared socializing and everyday life.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">منى المصفي، مستشارة ترينالي الشارقة للعمارة، وأسهمت بشكل فعّال في تأسيسه منذ عام 2017. وهي معمارية تركز على المساحات الثقافية والمساكن. كما عملت كاستشارية معمارية لمؤسسة الشارقة للفنون منذ عام 2005. وعبر هذه الإمكانات فإنها لم تعمل على جميع دورات بينالي الشارقة المتتالية فحسب، بل أنها صممت أيضاًمباني مؤسسة الشارقة للفنون في ساحة المريجة، ومبنى الغرفة الماطرة في منطقة المجرة في الشارقة. وقد عملت المصفي لمدة 12 عاماً ضمن الهيئة التدريسية لكلية العمارة والفنون والتصميم في الجامعة الأميركية في الشارقة (2002-2014)، ثم أسّست في عام 2014 استوديو "سبيس كونتنيوم" المعماري البحثي الإماراتي، وقد ركزت فيه على إيجاد فرص مكانية جديدة عبر مختلف مقاييس المشاركة المجتمعية والحياة اليومية.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 10:59:50',
            ),
            65 => 
            array (
                'id' => 66,
                'title' => 'Ryan Miglinczky',
                'title_ar' => 'رايان ميغلنكزكي',
                'slug' => 'ryan-miglinczky',
                'description' => '',
                'description_ar' => '',
                'publish_date' => '0000-00-00',
            'content' => '<span style="color: rgb(33, 37, 41); font-family: Roboto;">Ryan is an award winning multi-disciplinary Designer and Art Director working between London and Dubai. He received a BA(hons) in Graphic Design from the University of Lincoln. Specializing in identity design and print, he has created brands for a number of high profile companies in the Middle East such as Dubai Airports and Meraas as well as independent cultural brands such as Art Week Dubai and Brownbook Magazine, where he held the role of Creative Director.</span>

',
            'content_ar' => '<span style="color: rgb(33, 37, 41); font-family: Tahoma; text-align: right;">رايان مصمم ومدير فني متعدد التخصصات حائز على العديد من الجوائز ويعمل بين لندن ودبي. حاصل على درجة البكالوريوس (مع مرتبة الشرف) في التصميم الغرافيكي من جامعة لينكولن. بتخصصه في تصميم الهوية والمطبوعات، أنشأ علامات تجارية متميزة في الشرق الأوسط مثل مطارات دبي ومشروع مراس. والمزيد من العلامات الثقافية المستقلة مثل أسبوع الفن في دبي ومجلة براونبوك، حيث شغل منصب المدير الإبداعي.</span>

',
                'additional_content_top' => NULL,
                'additional_content_bottom' => '',
                'page_id' => 7,
                'active' => 1,
                'created_at' => '2018-11-21 10:01:12',
                'updated_at' => '2018-11-21 11:00:07',
            ),
        ));
        
        
    }
}
