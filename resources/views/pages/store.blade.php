<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}" />
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="SAT Talks || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}">
    <meta itemprop="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta itemprop="image" content="{{ asset('public/' . $post->slider->square->url) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="http://sharjaharchitecture.org/og.JPG">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title"
        content="Design Store: Re-store Collection || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}">
    <meta name="twitter:description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta name="twitter:creator" content="@author_handle">
    <!-- Twitter summary card with large image must be at least 280x150px -->
    <meta name="twitter:image:src" content="{{ asset('public/' . $post->slider->square->url) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="Design Store: Re-store Collection || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('pages/stores/' . $post->slug) }}" />
    <meta property="og:image" content="{{ asset('public/' . $post->slider->square->url) }}" />
    <meta property="og:description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}" />
    <meta property="og:site_name" content="Sharjah Architecture Triennial" />
    <meta property="article:published_time" content="2018-10-28T05:59:00+01:00" />
    <meta property="article:modified_time" content="2018-010-28T19:08:47+01:00" />
    <meta property="article:section" content="Homepage" />
    <meta property="article:tag" content="SAT" />

    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js"
            integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>

    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">

    <title>Design Store: Re-store Collection || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700&amp;subset=arabic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lateef&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="{{ asset('public/fonts/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fonts/roboto/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style2.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
    <style>
        .column-box img {
            border: 3px solid #000;
          }

        .figure-list li 1.en, .figure-list li .title.ar {
            overflow: hidden;
        }

        #menu ul li ul li {
            padding: 7px 0;
        }

        .innerpage .contents .text-left span, .innerpage .contents .text-left p, .innerpage .contents .text-left {
            font-size: 16px !important;
            font-family: 'Roboto' !important;
            font-weight: normal;
            margin-bottom: 0 !IMPORTANT;
            line-height: 20px !IMPORTANT;
            /* text-align: left !important; */
        }

        .figure-list {
            font-size: 16px;
        }

        .innerpage .text-right span {
            display: -webkit-inline-box;
        }

        .innerpage .contents .text-right p, .innerpage .contents .text-right , .innerpage .contents .text-right div, .innerpage .contents .text-right div span {
            font-family: Cairo !IMPORTANT;
        }
    </style>


    <!-- Include Amplitude JS Visualizations -->
    <script type="text/javascript" src="https://521dimensions.com/img/open-source/amplitudejs/visualizations/michaelbromley.js"></script>
    <style>
        .innerpage .socials {
            padding: 0 !important;
            width: 100%;
        }
        .innerpage .socials li {
            list-style: none !important;
            display: block !important;
            float: left;
            width: 33%;
        }
        .innerpage .socials li a {
            display: inline-block !important;
            width: 28px;
            height: 28px;
            background-size: 100% auto;
        }

        .innerpage .socials li:last-of-type a {
            margin: 0;
        }

        /*
          1. Base
        */
        /*
          2. Components
        */
        div.control-container {
            margin-top: 10px;
            padding: 20px 10px;
            border: 3px solid #000;
        }
        div.control-container div.amplitude-play-pause {
            width: 74px;
            height: 74px;
            cursor: pointer;
            float: {{ isset($_GET['lang']) ? 'right' : 'left' }};
            margin-left: 10px; }
        div.control-container div.amplitude-play-pause.amplitude-paused {
            background: url("{{ asset('public/img/audio-play.png') }}");
            background-size: cover; }
        div.control-container div.amplitude-play-pause.amplitude-playing {
            background: url("{{ asset('public/img/audio-pause.png') }}");
            background-size: cover; }
        div.control-container div.meta-container {
            float: {{ isset($_GET['lang']) ? 'right' : 'left' }};
            width: calc(70%);
            text-align: center;
            color: #000;
            margin-top: 10px;
            margin-{{ isset($_GET['lang']) ? 'right' : 'left' }}: 10px;
        }
        div.control-container div.meta-container span[data-amplitude-song-info="name"] {
            font-size: 18px !important;
            color: #000;
            display: block;
            font-weight: bold;
        }
        div.control-container div.meta-container span[data-amplitude-song-info="artist"] {
            font-weight: 400;
            font-size: 14px;
            color: #000;
            display: block; }
        div.control-container:after {
            content: "";
            display: table;
            clear: both; }

        /*
          Small only
        */
        @media screen and (max-width: 39.9375em) {
            div.control-container div.amplitude-play-pause {
                background-size: cover;
                width: 64px;
                height: 64px; }
            div.control-container div.meta-container {
                width: calc(95% - 74px); }
        }

        #mobile-other-links {
            display: none;
        }

        #mobile-other-links a {
            float: left;
        }

        @media screen and (max-width: 767px) {
            #mobile-other-links {
                display: block;
            }

            #mobile-other-links a {
                width: 100%;
                display: block;
                height: 40px;
            }

            #mobile-other-links svg {
                margin-left: 0 !important;
            }

            #desk-other-links {
                display: none;
            }
        }
        /*
          Medium only
        */
        /*
          Large Only
        */
        div.time-container {
            opacity: 0.5;
            font-family: 'Open Sans';
            font-weight: 100;
            font-size: 12px;
            color: #000;
            height: 15px; }
        div.time-container span.current-time {
            float: left;
            margin-left: 5px; }
        div.time-container span.duration {
            float: right;
            margin-right: 5px; }

        /*
          Small only
        */
        /*
          Medium only
        */
        /*
          Large Only
        */
        progress.amplitude-song-played-progress {
            background-color: #313252;
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 30px;
            display: block;
            cursor: pointer;
            border: 3px solid #000;
            margin-top: 20px;
        }
        progress.amplitude-song-played-progress:not([value]) {
            background-color: #dfdfdf; }

        progress[value]::-webkit-progress-bar {
            background-color: #DFDFDF; }

        progress[value]::-moz-progress-bar {
            background-color: #00ed00; }

        progress[value]::-webkit-progress-value {
            background-color: #00ed00; }

        /*
          Small only
        */
        /*
          Medium only
        */
        /*
          Large Only
        */
        /*
          3. Layout
        */
        div.bottom-container {
            background-color: #ffffff;
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        /*
          Small only
        */
        /*
          Medium only
        */
        /*
          Large Only
        */
        div#single-song-player {
            margin: auto;
            width: 100%;
            max-width: 100%;
            -webkit-font-smoothing: antialiased;
        }
        div#single-song-player img[data-amplitude-song-info="cover_art_url"] {
            width: 100%;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            display: none;
        }
        .owl-carousel-holder {
            width: 100%;
        }

        @if (isset($_GET['lang']))
            .imgcap .en {
                display: none !important;
            }
            .innerpage .socials li {
                float: right;
            }
        @else
            .imgcap .ar {
                display: none !important;
            }
        @endif


        .sideb {
            padding-left: 3em;
            padding-right: 3em;
        }

        @media only screen and (max-width: 991px) {
            .sideb {
                padding-left: 12px;
                padding-right: 12px;
            }
        }

        .publish_date {
            font-size: 12px;
            font-weight: normal;
            color: #969696;
            font-style: italic;
            margin-top: 10px;
        }

        .current img {
            filter: grayscale(100%);
        }
        .owl-carousel-holder .arrows .prev {
            left: -80px;
            position: absolute;
            background-image: url({{ asset('public/img/store-arrow-left.png') }});
        }

        .owl-carousel-holder .arrows .next {
            right: -80px;
            position: absolute;
            background-image: url({{ asset('public/img/store-arrow-right.png') }});
        }

        .column-box .ar {
            font-family: 'Tahoma' !important;
        }
        .publish_date {
            font-size: 12px;
            font-weight: normal;
            color:#969696;
            font-style: italic;
            margin-top: 10px;
        }
        .column-box {
            line-height: 22px;
            max-height: 480px;
            height: 380px;
            overflow: hidden;
        }
        @media only screen and (min-width: 1520px){
            .column-box {
                height: 460px;
            }
        }
        @media only screen and (max-width: 1120px){

            .owl-carousel-holder .arrows .prev {
                left: 30px;
            }

            .owl-carousel-holder .arrows .next {
                right: 30px;
            }
        }
    </style>
</head>

<body>

<header class="clearfix">
    <div class="container-fluid dark min" id="header">
        <div class="row">
        </div>
    </div>
</header>
<header class="clearfix">
    <div class="container-fluid dark min floating" id="floating-header">
        <div class="container" style="position: relative">
            <div class="row">
                <a href="{{ url('/') }}/" class="logo-link">
                    <div id="logo" class="clearfix">
                        <img src="{{ asset('public/img/svg/ar-1.svg') }}" class="ar1">
                        <img src="{{ asset('public/img/svg/ar-2.svg') }}" class="ar2">
                        <img src="{{ asset('public/img/svg/ar-3.svg') }}" class="ar3">
                        <img src="{{ asset('public/img/svg/en-1.svg') }}" class="en1">
                        <img src="{{ asset('public/img/svg/en-2.svg') }}" class="en2">
                        <img src="{{ asset('public/img/svg/en-3.svg') }}" class="en3">
                    </div>
                </a>
                <div class="buttons">
                    <a href="#" class="menu-icon menu-click dark" id="menu-bt"></a>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="print-logo">
    <div class="container">
        <img src="{{ asset('public') }}/img/svg/SAT-LOGO.svg" width="200">
        <span style="float:right; text-align: right;">
				Sharjah Architecture Triennal Website <br/>
            {{ \Carbon\Carbon::now()->format('F d, Y') }} <br/>
				http://sharjaharchitecture.org
			</span>
    </div>
</div>

<main role="main" class="container main" id="menu">
    <div class="row">
        <div class="container">
            <div class="row">
                <a href="#" id="main-logo"></a>
                <div class="buttons">
                    <a href="#" class="menu-icon menu-close-click" id="menu-bt-close"></a>
                    <a href="#" class="menu-icon search-click" id="search-bt"></a>
                    <form action="{{ url('search') }}" method="post">
                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                        <input type="text" id="search" name="keyword">
                        <input type="submit" value="" id="search-submit">
                    </form>
                </div>
                <div class="menu-holder auto-height">
                    <div class="headline auto-height-holder">
                        @include('menu-desktop')
                        @include('menu-mobile')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="rtl">
                    <div class="col-md-12 {{ isset($_GET['lang']) ? 'text-right' : 'text-left' }}">
                        <div class="breadcrumbs">
                            @if (isset($_GET['lang']))
                                <div class="breadcrumbs ar" style="height: 20px;">
                                    <a href="{{ url('/?lang=ar') }}" style="color: rgb(0, 0, 0);">الصفحة الرئيسية</a>
                                    &gt;
                                    <a href="{{ url('pages/programmes') }}" style="color: rgb(0, 0, 0);"> البرامج</a>
                                    &gt;
                                    <a href="{{ url('pages/programmes/sat-design-store?lang=ar') }}" style="color: rgb(0, 0, 0);">{{ $page->name_ar }}</a>
                                </div>
                            @else
                                <div class="breadcrumbs en" style="height: 20px;">
                                    <a href="{{ url('/') }}" style="color: rgb(0, 0, 0);">Home</a>
                                    &gt;
                                    <a href="{{ url('pages/programmes') }}" style="color: rgb(0, 0, 0);">Programmes</a>
                                    &gt;
                                    <a href="{{ url('pages/programmes/sat-design-store') }}" style="color: rgb(0, 0, 0);">{{ $page->name }}</a>
                                </div>
                            @endif
                        </div>


                        <div class="row">
                            <div class="col-md-9">
                                <a href="/pages/programmes/sat-design-store">
                                <h1>{!! isset($_GET['lang'])
                                    ? 'SAT Design Store:' . $collectionCategory->name_ar
                                    : 'SAT Design Store: ' . $collectionCategory->name !!}</h1>
                            </a>
                            </div>

                            <div class="col-md-3 sideb">
                                @if (isset($_GET['lang']))
                                    <a href="{{ url()->current() }}">Switch to English
                                    </a><br/>
                                    <br/>
                                @else
                                    <a href="{{ url()->current() . '?lang=ar' }}" class="float-right">التبديل إلى اللغة العربية</a>
                                    <br/>
                                    <br/>
                                @endif
                            </div>

                        </div>

                        <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                            <?php $page = $post; ?>
                                    @if ($page->sliders && $page->sliders->count() == 1)
                                        <div class="col-md-12">
                                            @if ($page->slider->square)
                                                <img src="{{ asset('public/' . $page->slider->square->url) }}" width="100%" class="featured-img">
                                                <span class="imgcap">
                                                    @if (isset($_GET['lang']))
                                                        <span dir="rtl" class="float-right">{{ $page->slider->square->caption_ar }}</span>
                                                    @else
                                                        <span class="en float-left">{{ $page->slider->square->caption }}</span>
                                                    @endif
                                                </span>
                                            @elseif($page->slider->landscape)
                                                <img src="{{ asset('public/' . $page->slider->landscape->url) }}" width="100%" class="featured-img">
                                                <span class="imgcap">
                                                    @if (isset($_GET['lang']))
                                                        <span dir="rtl" class="float-right">{{ $page->slider->landscape->caption_ar }}</span>
                                                    @else
                                                        <span class="en float-left">{{ $page->slider->landscape->caption }}</span>
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    @elseif($page->sliders && $page->sliders->count() > 1)
                                        <div class="col-md-12">
                                            <div class="owl-carousel-holder" dir="ltr">
                                                <div class="arrows">
                                                    <button class="prev float-left"></button>
                                                    <button class="next float-right"></button>
                                                </div>
                                                <div class="owl-carousel owl-theme">
                                                    @foreach ($page->sliders as $slide)
                                                        <div class="item">
                                                            <img src="{{ url('public/' . $slide->square->url) }}" data-en="{{ $slide->square->caption }}" data-ar="{{ $slide->square->caption_ar }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div id="owl-caption"></div>
                                                <div id="owl-dots"></div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-12">
                                        <h5 style="color: #909090; font-weight: 300; font-size: 14px;">{!! isset($_GET['lang']) ? $post->artist_ar : $post->artist !!}</h5>
                                        <h3 class="mb-4">{!! isset($_GET['lang']) ? $post->title_ar : $post->title !!}</h3>
                                    </div>

                                    {{-- <div class="col-md-12"> --}}
                                        {{-- <h5 class="ar">{!! isset($_GET['lang']) ? $post->speaker_ar : $post->speaker !!}</h5> --}}
                                        {{-- <h5 class="ar">{!! isset($_GET['lang']) ? $post->series_ar : $post->series !!}</h5> --}}
                                        {{-- <br/> --}}
                                    {{-- </div> --}}

                                    @if (isset($_GET['lang']))
                                    @if ($_GET['lang'] == 'ar')
                                            <div class="col-md-12 text-right">
                                                {!! $page->content_ar !!}
                                                <br>
                                                <br>
                                            </div>
                                            @endif
                                            @else
                                        <div class="col-md-12 text-left">
                                            {!! $page->content !!}
                                            <br>
                                            <br>
                                        </div>
                                  @endif



                        @if ($formdata)
                            <div class="container text-center">
                                <div class="body-section contents">
                                    @include('partials.form')
                                </div>
                            </div>
                        @endif

                        @if ($post->buttonLinks)
                            <div class="container text-center">
                                <div class="body-section contents">
                                    <div class="row" dir="rtl">
                                        <div class="col-md-6 text-right">
                                            @if ($post->buttonLinks->title && $post->buttonLinks->value)
                                                <a href="{{ $post->buttonLinks->value_ar }}"><input type="submit" class="ar" value="{{ $post->buttonLinks->title_ar }}"></a>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-left">
                                            @if ($post->buttonLinks->title && $post->buttonLinks->value)
                                                <a href="{{ $post->buttonLinks->value }}"><input type="submit" class="en" value="{{ $post->buttonLinks->title }}"></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                

                        <div class="container text-center">
                        <br/>
                        <br/>
                        <h3 style="font-weight:bold; text-align: {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? 'right' : 'left' }}">
                            {{ isset($_GET['lang']) && $_GET['lang'] == 'ar' ? $collectionCategory->name_ar : $collectionCategory->name }}
                        </h3>                        <br/>
                        <div class="row" >
                            @foreach ($similar as $item)
                       
                                @if ($_GET['lang'] == 'ar')
                                    <div class="col-md-4 col-sm-6 text-right column-box {{ $item->id == $post->id ? 'current' : '' }}" style="margin-bottom: 15px !important;">
                                        @else
                                            <div class="col-md-4 col-sm-6 text-left column-box {{ $item->id == $post->id ? 'current' : '' }}" style="margin-bottom: 15px !important;;">
                                                @endif

                                                    @if ($item->id != $post->id)
                                                            @if (isset($_GET['lang']))
                                                                    @if ($_GET['lang'] == 'ar')
                                                                        <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"  {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                                                                    @endif
                                                            @else
                                                                <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"  {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!}  {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                                                            @endif
                                                    @endif

                                                                    @if ($item->sliders->count() > 0 && $item->sliders[0]->landscape)
                                                                        <img src="{{ asset('public/' . $item->sliders[0]->landscape->url) }}" width="100%">
                                                                    @else
                                                                        <img src="{{ asset('public/img/placeholder-square.jpg') }}" width="100%">
                                                                    @endif
                                                                </a>
                                                                    @if (isset($_GET['lang']))
                                                                        @if ($_GET['lang'] == 'ar')


                                                                        <?php $series = str_replace(' ', '-', $item->artist); ?>
                                                                        <a href="/pages/about/contributors/{{ $series }}">
                                                                                

                                                                            <div class="publish_date en">{{ $item->artist_ar }}</div>


                                                                        </a>



                                                                            {{-- <div class="publication ar">{{ $item->country_ar }}</div> --}}

                                                                            <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"  {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>


                                                                            <div class="title ar">{{ $item->title_ar }}</div>
                                                                            </a>

                                                                            {{-- <div class="author ar">{{ $item->speaker_ar }}</div> --}}
                                                                            {{--                                    <div class="content ar">{{ $item->excerpt_ar }}</div> --}}
                                                                        @endif
                                                                    @else
                                                                    <?php $series = str_replace(' ', '-', $item->artist); ?>
                                                                    <a href="/pages/about/contributors/{{ $series }}">
                                                                            
                                                                        <div class="publish_date en">{{ $item->artist }}</div>

                                                                    </a>
                                                                        {{-- <div class="publication en">{{ $item->country }}</div> --}}

                                                                        <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"  {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>

                                                                        <div class="title en">{{ $item->title }}</div>
                                                                        </a>

                                                                        {{-- <div class="author en">{{ $item->speaker }}</div> --}}
                                                                        {{--                                <div class="content en">{{ $item->excerpt }}</div> --}}
                                                                    @endif
                                                    @if ($item->id != $post->id)
                                                        </a>
                                                    @endif
                                               

                                            </div>
                                            @endforeach

                                    </div>

                                    <br/>

                                    @if (isset($upcoming) && count($upcoming) > 0)
                                        <div class="<?php echo isset($_GET['lang']) ? 'text-right' : 'text-left'; ?>" <?php echo isset($_GET['lang']) ? 'dir="rtl"' : ''; ?>>
                                            <h3 style="font-weight:bold;text-align: <?php echo isset($_GET['lang']) ? 'right' : 'left'; ?>"><?php echo isset($_GET['lang']) ? 'الفعاليات القادمة' : 'UPCOMING EVENTS'; ?> </h3>
                                            <br/>
                                            <div style="text-align: <?php echo isset($_GET['lang']) ? 'right' : 'left'; ?>">
                                                @foreach ($upcoming as $item)

                                                    @if (isset($_GET['lang']))
                                                        @if ($_GET['lang'] == 'ar')
                                                            <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"  {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                                                                @endif
                                                                @else
                                                                    <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"  {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!}  {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                                                                        @endif
                                                                    </a>

                                                                    @if (isset($_GET['lang']))
                                                                        @if ($_GET['lang'] == 'ar')
                                                                            <h4  style="font-weight:bold;text-transform: uppercase;">{{ $item->title_ar }}</h4>
                                                                            <p>{{ is_string($item->publish_date) ? \Carbon\Carbon::parse($item->publish_date)->format('d-m-Y') : $item->publish_date->format('d-m-Y') }}</p>
                                                                            <p>{{ $item->excerpt }}</p>
                                                                        @else
                                                                            <h4  style="font-weight:bold;text-transform: uppercase;">{{ $item->title }}</h4>
                                                                            <p>{{ is_string($item->publish_date) ? \Carbon\Carbon::parse($item->publish_date)->format('d-m-Y') : $item->publish_date->format('d-m-Y') }}</p>
                                                                            <p>{{ $item->excerpt_ar }}</p>
                                                                        @endif
                                                                    @endif

                                                                    @if (isset($_GET['lang']))
                                                                        @if ($_GET['lang'] == 'ar')
                                                                            <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"  {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                                                                                @endif
                                                                                @else
                                                                                    <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"  {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!}  {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                                                                                        @endif
                                                                                        <br/>

                                                                                        {{ isset($_GET['lang']) ? 'اقرأ أكثر' : 'READ MORE' }}</a>
                                                                                    <hr/>
                                                            @endforeach
                                            </div>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>

    @include('footer')
    @include('search')
    @include('subscribe')

        <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('public/js/jquery-3.3.1.min.js') }}"></script>
    <!--- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('public/js/main.js') }}"></script>
    <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';fnames[5]='MMERGE5';ftypes[5]='text';fnames[6]='MMERGE6';ftypes[6]='dropdown';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
    <!--End mc_embed_signup-->

    @if (\Request::path() == '/')
        <script src="{{ asset('public/js/home.js') }}"></script>
    @else
        <script src="{{ asset('public/js/inner.js') }}"></script> @endif

    <script>
        var owl = $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            items: 1,
            dotsContainer: '#owl-dots',
            onChange: function(elem) {
                setTimeout(function() {
                    html = '<span class="imgcap"><span class="en float-left">' + $(
                            '.owl-item.active img').attr('data-en') +
                        '</span><span dir="rtl" class="ar float-right">' + $('.owl-item.active img')
                        .attr('data-ar') + '</span></span>';
                    $('#owl-caption').html(html);
                }, 300);
            },
            onInitialize: function(elem) {
                setTimeout(function() {
                    html = '<span class="imgcap"><span class="en float-left">' + $(
                            '.owl-item.active img').attr('data-en') +
                        '</span><span dir="rtl" class="ar float-right">' + $('.owl-item.active img')
                        .attr('data-ar') + '</span></span>';
                    $('#owl-caption').html(html);
                }, 500);
            }
        });

        $('.owl-carousel-holder .arrows .next').click(function() {
            owl.trigger('next.owl.carousel');
        });
        // Go to the previous item
        $('.owl-carousel-holder .arrows .prev').click(function() {
            // With optional speed parameter
            // Parameters has to be in square bracket '[]'
            owl.trigger('prev.owl.carousel');
        });
    </script>

</body>
</html>
