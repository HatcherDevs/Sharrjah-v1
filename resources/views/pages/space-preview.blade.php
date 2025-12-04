@extends('pages.master')

@section('css')
    <!-- Include Amplitude JS Visualizations -->
    <script type="text/javascript" src="https://521dimensions.com/img/open-source/amplitudejs/visualizations/michaelbromley.js"></script>
    <style>
        .innerpage .socials {
            padding: 0 !important;
        }
        .innerpage .socials li {
            list-style: none !important;
            float: left;
        }
        .innerpage .socials li a {
            display: block !important;
            float: left;
            width: 24px;
            height: 24px;
            background-size: 100% auto;
            margin-{{ isset($_GET['lang']) ? 'right' : 'left' }}: 10px;
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
                width: calc(100% - 74px); } }
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
            background-color: #000; }

        progress[value]::-webkit-progress-value {
            background-color: #000; }

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
    </style>
@endsection

@section('content')
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
                                    <a href="{{ url('pages/programs/sat-talks') }}" style="color: rgb(0, 0, 0);">SAT Talks</a>
                                </div>
                            @else
                                <div class="breadcrumbs en" style="height: 20px;">
                                    <a href="{{ url('/') }}" style="color: rgb(0, 0, 0);">Home</a>
                                    &gt;
                                    <a href="{{ url('pages/programs') }}" style="color: rgb(0, 0, 0);">Programs</a>
                                    &gt;
                                    <a href="{{ url('pages/programs/sat-talks') }}" style="color: rgb(0, 0, 0);">SAT Talks</a>
                                </div>
                            @endif
                        </div>


                        <div class="row">
                            <div class="col-md-9">
                                <h1>{!! isset($_GET['lang']) ? $post->speaker_ar : $post->speaker !!}</h1>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">

                                <?php $page = $post; ?>
                                <div class="row" dir="">
                                    @if(count($page->sliders)==1)
                                        <div class="col-md-12">
                                            @if($page->slider->landscape)
                                                <img src="{{ url('public/'.$page->slider->landscape->url) }}" width="100%" class="featured-img">
                                                <span class="imgcap">
                                                    <span class="en float-left">{{ $page->slider->landscape->caption }}</span>
                                                    <span dir="rtl" class="float-right">{{ $page->slider->landscape->caption_ar }}</span>
                                                </span>
                                            @endif
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

                                            </div>
                                        @endif
                                    @else
                                        <div class="col-md-12 text-left">
                                            {!! $page->content !!}
                                        </div>
                                    @endif

                                </div>



                                @if($post->additional_content_bottom)
                                    <div class="row" dir="ltr">
                                        <div class="col-md-12 text-left">
                                            {!! $post->additional_content_bottom !!}
                                        </div>
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
                            <div class="col-md-3 pl-5 pr-5">
                                @include('partials/podcast-sidebar')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endsection

@section('js')

@endsection

