@include('pages.research.header')

<div id="loader"></div>

<div id="main-wrap" class="">
    <div id="map-wrap" class="">
        <div id="map-canvas"></div>
        <div id="introwrap">
            <span id="clickstart">
                @if ($lang == 'ar')
                    للبدء، اضغط في أي مكان
                @else
                    <div class="desk-only">
                        Click anywhere<br /> to enter
                    </div>
                    <div class="mobile-only">
                        Tap here to enter
                    </div>
                @endif
            </span>
        </div>

        <div class="animateleft audiofy" id="intropop">
            {{--            <div class="overflow"></div> --}}
            <div class="copy">
                <div>

                    @if ($lang == 'ar')
                        <h1>{{ $content['intro']->title_ar }}</h1>
                    @else
                        <h1>{{ $content['intro']->title }}</h1>
                    @endif

                    <div class="pagecontent " data-simplebar data-simplebar-auto-hide="false">
                        @if ($lang == 'ar')
                            {!! $content['intro']->content_ar !!}
                        @else
                            {!! $content['intro']->content !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <?php
        $types->toArray();
        $timelines = ['pre-1960', '1960-1980', '1981-2000', '2001-2020', 'post-2020'];
        ?>

        <div class="slide-in-left animateleft" id="catpop">
            <ul id="typeSelection">
                @foreach ($types as $type)
                    {{--                    <li><a href="#" data-id="{{$type->id}}" data-color="{{ $type->color }}" style="border-color:{{ $type->color }};color:{{ $type->color }}">{{$type->title}}</a></li> --}}
                    <li class=""><a href="#" class="audiofy" data-id="{{ $type['id'] }}"
                            data-slug="{{ $type['slug'] }}" data-color="{{ $type['color'] }}">
                            @if ($lang == 'ar')
                                {{ $type['title_ar'] }}
                            @else
                                {{ $type['title'] }}
                            @endif
                        </a></li>
                @endforeach
            </ul>
        </div>

        @foreach ($types as $type)
            {{--            <div class="valign slide-in-left animateleft catdetail" id="cat-{{$type->id}}" style="background-color: {{ $type->color }}"> --}}
            @if (($lang == 'en' && $type['content']) || ($lang == 'ar' && $type['content_ar']))
                <div class="valign slide-in-left catdetail typeOnly" id="cat-{{ $type['id'] }}">
                    <div class="close"></div>
                    <div class="audiofy">
                        <div class="scrollwrap " data-simplebar data-simplebar-auto-hide="false">
                            @if ($lang == 'ar')
                                <p>{!! $type['content_ar'] !!}</p>
                            @else
                                <p>{!! $type['content'] !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @foreach ($timelines as $timeline)
                @if ($lang == 'ar' && $type[$timeline . '_ar'])
                    <div class="valign slide-in-left catdetail {{ $timeline }} {{ $type['slug'] }}" data-type="">
                        <div class="close"></div>
                        <div class="scrollwrap" data-simplebar data-simplebar-auto-hide="false">
                            {!! $type[$timeline . '_ar'] !!}
                        </div>
                    </div>
                @elseif($lang == 'en' && $type[$timeline])
                    <div class="valign slide-in-left catdetail {{ $timeline }} {{ $type['slug'] }}"
                        data-type="">
                        <div class="close"></div>
                        <div class="scrollwrap" data-simplebar data-simplebar-auto-hide="false">
                            {!! $type[$timeline] !!}
                        </div>
                    </div>
                @endif
            @endforeach
        @endforeach

        @foreach ($timelineContent as $slug => $timeline)
            @if (trim(strip_tags($timeline->content)))
                <div class="valign slide-in-left catdetail {{ $slug }} timeline-only" data-type="">
                    <div class="close"></div>
                    <div class="scrollwrap" data-simplebar data-simplebar-auto-hide="false">
                        @if ($lang == 'ar')
                            {!! $timeline->content_ar !!}
                        @else
                            {!! $timeline->content !!}
                        @endif

                    </div>
                </div>
            @endif
        @endforeach

        <div class="page page-3 content-page">
            {{--                <div class="animateleft pagepop"> --}}
            {{--                    <div class="copy"> --}}
            {{--                        <div> --}}

            {{--                            @if ($lang == 'ar') --}}
            {{--                                <h1>{{$content['tab-3']->title_ar}}</h1> --}}
            {{--                            @else --}}
            {{--                                <h1>{{$content['tab-3']->title}}</h1> --}}
            {{--                            @endif --}}

            {{--                            <div class="pagecontent " data-simplebar data-simplebar-auto-hide="false"> --}}
            {{--                                @if ($lang == 'ar') --}}
            {{--                                    {!! $content['tab-3']->content_ar !!} --}}
            {{--                                @else --}}
            {{--                                    {!! $content['tab-3']->content !!} --}}
            {{--                                @endif --}}
            {{--                            </div> --}}
            {{--                        </div> --}}
            {{--                    </div> --}}
            {{--                </div> --}}
            <div class="container relative">
                <div class="left">
                    <div class="owl-carousel-holder right-content mb-3 mobile-only" dir="ltr">
                        @if (count($content['tab-3']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-3']->images as $image)
                                <div class="item"><img src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>

                    @if ($lang == 'ar')
                        <h1 class="">{{ $content['tab-3']->title_ar }}</h1>
                    @else
                        <h1 class="">{{ $content['tab-3']->title }}</h1>
                    @endif

                    <div class="copy" data-simplebar data-simplebar-auto-hide="false">

                        @if ($lang == 'ar')
                            {!! $content['tab-3']->content_ar !!}
                        @else
                            {!! $content['tab-3']->content !!}
                        @endif

                    </div>
                </div>
                <div class="right order-first order-lg-last">
                    <div class="owl-carousel-holder right-content mb-3" dir="ltr">
                        @if (count($content['tab-3']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-3']->images as $image)
                                <div class="item"><img src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page page-2 content-page">
            {{--            <div class="animateleft pagepop"> --}}
            {{--                <div class="copy"> --}}
            {{--                    <div> --}}

            {{--                        @if ($lang == 'ar') --}}
            {{--                            <h1>{{$content['tab-2']->title_ar}}</h1> --}}
            {{--                        @else --}}
            {{--                            <h1>{{$content['tab-2']->title}}</h1> --}}
            {{--                        @endif --}}

            {{--                        <div class="pagecontent " data-simplebar data-simplebar-auto-hide="false"> --}}
            {{--                            @if ($lang == 'ar') --}}
            {{--                                {!! $content['tab-2']->content_ar !!} --}}
            {{--                            @else --}}
            {{--                                {!! $content['tab-2']->content !!} --}}
            {{--                            @endif --}}
            {{--                        </div> --}}
            {{--                    </div> --}}
            {{--                </div> --}}
            {{--            </div> --}}
            <div class="container relative">
                <div class="left">
                    <div class="owl-carousel-holder right-content mb-3 mobile-only" dir="ltr">
                        @if (count($content['tab-2']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-2']->images as $image)
                                <div class="item"><img src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>

                    @if ($lang == 'ar')
                        <h1 class="">{{ $content['tab-2']->title_ar }}</h1>
                    @else
                        <h1 class="">{{ $content['tab-2']->title }}</h1>
                    @endif

                    <div class="copy" data-simplebar data-simplebar-auto-hide="false">

                        @if ($lang == 'ar')
                            {!! $content['tab-2']->content_ar !!}
                        @else
                            {!! $content['tab-2']->content !!}
                        @endif

                    </div>
                </div>
                <div class="right order-first order-lg-last desk-only">
                    <div class="owl-carousel-holder right-content mb-3" dir="ltr">
                        @if (count($content['tab-2']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-2']->images as $image)
                                <div class="item"><img src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page page-1 content-page" id="repositories">
            <div class="container" style="position:relative; height: 100%;">
                <div class="">

                    @if ($lang == 'ar')
                        <h1 class="">{{ $content['tab-1']->title_ar }}</h1>
                    @else
                        <h1 class="">{{ $content['tab-1']->title }}</h1>
                    @endif

                    <div class="pagecontent" data-simplebar data-simplebar-auto-hide="false">

                        @if ($lang == 'ar')
                            {!! $content['tab-1']->content_ar !!}
                        @else
                            {!! $content['tab-1']->content !!}
                        @endif

                        <div class="row mt-4">
                            <div class="col-md-12">
                                {{--                        <b>Filter: </b> <a href="#">Seminars</a> | <a href="#">Webinars</a> | <a href="#">Discussions</a> | <a href="#">Publications</a> --}}
                                <span class="filterlabel">
                                    Filter by:</span>
                                <select id="repositoryFilter">
                                    <option value="all">All Media</option>

                                    @foreach ($repositoryTypes as $type)
                                        {{--                            <button class="submit repository-type-bt" data-slug="{{$type->slug}}" is_video="{{$type->is_video}}">{{$type->title}}</button> --}}

                                        @if ($lang == 'ar')
                                            <option value="{{ $type->slug }}">{{ $type->title_ar }}</option>
                                        @else
                                            <option value="{{ $type->slug }}">{{ $type->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-5">
                            @foreach ($repositories as $repository)
                                <div class="col-lg-3 col-md-4 type-{{ $repository->type->slug }} repos">
                                    <div class="vid {{ $repository->type->is_video ? 'is_video' : '' }}"
                                        data-id="{{ $repository->id }}">
                                        <div class="wrap">
                                            <img src="{{ asset('public/' . $repository->image) }}" width="100%">
                                        </div>

                                        @if ($lang == 'ar')
                                            <h5>{{ $repository->title_ar }}</h5>
                                            <p class="text-center">{{ $repository->subtitle_ar }}</p>
                                            <p class="text-center">{{ $repository->type->title_ar }}</p>
                                        @else
                                            <h5>{{ $repository->title }}</h5>
                                            <p class="text-center">{{ $repository->subtitle }}</p>
                                            <p class="text-center">{{ $repository->type->title }}</p>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($repositories as $repository)
                <div class="video-pop video-{{ $repository->id }}">
                    <div class="container relative">
                        <div class="left">
                            @if ($repository->type_set == 'video')
                                <iframe class="right-content vimeovid  mobile-only"
                                    src="https://player.vimeo.com/video/{{ $repository->video }}" width="100%"
                                    frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                <script src="https://player.vimeo.com/api/player.js"></script>
                            @else
                                <div class="owl-carousel-holder right-content mb-3 mobile-only" dir="ltr">
                                    @if (count($repository->images) > 1)
                                        <div class="arrows">
                                            <button class="prev float-left"></button>
                                            <button class="next float-right"></button>
                                        </div>
                                    @endif
                                    <div class="owl-carousel owl-theme news-carousel">
                                        @foreach ($repository->images as $image)
                                            <div class="item"><img src="{{ asset('public/' . $image->image) }}"
                                                    width="100%"></div>
                                        @endforeach
                                    </div>
                                    <div id="owl-dots"></div>
                                </div>
                            @endif
                            <button class="backbutton">

                                @if ($lang == 'ar')
                                    العودة إلى لأرشيف
                                @else
                                    Back to repository
                                @endif
                            </button>
                            @if ($lang == 'ar')
                                <h1>{{ $repository->title_ar }}</h1>
                                <p>{{ $repository->subtitle_ar }}</p>
                            @else
                                <h1>{{ $repository->title }}</h1>
                                <p>{{ $repository->subtitle }}</p>
                            @endif

                            <div class="copy" data-simplebar data-simplebar-auto-hide="false">
                                @if ($lang == 'ar')
                                    {!! $repository->content_ar !!}
                                @else
                                    {!! $repository->content !!}
                                @endif
                            </div>

                        </div>
                        <div class="right order-first order-lg-last desk-only right-content">
                            @if ($repository->type_set == 'video')
                                <iframe class="right-content vimeovid"
                                    src="https://player.vimeo.com/video/{{ $repository->video }}" width="100%"
                                    frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                <script src="https://player.vimeo.com/api/player.js"></script>
                            @else
                                <div class="owl-carousel-holder right-content mb-3" dir="ltr">
                                    @if (count($repository->images) > 1)
                                        <div class="arrows">
                                            <button class="prev float-left"></button>
                                            <button class="next float-right"></button>
                                        </div>
                                    @endif
                                    <div class="owl-carousel owl-theme news-carousel">
                                        @foreach ($repository->images as $image)
                                            <div class="item"><img src="{{ asset('public/' . $image->image) }}"
                                                    width="100%"></div>
                                        @endforeach
                                    </div>
                                    <div id="owl-dots"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="page page-4 content-page">
            {{--            <div class="animateleft pagepop"> --}}
            {{--                <div class="copy"> --}}
            {{--                    <div> --}}

            {{--                        @if ($lang == 'ar') --}}
            {{--                            <h1>{{$content['tab-4']->title_ar}}</h1> --}}
            {{--                        @else --}}
            {{--                            <h1>{{$content['tab-4']->title}}</h1> --}}
            {{--                        @endif --}}

            {{--                        <div class="pagecontent " data-simplebar data-simplebar-auto-hide="false"> --}}
            {{--                            @if ($lang == 'ar') --}}
            {{--                                {!! $content['tab-4']->content_ar !!} --}}
            {{--                            @else --}}
            {{--                                {!! $content['tab-4']->content !!} --}}
            {{--                            @endif --}}
            {{--                        </div> --}}
            {{--                    </div> --}}
            {{--                </div> --}}
            {{--            </div> --}}

            <div class="container relative">
                <div class="left">
                    <div class="owl-carousel-holder right-content mb-3 mobile-only" dir="ltr">
                        {{--                        @if (count($content['tab-4']->images) > 1) --}}
                        {{--                            <div class="arrows"> --}}
                        {{--                                <button class="prev float-left"></button> --}}
                        {{--                                <button class="next float-right"></button> --}}
                        {{--                            </div> --}}
                        {{--                        @endif --}}
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-4']->images as $image)
                                <div class="item"><img src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>

                    @if ($lang == 'ar')
                        <h1 class="">{{ $content['tab-4']->title_ar }}</h1>
                    @else
                        <h1 class="">{{ $content['tab-4']->title }}</h1>
                    @endif

                    <div class="copy" data-simplebar data-simplebar-auto-hide="false">

                        @if ($lang == 'ar')
                            {!! $content['tab-4']->content_ar !!}
                        @else
                            {!! $content['tab-4']->content !!}
                        @endif

                    </div>
                </div>
                <div class="right order-first order-lg-last desk-only">
                    <div class="owl-carousel-holder right-content mb-3" dir="ltr">
                        @if (count($content['tab-4']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-4']->images as $image)
                                <div class="item"><img src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="timeline">
        <div class="line">
        </div>
        <ul id="timelineSelect">
            @foreach ($timelines as $timeline)
                <li><span><a href="#" data-id="{{ $timeline }}">

                            @if ($lang == 'ar')
                                {{ $content[$timeline]->title_ar }}
                            @else
                                {{ $content[$timeline]->title }}
                            @endif
                        </a></span></li>
            @endforeach
        </ul>
    </div>

    <div class="page" id="building">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div id="content">
                        <div class="pull-left">
                            <h3 class="page-heading" id="building-title"></h3>
                            <div class="copy mb-3" data-simplebar data-simplebar-auto-hide="false">
                                <div id="building-content">
                                </div>
                            </div>
                        </div>
                        <a href="#" id="showform"><b>

                                @if ($lang == 'ar')
                                    ساهم بقصتك أو معلوماتك <br />عن هذا المبنى
                                @else
                                    Contribute with your story <br />
                                    or data related to this building
                                @endif
                            </b></a>
                    </div>
                    <div id="successAlert" class="alert-success alert">Thank you for your feedback.</div>
                    <div id="form">
                        <form action="{{ url('research/submit') }}" method="post" id="researchForm">
                            @csrf
                            <input type="hidden" name="research_building_id" id="researchId">
                            <label>
                                @if ($lang == 'ar')
                                    Email:
                                @else
                                    Email:
                                @endif
                            </label>
                            <input type="text" class="form-control" name="email" required>
                            <label>
                                @if ($lang == 'ar')
                                    Message:
                                @else
                                    Message:
                                @endif
                            </label>
                            <textarea class="form-control" name="message" required></textarea>
                            <input type="submit" value="Submit" class="submit">
                        </form>
                    </div>

                    <button class="backbutton">
                        @if ($lang == 'ar')
                            العودة إلى الخريطة
                        @else
                            Go back to map
                        @endif
                    </button>
                </div>
                <div class="col-lg-8 col-md-12 order-first order-lg-last">

                    <div class="owl-carousel-holder right-content" dir="ltr">
                        <div class="arrows">
                            {{--                            <button class="prev float-left"></button> --}}
                            <button class="next float-right"></button>
                        </div>
                        <div class="owl-carousel owl-theme" id="building-carousel">
                        </div>
                        <div id="owl-dots"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div id="cursor"></div> --}}
{{-- <div id="cursorFollow"></div> --}}



<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('public/js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChdoqnSnfKQL3byDY_Ju6MvoUD0Xds3Tk"></script>
<script type="text/javascript"
    src="https://github.com/michaelvillar/dynamics.js/releases/download/0.0.8/dynamics.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
<script src="{{ asset('public/js/owl.carousel.min.js') }}"></script>
<script type="text/javascript">
    function showLoader() {
        $('#loader').fadeIn();
    }

    function hideLoader() {
        $('#loader').fadeOut();
    }

    var siteUrl = "{{ url('/') }}";

    $(window).resize(function() {
        setTimeout(function() {
            if ($(window).outerWidth() > 420) {
                toggleSearch();
            }
            if ($(window).outerHeight() < 520) {
                $('#menu .mobile').css('overflow-y', 'scroll');
                $('#menu .mobile').css('height', $(window).outerHeight() - parseInt($('#menu .mobile')
                    .css('margin-top')));
            } else {
                $('#menu .mobile').css('height', 'auto').css('overflow-y', 'hidden');
            }

            resizeMap();
        }, 100);

        $('#menu-bt-close').trigger('click');
    });

    var scrollAnimating = false;

    function verticalAlign() {
        $('.v-content').each(function() {
            $(this).css('margin-top', ('-' + $(this).height() / 2) + 'px');
        });
        $('.v-content.nav-section').each(function() {
            $(this).css('margin-top', '-' + (($(this).height() / 2) + 50) + 'px');
        });
    }

    function showMenu() {
        if (!$('#menu ul li ul').hasClass('animating')) {

            $('.auto-height').css('height', parseInt($(window).outerHeight()) + 'px');
            $('.auto-height-holder').css('height', (parseInt($(window).outerHeight())) + 'px');

            $('#menu').show();
            $('#menu-bt').hide();
            $('body').addClass('disableScroll');
            $('#search-bt').show().css('display', 'block');
            $('#menu-bt-close').show().css('display', 'block');
            $('#menu ul li ul').css('margin-top', '-100%');

            $('#menu .v-content').animate({
                opacity: 1
            }, 300);

            $('#menu .v-content').css('width', $('#menu .auto-height-holder').width() - 30);

            $('#menu').animate({
                top: "0",
                right: "0",
            }, 500, function() {
                $('#menu ul li ul').addClass('animating');


                setTimeout(function() {
                    $('.english-nav').animate({
                        top: '105%',
                        opacity: 1
                    }, 400);
                    $('.arabic-nav').animate({
                        bottom: '105%',
                        opacity: 1
                    }, 400);
                }, 100);

                $('#menu ul li ul').removeClass('animating');

            });

            $('#menu ul li ul').animate({
                marginTop: "0"
            }, 200, function() {});

            verticalAlign();

        }
    }

    $('.mobile .cat').on('click', function(e) {

        if ($(this).closest('a').attr('href') == '#')
            e.preventDefault();

        $('.mobile .cat').hide();
        $(this).show();
        $('#mobile-menu-back').show();
        $(this).closest('li').find('ul').show();
        link = $(this).closest('a').attr('alt');
        $(this).closest('a').attr('href', link);

    });

    $('#mobile-menu-back').on('click', function(e) {

        e.preventDefault();
        $('#menu .mobile ul li ul').hide();
        $('#menu .mobile ul li .cat').show();
        $(this).hide();


        $('#menu .mobile ul li .cat').each(function() {
            $(this).closest('a').attr('href', '#');
        });

    });

    $('.menu-click').on('click', function(e) {
        e.preventDefault();
        showMenu();
    });

    $('#showform').on('click', function() {
        $('#content').hide();
        $('#form').show();
    });

    $('.search-click').on('click', function(e) {

        e.preventDefault();

        $('.search-click').hide();
        if ($(window).outerWidth() > 767) {
            if ($(this).hasClass('active')) {} else {
                if ($('#menu').css('top') != "0px")
                    showMenu();

                $(this).addClass('active');

                if ($('#main-logo').width() + parseInt($('#floating-header').css('padding-left')) + 20 <
                    parseInt($('#menu .auto-height-holder').css('padding-left')))
                    $('#search').width($('#floating-header').width() - parseInt($('#menu .auto-height-holder')
                        .css('padding-left')));
                else
                    $('#search').width($('#floating-header').width() - parseInt($('#main-logo').width()) - 60);

                $('#search').fadeIn().trigger('focus');
                $('#search-submit').show();
            }
        }
    });

    $('.menu-close-click').on('click', function(e) {

        e.preventDefault();
        if (!$('#menu ul li ul').hasClass('animating')) {

            $('#header').removeClass('active');
            $('#menu-bt-close').hide();
            $('#search-bt').hide();
            $('#menu-bt').show();
            $('body').removeClass('disableScroll');

            $('#search').fadeOut();
            $('#search-submit').fadeOut();
            $('#search-bbt').removeClass('active');

            $('#menu ul li ul').addClass('animating');

            $('#menu .v-content').animate({
                opacity: 0
            }, 100);

            $('#menu').animate({
                top: "-105%",
                right: "-205%",
            }, 500, function() {

                $('.english-nav').css('top', '10%').css('opacity', '0');
                $('.arabic-nav').css('bottom', '10%').css('opacity', '0');

                $('#menu ul li ul').removeClass('animating');
                $('#menu').hide();
            });
        }
    });

    function toggleSearch() {
        if ($(window).outerWidth() < 767) {
            $('#search-bt').attr('data-toggle', "modal").attr('data-target', "#searchModal");
        } else {
            $('#search-bt').removeAttr('data-toggle').removeAttr('data-target');
        }
    }

    // $('#menu .buttons form').focusout(function(){
    // 	$('#search').hide().val('');
    // 	$('#search-submit').hide();
    // 	$('#search-bt').removeClass('active').show();
    // });

    toggleSearch();

    // Our markers
    markers = [
        @foreach ($data as $item)
        ['{{ $item->id }}', '{{ $lang == 'ar' ? $item->title_ar : $item->title }}', {{ $item->lat }}, {{ $item->lng }}, '{{ $item->research_type_id }}','{{ asset('public/img/research') }}/m{{ $item->research_type_id }}.png','{{ $item->year }}',"{{ strip_tags(json_encode($item->content)) }}",'{{ $item->color }}','{{ $item->slug }}','{{ $item->thumb }}'], @endforeach
    ];

    // Our type and timeline details

    typeTimeDetails = [];
    @foreach ($types as $type)
        row = {
        'id' : '{{ $type['id'] }}',
        @foreach ($timelines as $timeline)
        '{{ $timeline }}' : `{{ $type[$timeline] }}`, @endforeach
    };
    typeTimeDetails.push(row);
    @endforeach

    var introwrapEl = document.getElementById('introwrap');
    if (introwrapEl) {
        introwrapEl.addEventListener('mousemove', function(e) {
            let body = document.getElementById('introwrap');
            let circle = document.getElementById('clickstart');
            if (circle) {
                let left = e.offsetX;
                let top = e.offsetY;
                circle.style.left = left + 30 + 'px';
                circle.style.top = (top - 60) + 'px';
            }
        });
    }

    function addMarkerClick() {
        $('.show-building').on('click', function() {
            showLoader();
            getCaseStudy($(this).attr('data-id'))
        });
    }

    function getCaseStudy(id) {
        showLoader();

        for (x = 1; x < $('#building-carousel .owl-item').length; x++)
            $('#building-carousel .owl-item').trigger('remove.owl.carousel', x);

        $('#building-carousel .owl-item').trigger('refresh.owl.carousel');

        $.ajax({
            type: "GET",
            url: siteUrl + '/research/get-data/' + id,
            success: function(response) {
                data = JSON.parse(response);

                @if ($lang == 'ar') $('#building-title').html(data.title_ar);
                $('#building-content').html(data.content_ar);
                @else
                $('#building-title').html(data.title);
                $('#building-content').html(data.content); @endif
                $('#researchId').val(data.id);

                $('#building-carousel').trigger('add.owl.carousel', ['<div class="item"><img src="' + data
                    .slides + '" width="100%"> </div>'
                ]);

                if (data.gallery.length) {
                    Object.keys(data.gallery).forEach(key => {
                        console.log(data.gallery[key].image);
                        $('#building-carousel').trigger('add.owl.carousel', [
                            '<div class="item"><img src="' + siteUrl + '/public/' + data
                            .gallery[key].image + '" width="100%"> </div>'
                        ]);
                    });
                    $('#building .arrows').show();
                } else {
                    $('#building .arrows').hide();
                }

                $('#content').show();
                $('#form').hide();
            },
            statusCode: {
                401: function() {}
            },
            complete: function(event, error) {
                hideLoader();
                $('#building').addClass('active');
                $('#building-carousel').trigger('refresh.owl.carousel');
                setTimeout(function() {
                    resizeVideoCopy();
                }, 300);
            }
        });
    }

    $('#researchForm').on('submit', function(e) {
        var form = $(this);
        showLoader();

        e.preventDefault();
        e.stopPropagation();

        data = form.serialize();
        url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response) {
                if (response) {
                    $('#form').hide();
                    $('#successAlert').show();
                    document.getElementById("researchForm").reset();
                }
            },
            statusCode: {},
            complete: function(event, error) {
                hideLoader();
            }
        });
    });

    function addMarker(marker) {
        var markerid = marker[0];
        var category = marker[4];
        var title = marker[1];
        var pos = new google.maps.LatLng(marker[2], marker[3]);
        var content = marker[1];
        var icon = marker[5];
        var year = marker[6];
        var details = marker[7];
        var color = marker[8];
        var slug = marker[9];
        var thumb = marker[10];

        var contentString = '<div class="mapcontent">' +
            '<div class="siteNotice">' +
            '</div>' +
            '<a href="#" data-id="' + slug + '" class="show-building"><img src="' + thumb +
            '" class="marker-thumb" width="200"></a></div>' +
            {{-- '<a href="#" data-id="'+slug+'" class="show-building"><img src="'+thumb+'" class="marker-thumb" width="200">{{ $lang == 'ar'  ? 'اضغط للعرض ' : 'Click to view' }} '+title+'</a></div>' +? --}}
        // "<button>Read More</button>" +
        "" +
        "</div></div>";

        allMarkers[markerid] = new CustomMarker({
            position: pos,
            color: color,
            category: category,
            markerid: markerid,
            year: year,
            map: map,
        });

        // google.maps.event.addListener(allMarkers[markerid], 'click', function(e) {
        //     allMarkers[markerid].Focus();
        // });

        gmarkers1.push(allMarkers[markerid]);

        infowindow[markerid] = new google.maps.InfoWindow({
            content: contentString,
            disableAutoPan: false
        });

        infowindow[markerid].addListener('closeclick', () => {
            removeAllFocus();
        });

        allMarkers[markerid].addListener("click", (e) => {
            getCaseStudy(markerid);
            //
            // if(openWindow){
            //     openWindow.close();
            // }
            //
            // infowindow[markerid].open({
            //     anchor: allMarkers[markerid],
            //     map,
            //     shouldFocus: false,
            // });
            //
            // openWindow = infowindow[markerid];
        });

        markerIds++;
    }

    function resizeMap() {
        setTimeout(function() {
            $('#map-canvas').css('height', $(window).height() - $('#header').outerHeight());
            $('#map-wrap').css('height', $('#map-canvas').height());
            $('#timeline').css('height', $('#map-canvas').height());
            $('#pages').css('height', $('#map-canvas').height());

            @if ($lang == 'ar')
                $('#timeline.active').css('left', $('#bottommenu').offset().left + 'px');
            @else
                $('#timeline.active').css('left', $('#bottommenu').offset().left + $('#bottommenu')
                .outerWidth() + 'px');
            @endif

            boxWidth = 0;
            counts = 1;

            if ($(window).width() > 1100) {
                $('#boxlinks li').each(function() {
                    if (counts < $('#boxlinks li').length)
                        boxWidth += $(this).width();
                    counts++;
                });

                // $('.catdetail').css('width',boxWidth);

                @if ($lang == 'ar')
                    $('.catdetail').css('left', $('#boxlinks li').eq($('#boxlinks li').length - 2).offset()
                        .left);
                @else
                    $('.catdetail').css('left', ($('#boxlinks li').eq($('#boxlinks li').length - 1).offset()
                        .left) - $('.catdetail').outerWidth());
                @endif

            } else if ($(window).width() <= 1100 && $(window).width() > 640) {

                boxWidth = $('#boxlinks').width();

                $('.catdetail').css('width', boxWidth);
                // $('#intropop').css('width',boxWidth);

                $('.catdetail').css('left', $('#boxlinks').offset().left);
                // $('#intropop').css('left',$('#boxlinks').offset().left);

            } else {
                boxWidth = $('#logo').outerWidth();
                console.log(boxWidth);
                $('.catdetail').css('width', boxWidth);
                // $('#intropop').css('width',boxWidth);

                $('.catdetail').css('left', $('#logo').first().offset().left);
                // $('#intropop').css('left',$('#logo').first().offset().left);
            }

            // $('.catdetail.active').css('bottom',($(window).height() - ($('#timeline li').last().offset().top + $('#timelineSelect li').last().outerHeight())));
        }, 300);
    }
    resizeMap();

    function alignIntroPop() {

        if ($(window).width() > 1100) {
            @if ($lang == 'ar')
                $('#intropop').css('right', ($(window).width() - ($('#bottommenu').outerWidth() + $('#bottommenu')
                    .offset().left)) + 'px');
                $('.pagepop').css('right', ($(window).width() - ($('#bottommenu').outerWidth() + $('#bottommenu')
                    .offset().left)) + 'px');
            @else
                $('#intropop').css('left', $('#bottommenu').offset().left + 'px');
                $('.pagepop').css('left', $('#bottommenu').offset().left + 'px');
            @endif
        } else {
            $('#intropop').css('right', 'auto');
            $('.pagepop').css('right', 'auto');
        }
    }
    alignIntroPop();

    function alignCatPop() {

        if ($(window).width() > 1100) {
            @if ($lang == 'ar')
                $('#catpop.active').css('right', ($(window).width() - ($('#bottommenu').offset().left + $('#bottommenu')
                    .outerWidth())) + 'px');
            @else
                $('#catpop.active').css('left', $('#bottommenu').offset().left + 'px');
            @endif
        } else {
            @if ($lang == 'ar')
                $('#catpop.active').css('right', '0');
            @else
                $('#catpop.active').css('left', $('#bottommenu').offset().left + 'px');
            @endif
        }
    }
    alignCatPop();

    // $('.audiofy').on('click',function(){
    //     var msg = new SpeechSynthesisUtterance($(this).text());
    //     window.speechSynthesis.speak(msg);
    // });
</script>
<script src="{{ asset('public/js/research.js?v=3.1') }}"></script>









</body>

</html>
