<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}" />
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="SAT Talks || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}">
    <meta itemprop="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta itemprop="image" content="{{asset('public/'.$post->slider->square->url)}}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="http://sharjaharchitecture.org/og.JPG">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="SAT Talks || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}">
    <meta name="twitter:description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta name="twitter:creator" content="@author_handle">
    <!-- Twitter summary card with large image must be at least 280x150px -->
    <meta name="twitter:image:src" content="{{asset('public/'.$post->slider->square->url)}}">

    <!-- Open Graph data -->
    <meta property="og:title" content="SAT Talks || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('pages/podcasts/'.$post->slug) }}" />
    <meta property="og:image" content="{{asset('public/'.$post->slider->square->url)}}" />
    <meta property="og:description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}" />
    <meta property="og:site_name" content="Site Name, i.e. Moz" />
    <meta property="article:published_time" content="2018-10-28T05:59:00+01:00" />
    <meta property="article:modified_time" content="2018-010-28T19:08:47+01:00" />
    <meta property="article:section" content="Homepage" />
    <meta property="article:tag" content="SAT" />

    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js"
            integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>

    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">

    <title>SAT Talks || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}</title>
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
        .figure-list li .title.en, .figure-list li .title.ar {
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
            text-align: left !important;
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

        @if(isset($_GET['lang']))
            .imgcap .en {
                display: none !important;
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
                            @if(isset($_GET['lang']))
                                <div class="breadcrumbs ar" style="height: 20px;">
                                    <a href="{{ url('/') }}" style="color: rgb(0, 0, 0);">الصفحة الرئيسية</a>
                                    &gt;
                                    <a href="{{ url('pages/programmes') }}" style="color: rgb(0, 0, 0);"> البرامج</a>
                                    &gt;
                                    <a href="{{ url('pages/programmes/sat-talks-architecture?lang=ar') }}" style="color: rgb(0, 0, 0);">عمارة وأكثر</a>
                                </div>
                            @else
                                <div class="breadcrumbs en" style="height: 20px;">
                                    <a href="{{ url('/') }}" style="color: rgb(0, 0, 0);">Home</a>
                                    &gt;
                                    <a href="{{ url('pages/programmes') }}" style="color: rgb(0, 0, 0);">Programmes</a>
                                    &gt;
                                    <a href="{{ url('pages/programmes/sat-talks-architecture') }}" style="color: rgb(0, 0, 0);">sat-talks-architecture</a>
                                </div>
                            @endif
                        </div>


                        <div class="row">
                            <div class="col-md-9">
                                <h1>{!! isset($_GET['lang']) ? $post->speaker_ar : $post->speaker !!}</h1>
                            </div>

                            <div class="col-md-3 sideb">
                                @if(isset($_GET['lang']))
                                    <a href="{{url()->current()}}">Switch to English
                                    </a><br/>
                                    <br/>
                                @else
                                    <a href="{{url()->current().'?lang=ar'}}" class="float-right">التبديل إلى اللغة العربية</a>
                                    <br/>
                                    <br/>
                                @endif
                            </div>

                        </div>

                        <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                            <?php $page = $post; ?>
                                    @if(count($page->sliders)==1)
                                        <div class="col-md-12">
                                            @if($page->slider->square)
                                                <img src="{{ asset('public/'.$page->slider->square->url) }}" width="100%" class="featured-img">
                                                <span class="imgcap">
                                                    @if(isset($_GET['lang']))
                                                        <span dir="rtl" class="float-right">{{ $page->slider->square->caption_ar }}</span>
                                                    @else
                                                        <span class="en float-left">{{ $page->slider->square->caption }}</span>
                                                    @endif
                                                </span>
                                            @elseif($page->slider->landscape)
                                                <img src="{{ asset('public/'.$page->slider->landscape->url) }}" width="100%" class="featured-img">
                                                <span class="imgcap">
                                                    @if(isset($_GET['lang']))
                                                        <span dir="rtl" class="float-right">{{ $page->slider->landscape->caption_ar }}</span>
                                                    @else
                                                        <span class="en float-left">{{ $page->slider->landscape->caption }}</span>
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    @elseif(count($page->sliders)>1)
                                        <div class="col-md-12">
                                            <div class="owl-carousel-holder" dir="ltr">
                                                <div class="arrows">
                                                    <button class="prev float-left"></button>
                                                    <button class="next float-right"></button>
                                                </div>
                                                <div class="owl-carousel owl-theme">
                                                    @foreach($page->sliders as $slide)
                                                        <div class="item">
                                                            <img src="{{ url('public/'.$slide->square->url) }}" data-en="{{ $slide->square->caption }}" data-ar="{{ $slide->square->caption_ar }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div id="owl-caption"></div>
                                                <div id="owl-dots"></div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-12">
                                        <hr/>
                                        <div id="single-song-player">
                                            <img data-amplitude-song-info="cover_art_url"/>
                                            <div class="bottom-container">

                                                <div class="time-container">
                                                  <span class="current-time">
                                                    <span class="amplitude-current-minutes"></span>:<span class="amplitude-current-seconds"></span>
                                                  </span>
                                                    <span class="duration">
                                                    <span class="amplitude-duration-minutes"></span>:<span class="amplitude-duration-seconds"></span>
                                                  </span>
                                                </div>

                                                <div class="control-container">
                                                    <div class="amplitude-play-pause" id="play-pause"></div>
                                                    <div class="meta-container">
                                                        <span data-amplitude-song-info="name" class="song-name"></span>
                                                        <span data-amplitude-song-info="artist"></span>
                                                    </div>
                                                </div>

                                                <progress class="amplitude-song-played-progress" id="song-played-progress"></progress>



                                                <div id="mobile-other-links" class="clearfix">
                                                    @if(isset($_GET['lang']))
                                                        <br/><br/><b>طرق أكثر للاستماع</b><br/><br/>
                                                    @else
                                                        <br/><br/><b>MORE WAYS TO LISTEN</b><br/><br/>
                                                    @endif
                                                @if($page->links->soundcloud_url)
                                                    <a href="{{$page->links->soundcloud_url}}" target="_blank"><svg style="{{ isset($_GET['lang']) ? 'float: right; margin-left:10px;' : 'float: left;' }} display: block" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="25px" id="Layer_1" version="1.1" viewBox="0 0 100 100" width="25px" xml:space="preserve"><defs><path id="SVGID_1_" d="M0 0h100v100H0z"/></defs><path d="M5 59.023c0 3.044 1.385 5.764 3.568 7.598V51.43C6.385 53.259 5 55.982 5 59.023m7.342-9.591v19.183c.891.246 1.832.385 2.801.385h.974V49.094a10.365 10.365 0 0 0-3.775.338m8.336 1.245a9.632 9.632 0 0 0-.789-.457V69h3.773V43.881a15.49 15.49 0 0 0-2.984 6.796m6.759-10.328V69h3.774V38.491a16.044 16.044 0 0 0-3.774 1.858m7.547-2.639V69h3.774V37.825a16.18 16.18 0 0 0-3.774-.115m9.628 2.206a16.068 16.068 0 0 0-3.966-1.69V69h5.66V37.646a19.432 19.432 0 0 0-1.694 2.27m3.583-4.162V69h35.852v-.044C91.596 68.473 95 63.79 95 58.075c0-6.035-4.562-10.925-10.703-10.925-1.576 0-2.874.325-4.245.913C79.069 38.481 70.941 31 60.932 31c-4.896 0-9.346 1.793-12.737 4.754"/><metadata><rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#" xmlns:dc="http://purl.org/dc/elements/1.1/"><rdf:Description about="https://iconscout.com/legal#licenses" dc:title="soundcloud" dc:description="soundcloud" dc:publisher="Iconscout" dc:date="2017-09-19" dc:format="image/svg+xml" dc:language="en"><dc:creator><rdf:Bag><rdf:li></rdf:li></rdf:Bag></dc:creator></rdf:Description></rdf:RDF></metadata></svg>
                                                        <span style="    display: block;
                                                        {{ isset($_GET['lang']) ? 'float: right;' : 'float: left;' }}
                                                                height: 25px;
                                                                line-height: 28px !important;
                                                                margin-left: 10px;">SoundCloud</span></a>
                                                @endif
                                                @if($page->links->apple_url)
                                                    <a href="{{$page->links->apple_url}}" target="_blank">
                                                        <svg  style="{{ isset($_GET['lang']) ? 'float: right; margin-left:30px;' : 'float: left;margin-left:30px;' }} display: block" width="25" height="25" viewBox="0 0 18 20" class="podcast__meta-icon__svg podcast__section-icon__svg inline-apple-podcasts__svg inline-journalism/audio__svg">
                                                            <g fill="#000">
                                                                <path d="M11.84 17.624c.027-.282.066-.522.07-.763.006-.38.223-.543.54-.705 2.289-1.172 3.742-3.018 4.25-5.56.489-2.453-.091-4.672-1.666-6.596-1.241-1.515-2.85-2.442-4.793-2.744-2.364-.366-4.48.23-6.3 1.77-1.477 1.25-2.4 2.851-2.69 4.788-.366 2.435.261 4.585 1.85 6.457a7.615 7.615 0 0 0 2.497 1.915c.272.133.49.252.475.608-.009.204.055.41.08.617.022.18-.05.215-.217.153a8.877 8.877 0 0 1-2.486-1.392C1.783 14.84.7 13.128.228 11.037a8.801 8.801 0 0 1-.143-3.133c.215-1.613.8-3.062 1.789-4.346C3.181 1.861 4.873.76 6.95.252A8.436 8.436 0 0 1 9.94.053c1.74.202 3.308.837 4.678 1.948 1.639 1.331 2.71 3.03 3.155 5.093.575 2.667.047 5.127-1.55 7.336-1.077 1.492-2.507 2.526-4.228 3.155-.021.01-.045.014-.155.04z"></path>
                                                                <path d="M6.809 13.403c0-.243-.024-.489.005-.728.056-.463.321-.787.72-1.017a2.778 2.778 0 0 1 1.375-.36c.632-.01 1.23.107 1.756.498.35.26.515.608.532 1.026.039 1.006-.047 2.003-.19 2.996-.132.913-.268 1.824-.408 2.736-.088.575-.319 1.047-.918 1.241-.655.213-1.275.159-1.834-.266-.292-.22-.378-.566-.435-.9-.15-.9-.293-1.802-.407-2.709-.106-.835-.17-1.676-.25-2.515l.054-.002z"></path>
                                                                <path d="M15.025 9.006c-.047 2.097-.873 3.729-2.484 4.956-.072.055-.171.072-.258.106-.011-.087-.022-.174-.035-.261-.105-.7.15-1.223.617-1.761.785-.904 1.095-2.034 1.029-3.23a4.935 4.935 0 0 0-4.039-4.598c-2.615-.47-5.1 1.267-5.636 3.835-.359 1.725.138 3.231 1.341 4.5.145.15.212.295.2.506-.014.266.018.535.02.803a.84.84 0 0 1-.05.205c-.065-.021-.14-.029-.194-.067-1.313-.943-2.136-2.208-2.436-3.805-.319-1.717.022-3.303 1.057-4.707 1.008-1.37 2.357-2.197 4.05-2.42 1.691-.223 3.21.196 4.538 1.258 1.239.989 1.983 2.284 2.203 3.869.043.288.056.58.077.81z"></path>
                                                                <path d="M9.008 6.236c.555-.01 1.09.207 1.482.602.391.395.606.933.595 1.491-.01 1.255-.988 2.102-2.118 2.084-1.113-.018-2.053-.865-2.05-2.1a2.057 2.057 0 0 1 .606-1.487c.395-.392.931-.605 1.486-.59z"></path>
                                                            </g>
                                                        </svg> <span style="    display: block;
                                                        {{ isset($_GET['lang']) ? 'float: right;' : 'float: left;' }}
                                                                height: 25px;
                                                                line-height: 28px !important;
                                                                margin-left: 10px;">Apple iTunes</span></a>
                                                @endif
                                                @if($page->links->google_url)
                                                    <a href="{{$page->links->google_url}}" target="_blank"><svg style="{{ isset($_GET['lang']) ? 'float: right;margin-left:30px;' : 'margin-left: 30px;float: left;' }} display: block" width="25" height="25" viewBox="0 0 17 17" class="podcast__meta-icon__svg podcast__section-icon__svg inline-google-podcasts__svg inline-journalism/audio__svg">
                                                            <g style="" fill="#000">
                                                                <path d="M7.299 5.308v6.067h2.085V5.308z"></path>
                                                                <circle cx="1.043" cy="7.773" r="1.043"></circle>
                                                                <circle cx="1.043" cy="8.91" r="1.043"></circle>
                                                                <path d="M0 7.773h2.085V8.91H0z"></path>
                                                                <circle cx="15.64" cy="8.91" r="1.043"></circle>
                                                                <circle cx="15.64" cy="7.773" r="1.043"></circle>
                                                                <path d="M16.683 8.909h-2.085V7.772h2.085z"></path>
                                                                <circle cx="4.645" cy="11.185" r="1.043"></circle>
                                                                <circle cx="4.645" cy="12.323" r="1.043"></circle>
                                                                <path d="M3.602 11.185h2.085v1.137H3.602z"></path>
                                                                <circle cx="4.645" cy="4.36" r="1.043"></circle>
                                                                <circle cx="4.645" cy="8.057" r="1.043"></circle>
                                                                <path d="M3.602 4.36h2.085v3.72H3.602z"></path>
                                                                <circle cx="12.038" cy="5.498" r="1.043"></circle>
                                                                <circle cx="12.038" cy="4.36" r="1.043"></circle>
                                                                <path d="M13.08 5.498h-2.085V4.361h2.085z"></path>
                                                                <circle cx="8.341" cy="2.18" r="1.043"></circle>
                                                                <circle cx="8.341" cy="1.043" r="1.043"></circle>
                                                                <path d="M9.383 2.179H7.298V1.042h2.085z"></path>
                                                                <circle cx="8.341" cy="15.64" r="1.043"></circle>
                                                                <circle cx="8.341" cy="14.503" r="1.043"></circle>
                                                                <path d="M9.383 15.639H7.298v-1.137h2.085z"></path>
                                                                <circle cx="12.038" cy="12.323" r="1.043"></circle>
                                                                <circle cx="12.038" cy="8.626" r="1.043"></circle>
                                                                <path d="M13.08 12.322h-2.085V8.625h2.085z"></path>
                                                                <circle cx="8.341" cy="5.308" r="1.043"></circle>
                                                                <circle cx="8.341" cy="11.375" r="1.043"></circle>
                                                            </g>
                                                        </svg> <span style="    display: block;
                                                        {{ isset($_GET['lang']) ? 'float: right;' : 'float: left;' }}
                                                                height: 25px;
                                                                line-height: 28px !important;
                                                                margin-left: 10px;">Google Podcasts</span></a>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <hr/>
                                        <br/>
                                    </div>

                                    {{--<div class="col-md-12">--}}
                                        {{--<h5 class="ar">{!! isset($_GET['lang']) ? $post->speaker_ar : $post->speaker !!}</h5>--}}
                                        {{--<h5 class="ar">{!! isset($_GET['lang']) ? $post->series_ar : $post->series !!}</h5>--}}
                                        {{--<br/>--}}
                                    {{--</div>--}}

                                    @if(isset($_GET['lang']))
                                        @if($_GET['lang']=='ar')
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



                        @if($formdata)
                            <div class="container text-center">
                                <div class="body-section contents">
                                    @include('partials.form')
                                </div>
                            </div>
                        @endif

                        @if($post->buttonLinks)
                            <div class="container text-center">
                                <div class="body-section contents">
                                    <div class="row" dir="rtl">
                                        <div class="col-md-6 text-right">
                                            @if($post->buttonLinks->title && $post->buttonLinks->value)
                                                <a href="{{$post->buttonLinks->value_ar}}"><input type="submit" class="ar" value="{{ $post->buttonLinks->title_ar }}"></a>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-left">
                                            @if($post->buttonLinks->title && $post->buttonLinks->value)
                                                <a href="{{$post->buttonLinks->value}}"><input type="submit" class="en" value="{{ $post->buttonLinks->title }}"></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                            </div>
                </div>
                <div class="col-md-3 sideb">
                    @include('partials/podcast-sidebar')
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

    @if(\Request::path()=="/")
        <script src="{{ asset('public/js/home.js') }}"></script>
    @else
        <script src="{{ asset('public/js/inner.js') }}"></script>
    @endif

    <script>
        var owl = $('.owl-carousel').owlCarousel({
            loop:true,
            margin:0,
            nav:false,
            items:1,
            dotsContainer:'#owl-dots',
            onChange: function (elem) {
                setTimeout(function(){
                    html = '<span class="imgcap"><span class="en float-left">'+$('.owl-item.active img').attr('data-en')+'</span><span dir="rtl" class="ar float-right">'+$('.owl-item.active img').attr('data-ar')+'</span></span>';
                    $('#owl-caption').html(html);
                },300);
            },
            onInitialize: function (elem) {
                setTimeout(function(){
                    html = '<span class="imgcap"><span class="en float-left">'+$('.owl-item.active img').attr('data-en')+'</span><span dir="rtl" class="ar float-right">'+$('.owl-item.active img').attr('data-ar')+'</span></span>';
                    $('#owl-caption').html(html);
                },500);
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

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@v5.0.3/dist/amplitude.js"></script>
    <script>
        Amplitude.init({
            "bindings": {
                37: 'prev',
                39: 'next',
                32: 'play_pause'
            },
            "songs": [
                {
                    "name": "{{ isset($_GET['lang']) ? $post->title_ar : $post->title }}",
                    "artist": "{{ isset($_GET['lang']) ? $post->speaker_ar : $post->speaker }}",
                    "url": "{{ asset('public/'.$post->audio_file) }}",
                }
            ]
        });

        window.onkeydown = function(e) {
            return !(e.keyCode == 32);
        };

        /*
          Handles a click on the song played progress bar.
        */
        document.getElementById('song-played-progress').addEventListener('click', function( e ){
            var offset = this.getBoundingClientRect();
            var x = e.pageX - offset.left;

            Amplitude.setSongPlayedPercentage( ( parseFloat( x ) / parseFloat( this.offsetWidth) ) * 100 );
        });


    </script>
</body>
</html>



