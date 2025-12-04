<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}" />
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Sharjah Architecture Triennial || Research">
    <meta itemprop="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta itemprop="image" content="{{asset('public/'.$post->slider->square->url)}}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="http://sharjaharchitecture.org/og.JPG">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="Sharjah Architecture Triennial || Research">
    <meta name="twitter:description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta name="twitter:creator" content="@author_handle">
    <!-- Twitter summary card with large image must be at least 280x150px -->
    <meta name="twitter:image:src" content="{{asset('public/'.$post->slider->square->url)}}">

    <!-- Open Graph data -->
    <meta property="og:title" content="Sharjah Architecture Triennial || Research" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('pages/podcasts/'.$post->slug) }}" />
    <meta property="og:image" content="{{asset('public/'.$post->slider->square->url)}}" />
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

    <title>Sharjah Architecture Triennial || Research</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700&amp;subset=arabic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lateef&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,800,900" rel="stylesheet">
    <link href="{{ asset('public/fonts/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fonts/roboto/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/mapStyle/mapResearch.css?v=3.4') }}" rel="stylesheet">
    <link href="{{ asset('public/mapResponsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/owl.carousel.min.css') }}" rel="stylesheet"><link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"
    />

    @yield('css')

    @if($lang=='ar')
        <link href="https://fonts.googleapis.com/css?family=Cairo:400,700&amp;subset=arabic" rel="stylesheet">
        <style>
            .simplebar-track.simplebar-vertical {
                left: 0;
                right: auto;
            }

            body {
                direction: rtl !important;
                text-align: right;
                font-family: 'Cairo';
            }

            .filterlabel {
                float: right;
            }

            #boxlinks {
                float: left;
            }

            .breadcrumbs {
                float: right;
            }

            #boxlinks a {
                margin-right: 20px;
                margin-left: 0;
            }
            #boxlinks li {
                float: none;
                display: inline-block;
            }

            #catpop {
                left: auto;
                right: -100%;
                transition: right 600ms;
            }

            .mapcontent {
                text-align: right;
                font-family: 'Cairo';
            }

            #timeline {
                left: -100%;
            }

            #timelineSelect li span {
                left: -100%;
            }

            #timelineSelect li a:before {
                left: auto;
                right: -8px;
            }

            #timelineSelect li span a {
                padding: 10px 15px 10px 10px;
            }

            .catdetail {
            }

            .simplebar-content-wrapper {
                padding-left: 18px;
                padding-right: 0;
            }

            #intropop {
                left: auto;
                right: -100%;
            }

            .backbutton {
                float: right;
                padding-left: 0;
                padding-right: 30px;
                background-position: right center;
                background-image: url({{ asset('public/img/research/back-arrow-right.png') }});
            }

            .video-pop {
                left: auto;
                right: -120%;
                transition: right 600ms;
            }

            .video-pop.active {
                right: 0;
            }

            .video-pop .backbutton {
                right: 12px;
                left: auto;
            }

            #form .submit {
                float: left;
            }

            .page-4 .arrows {
                display: none !important;
            }

            @media only screen and (max-width: 1100px) {

                #intropop {
                    left: -100%;
                    right: auto;
                }

                #boxlinks {
                    float: none;
                }

                .pagecontent {
                    max-height: 50vh;
                }

                #timelineSelect li span {
                    left: 0;
                }

                #timelineSelect li a:before {
                    left: 50%;
                    right: auto;
                    top: -11px;
                }

                #boxlinks a {
                    margin-right: 0;
                    margin-left: 0;
                }
            }

            @media only screen and (max-width: 420px) {
                #timelineSelect li span a {
                    padding: 10px 0;
                }
                #boxlinks a {
                    margin-right: 10px;
                }
            }
        </style>
    @endif

    <style>
        #repositories.white {
            background-color: #fff !important;
        }
        // Start Hid Box in Map
        /* .valign .slide-in-left .catdetail , .catdetail.active{
            display:none!important;
        } */
    </style>
</head>

<body>


