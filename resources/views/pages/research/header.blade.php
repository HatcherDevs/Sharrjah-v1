<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}" />
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Sharjah Architecture Triennial || Research">
    <meta itemprop="description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta itemprop="image" content="{{ asset('public/' . $post->slider->square->url) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="http://sharjaharchitecture.org/og.JPG">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="Sharjah Architecture Triennial || Research">
    <meta name="twitter:description" content="{{ isset($_GET['lang']) ? $post->excerpt_ar : $post->excerpt }}">
    <meta name="twitter:creator"
        content="@author_handle">
    <!-- Twitter summary card with large image must be at least 280x150px -->
    <meta name="twitter:image:src" content="{{ asset('public/' . $post->slider->square->url) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="Sharjah Architecture Triennial || Research" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('pages/podcasts/' . $post->slug) }}" />
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

    <title>Sharjah Architecture Triennial || Research</title>
    <!-- Bootstrap core CSS -->
    <!--- Start New Bootstrap 5 --->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!--- End New Bootstrap 5 --->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700&amp;subset=arabic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lateef&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,800,900" rel="stylesheet">
    <link href="{{ asset('public/fonts/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fonts/roboto/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/research.css?v=4.6') }}" rel="stylesheet">
    <link href="{{ asset('public/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/owl.carousel.min.css') }}" rel="stylesheet"><link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"
    />
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700&amp;subset=arabic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lateef&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    @yield('css')

    @if ($lang == 'ar')
        {{-- <link href="https://fonts.googleapis.com/css?family=Cairo:400,700&amp;subset=arabic" rel="stylesheet"> --}}
        <style>
            .simplebar-track.simplebar-vertical {
                left: 0;
                right: auto;
            }

            body {
                direction: rtl !important;
                text-align: right;
                font-family: 'Cairo','Roboto', sans-serif;
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

            .backbutton:hover{
                animation: name duration timing-function delay iteration-count direction fill-mode;
            }
            @keyframes backAnim{
                
            }
        </style>
    @endif

    <style>
        #repositories.white {
            background-color: #fff !important;
        }
    </style>
</head>

<body style="overflow: hidden;">

<main role="main" class="main" id="menu">
    <div class="row">
        <div class="container">
            <div class="row">
                <a href="{{ url('/') }}" id="main-logo"></a>
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
                    <div class="headline auto-height-holder" >
                        @include('menu-desktop')
                        <div class="container-fluid">
                            @include('menu-mobile')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<header class="clearfix" id="header" style="display: none">
    <div class="dark min floating" id="floating-header">
        <div class="container-fluid" style="position: relative">
            <div class="relative">
                <a href="{{ url('/') }}/" class="logo-link">
                    <div id="logo" class="clearfix oneline">
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
            <div class="relative clearfix" dir="" id="bottommenu">
                <div class="container-fluid" style="padding:0;">
                    <div class="breadcrumbs en" style="height: 40px;">
                        @if ($lang == 'ar')
                            
                        
                         <a class="hover_blue_color" href="{{ url('/research?lang=ar') }}" style="margin-right:43px">
                            برنامج أبحاث الترينالي

                         </a>    @if ($content['show-arabic']->content)
                                <div id="langswitch" style="margin-right: 10rem"><a href="{{ url('research?lang=ar') }}" style="margin-left: 15px;">AR</a> <a class="divider">/</a> <a href="{{ url('research') }}">EN</a> </div>
                                @endif
                         @else
                          <a class="hover_blue_color" href="{{ url('/research') }}" style="margin-right: 15px;">
                                
                            SAT RESEARCH INITIATIVE

                            </a> 

                            @if ($content['show-arabic']->content)
                                <div id="langswitch"style="margin-left: 4rem">
                                    
                                    <a href="{{ url('research?lang=ar') }}" style="margin-left: 15px;">AR</a> <a class="divider">/</a> <a href="{{ url('research') }}">EN</a>
                                </div>
                                @endif
                        @endif
                    </div>

                    <ul id="boxlinks">
                       
                            
                        @if (!$content['map-page-title']->is_hidden)
                        <li>
                            <a data-bs-toggle="offcanvas"  data-bs-target="#offcanvasBottom_tab_Map"  aria-controls="offcanvasBottom" href="#" class="link" data-id="page-Map" id="tab_Map">
                                {{ $lang == 'ar' ? $content['map-page-title']->title_ar : $content['map-page-title']->title }}
                            </a></li>
                        @endif
                        @if (!$content['tab-1']->is_hidden)
                            <li><a data-bs-toggle="offcanvas" data-bs-toggle="modal" data-bs-target="#offcanvasBottom_Repository" aria-controls="offcanvasBottom" data-bs-toggle="modal" href="#offcanvasPopupRepo" href="#" class="link" data-id="page-1" id="tab_1" >
                                    {{ $lang == 'ar' ? $content['tab-1']->title_ar : $content['tab-1']->title }}
                                </a></li>
                        @endif

                        @if (!$content['tab-2']->is_hidden)
                            <li><a data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom_News_and_Event" aria-controls="offcanvasBottom" href="#" class="link" data-id="page-2" id="tab_2">
                                    {{ $lang == 'ar' ? $content['tab-2']->title_ar : $content['tab-2']->title }}
                                </a></li>
                        @endif

                        @if (!$content['tab-3']->is_hidden)
                            <li><a data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom_tab_3" aria-controls="offcanvasBottom" href="#" class="link" data-id="page-3" id="tab_3">
                                    {{ $lang == 'ar' ? $content['tab-3']->title_ar : $content['tab-3']->title }}
                                </a></li>
                        @endif

                        @if (!$content['tab-4']->is_hidden)
                            <li><a data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom_tab_4" aria-controls="offcanvasBottom" href="#" class="link" data-id="page-4" id="tab_4">
                                    {{ $lang == 'ar' ? $content['tab-4']->title_ar : $content['tab-4']->title }}
                                </a></li> @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>


@if (!$content['svg-logo']->is_hidden)
    @foreach($content['svg-logo']->images as $image)
    <div class="img_logo">
        <div class="position-relative d-flex justify-content-center">
            <img class="w-100" src="{{ asset('public/'.$image->image) }}">
            <a class="btn btn-dark text-center" href="{{ $content['svg-logo']->content }}">{{-- ENTER DIGITAL EXHIBITION--}} LAUNCHING SOON {{-- - ENTERVIRTUALEXHIBITION--}} </a>
        </div>
    </div>
    @endforeach
@endif
    <style>
        .img_logo a{
            background-color:#000;
            border-radius:20px;
            position: absolute;;
            top:55%;
            /* left: 35%;
            right: 25%; */
            width:fit-content;
            display: none;
        }
        .img_logo:hover a{
            display: block;
        }
        .img_logo {
            position: fixed;
            bottom: 5px;
            background-color: transparent;;
            /* border-style: solid; */
            width: 20%;
            z-index: 1053;
            transition: 0.5s;
            border: 0px!important;
            display: none;
        }

        .img_logo:hover {
            position: fixed;
            bottom: 15px;
            /* border-style: solid; */
            width: 50%;
        }

        @media(max-width:800px){
            .img_logo:hover{
                width: 95%;
            }

            .img_logo{
                width: 40%;
            }
        }

    </style>

    @if ($lang == 'ar')
        <style>
            .img_logo {
                left: 5px !important;
            }

            .img_logo:hover {
                left: 15px !important;
            }
        </style>
    @else
        <style>
            .img_logo {
                right: 5px !important;
            }

            .img_logo:hover {
                right: 15px !important;
            }
        </style>
    @endif




<div class="layout_iframe_pop" style="display: none">
    <button id="message" class="btn btn-danger close_layout_iframe_pop">&times;</button>
    <iframe id="fullWidthIframe"  src="" ></iframe>
</div>
<style>
    .layout_iframe_pop{
        position: absolute;
        top: 10%;
        bottom: 0;
        left: 10%;
        right: 0;
        width: 80%;
        height: 80%;
        z-index: 199999;
        background-color: #fff;
        border: 0px;
        outline: 0px transparent;
    }
    .close_layout_iframe_pop{
        position: absolute;
        z-index: 19999999999;
        top: 0;
        left: 0;
    }
</style>

