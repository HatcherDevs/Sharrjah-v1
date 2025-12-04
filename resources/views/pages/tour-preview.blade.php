<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}" />
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Re-materialize || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}">
    <meta itemprop="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta itemprop="image" content="{{asset('public/'.$post->slider->square->url)}}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="http://sharjaharchitecture.org/og.JPG">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="Re-materialize || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}">
    <meta name="twitter:description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta name="twitter:creator" content="@author_handle">
    <!-- Twitter summary card with large image must be at least 280x150px -->
    <meta name="twitter:image:src" content="{{asset('public/'.$post->slider->square->url)}}">

    <!-- Open Graph data -->
    <meta property="og:title" content="Re-materialize || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('pages/re-materialize/'.$post->slug) }}" />
    <meta property="og:image" content="{{asset('public/'.$post->slider->square->url)}}" />
    <meta property="og:description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}" />
    <meta property="og:site_name" content="sharjaharchitecture.org" />
    <meta property="article:published_time" content="2018-10-28T05:59:00+01:00" />
    <meta property="article:modified_time" content="2018-010-28T19:08:47+01:00" />
    <meta property="article:section" content="Homepage" />
    <meta property="article:tag" content="SAT" />

    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js"
            integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>

    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">

    <title>Re-materialize || {{ isset($_GET['lang']) ? $post->title_ar : $post->title }}</title>
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

        #vimeovid {
            height: 450px;
        }

        @media only screen and (max-width: 991px) {
            .sideb {
                padding-left: 12px;
                padding-right: 12px;
            }

            #vimeovid {
                height: 400px;
            }
        }

        @media only screen and (max-width: 420px) {
            #vimeovid {
                height: 300px;
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
                <div class="menu-holder blk-border auto-height">
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
                                <a href="{{ url('pages/programs') }}" style="color: rgb(0, 0, 0);"> البرامج</a>
                                &gt;
                                <a href="{{ url('pages/programs/re-materialize') }}" style="color: rgb(0, 0, 0);">{{ $page->name_ar }}</a>
                            </div>
                        @else
                            <div class="breadcrumbs en" style="height: 20px;">
                                <a href="{{ url('/') }}" style="color: rgb(0, 0, 0);">Home</a>
                                &gt;
                                <a href="{{ url('pages/programs') }}" style="color: rgb(0, 0, 0);">Programs</a>
                                &gt;
                                <a href="{{ url('pages/programs/re-materialize') }}" style="color: rgb(0, 0, 0);">{{ $page->name }}</a>
                            </div>
                        @endif
                    </div>


                    <div class="row">
                        <div class="col-md-9">
                            <h1>{!! isset($_GET['lang']) ? $post->title_ar : $post->title !!}</h1>
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
                                @if($post->video_file)
                                    <div class="col-md-12">
                                        {{--<video width="100%" controls>--}}
                                        {{--<source src="{{ asset('public/'.$post->video_file) }}" type="video/mp4">--}}
                                        {{--Your browser does not support the video tag.--}}
                                        {{--</video>--}}

                                        {{--<video width="100%" controls>--}}
                                        {{--<source src="https://vimeo.com/252443587">--}}
                                        {{--</video>--}}


                                        <iframe id="vimeovid" src="https://player.vimeo.com/video/{{$post->video_file}}" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

                                        <script src="https://player.vimeo.com/api/player.js"></script>

                                    </div>
                                @elseif(count($page->sliders)==1)
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
                            @if(count($similar))
                                <b>MORE</b><br/>
                                <br/>
                                @foreach($similar as $pod)
                                    <a href="{{ url('pages/re-materialize/'.$pod->slug) }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}">

                                        @if($page->slider->landscape)
                                            <img src="{{url('public/'.$pod->slider->landscape->url)}}" width="100%" class="featured-img"><br/>
                                        @elseif($page->slider->square)
                                            <img src="{{url('public/'.$pod->slider->square->url)}}" width="100%" class="featured-img"><br/>
                                        @else
                                            <img src="https://via.placeholder.com/250" width="100%" class="featured-img"><br/>
                                        @endif
                                        <p style="margin-top:5px;">{{ isset($_GET['lang']) ? $pod->title_ar : $pod->title }}</p>
                                    </a>
                                    <hr/>
                                @endforeach
                                <br/>
                                <br/>
                            @endif
                            <b>{{ isset($_GET['lang']) ? 'شارك هذا الرابط' : 'SHARE THIS' }}</b><br/>
                            <ul class="socials">
                                <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url('pages/re-materialize/'.$post->slug) }}&picture={{url('public/'.$page->slider->square->url)}}&title={{ $post->title }}&description={{ $post->excerpt }}" class="fb"></a></li>
                                <li><a target="_blank" href="https://twitter.com/intent/tweet?text={{ url('pages/re-materialize/'.$post->slug) }}" class="tw"></a></li>
                            </ul>
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

</body>
</html>



