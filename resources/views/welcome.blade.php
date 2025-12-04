<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and Asia." />
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Sharjah Architecture Triennial">
    <meta itemprop="description" content="Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and Asia.">
    <meta itemprop="image" content="http://sharjaharchitecture.org/og.JPG">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="http://sharjaharchitecture.org/og.JPG">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="Sharjah Architecture Triennial">
    <meta name="twitter:description" content="Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and Asia.">
    <meta name="twitter:creator" content="@author_handle">
    <!-- Twitter summary card with large image must be at least 280x150px -->
    <meta name="twitter:image:src" content="ttp://sharjaharchitecture.org/og.JPG">

    <!-- Open Graph data -->
    <meta property="og:title" content="Sharjah Architecture Triennial" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="http://sharjaharchitecture.org/" />
    <meta property="og:image" content="http://sharjaharchitecture.org/og.JPG" />
    <meta property="og:description" content="Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and Asia." />
    <meta property="og:site_name" content="Sharjah Architecture Triennial" />
    <meta property="article:published_time" content="2018-10-28T05:59:00+01:00" />
    <meta property="article:modified_time" content="2018-010-28T19:08:47+01:00" />
    <meta property="article:section" content="Homepage" />
    <meta property="article:tag" content="SAT" />

    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js"
            integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>

    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}?v={{ file_exists(public_path('favicon.ico')) ? filemtime(public_path('favicon.ico')) : time() }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('public/favicon.ico') }}?v={{ file_exists(public_path('favicon.ico')) ? filemtime(public_path('favicon.ico')) : time() }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('public/favicon.ico') }}?v={{ file_exists(public_path('favicon.ico')) ? filemtime(public_path('favicon.ico')) : time() }}">

    <title>Sharjah Architecture Triennial</title>
    <meta name="robots" content="index, follow">
    <script>
    // Protection against malicious title/content injection
    (function() {
        var originalTitle = document.title;
        var maliciousKeywords = ['batmantoto', 'toto', 'slot', 'gacor', 'togel', 'gambling', 'casino'];
        var checkTitle = function() {
            var currentTitle = document.title.toLowerCase();
            for (var i = 0; i < maliciousKeywords.length; i++) {
                if (currentTitle.indexOf(maliciousKeywords[i]) !== -1) {
                    document.title = originalTitle;
                    console.warn('Malicious content detected and blocked');
                    return;
                }
            }
        };
        // Check title immediately and on DOM changes
        checkTitle();
        setInterval(checkTitle, 1000);
        // Monitor for title changes
        var titleObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' || mutation.type === 'characterData') {
                    checkTitle();
                }
            });
        });
        var titleElement = document.querySelector('title');
        if (titleElement) {
            titleObserver.observe(titleElement, { childList: true, characterData: true, subtree: true });
        }
    })();
    </script>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700&amp;subset=arabic" rel="stylesheet">
    <link href="{{ asset('public/fonts/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fonts/roboto/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}?v={{rand(1,99999)}}" rel="stylesheet">
    <link href="{{ asset('public/css/responsive.css') }}?v={{rand(1,99999)}}" rel="stylesheet">
    <link href="{{ asset('public/css/home.css') }}" rel="stylesheet">

    <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
    <style>
        #header {
            position: absolute;
            top: 30px;
        }

        #video-logo { position: absolute; left: 30px; top: 30px; z-index: 1; cursor: pointer; }
        #video-menu { border: 3px solid #fff; position: absolute; right: 30px; top: 30px; z-index: 1; cursor: pointer; }

        .body-section { font-weight: 300; }
				
		#home-video-container .v-content a {
			color: #fff !important;
			text-decoration: none !important;
		}
		
		#menu ul li ul li {
			padding: 5px 15px 0 0;
		}

        #featured-list p {
            margin-bottom: 8px;
        }

        .home-video {
/*            background-color: #0050f9;*/
            background-color: #fff;
        }

        #video-logo.black {
            background-image: url('{{asset('public/img/sharjah-architecture-logo-dark.png')}}');
        }

        #featured-list .featured .overlay {
            height: auto;
        }

        .home-video .v-content {
            text-align: left;
            width: 470px;
            padding: 0 30px;
            font-size: 20px;
        }

        .bgimg {
            max-width: 100% !important;
            height: 100vh;
            background-size: 120% auto !important;
            background-position: center;
        }

        @media only screen and (max-width: 520px) {
            .home-video .v-content {
                width: 100%;
            }
            .home-video .v-content span {
                text-align: center !important;
            }

            #featured-list .featured a img {
                margin: 15px 0;
            }

            .bgimg {
                background-size: auto 70% !important;
            }
        }

        @inject('pageService', 'App\Services\PageService')
        <?php $landingElement = $pageService->getHomeLandingElement(); ?>
        <?php
            $randomElement = $landingElement->uploads()->where('template','high')->first();

            if(!$randomElement)
                $randomElement = $landingElement->uploads()->where('template','')->first();
        ?>

        @if($randomElement->mime_type=='image/jpeg')
            @media only screen and (max-width: 1366px) {
                .bgimg {
                    background-size: auto 120% !important;
                }
            }

            #home-video-container {
                max-width: 100% !important;
            }


        @media only screen and (max-width: 520px) {
            .bgimg.fullmob {
                background-size: auto 70% !important;
            }
        }
        @endif
    </style>
</head>

<?php
$video = 6;

if (!isset($_COOKIE['firsttime']))
{
    setcookie("firsttime", "no");
    $video = 6;
}
else if (!isset($_COOKIE['secondtime']))
{
    setcookie("secondtime", "no");
    $video = 5;
}
else if (!isset($_COOKIE['thirdtime']))
{
    setcookie("thirdtime", "no");
    $video = 4;
}
else if (!isset($_COOKIE['fourthtime']))
{
    setcookie("fourthtime", "no");
    $video = 3;
}
else if (!isset($_COOKIE['fifthtime']))
{
    setcookie("fifthtime", "no");
    $video = 2;
}
else if (!isset($_COOKIE['sixthtime']))
{
    setcookie("sixthtime", "no");
    $video = 1;
} else {
    $video = rand(1,6);
}
?>


<body class="home">

<main role="main" class="container main" id="menu">
    <div class="row">
        <div class="container">
            <div class="row">
                <a href="{{ url('/') }}" id="main-logo"></a>
                <div class="buttons">
                    <a href="#" class="menu-icon menu-click" id="menu-bt"></a>
                    <a href="#" class="menu-icon menu-close-click" id="menu-bt-close"></a>
                    <a href="#" class="menu-icon search-click" id="search-bt"></a>
                    <form action="{{ url('search') }}" method="post" id="search">
                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                        <input type="text" name="keyword">
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


@if($randomElement->mime_type=='image/jpeg')
<main role="main" class="container-fluid bgimg {{ $landingElement->link == '#' ? 'fullmob' : '' }}" id="home-video-container" style="background-image: url({{ asset('public'.$randomElement->url) }})">
    <div class="row">
        <div class="container" style="position: relative;">
            <div class="row">
                <a href="{{ url('/') }}" id="video-logo" class="<?php echo $landingElement->white_logos ? 'black' : '' ?>"></a>
                <img src="{{ $landingElement->white_logos ? asset('public/img/menu-bt-dark.png') : asset('public/img/menu-bt.png') }}" style="{{ $landingElement->white_logos ? 'border-color:#000000' : '' }}" id="video-menu" width="50">
                <div id="scroll-down"></div>
            </div>
        </div>
    </div>
</main>

@else($randomElement->mime_type=='video/mp4')

    <div id="videoholder">
        <main role="main" class="container main" id="home-video-container">
            <div class="row">
                <div class="container" style="position: relative;">
                    <div class="row">
                        <a href="{{ url('/') }}" id="video-logo" class="<?php echo $landingElement->white_logos ? 'black' : '' ?>"></a>
                        <img src="{{ $landingElement->white_logos ? asset('public/img/menu-bt-dark.png') : asset('public/img/menu-bt.png') }}" style="{{ $landingElement->white_logos ? 'border-color:#000000' : '' }}" id="video-menu" width="50">
                        <div class="home-video auto-height">
                            @if($landingElement)

                                    <?php
                                    $mtClass = '';

                                    if(
                                        $randomElement->original_name == "4.mp4" ||
                                        $randomElement->original_name == "5.mp4" ||
                                        $randomElement->original_name == "6.mp4"
                                    )
                                        $mtClass = 'margin-top-negative';


                                    ?>
                                    <video autoplay muted loop playsinline id="video" class="<?php echo $mtClass; ?>">
                                        <source src="{{ asset('public') }}{{$randomElement->url}}" type="video/mp4">
                                    </video>

                                @if($landingElement->link)
                                    <a href="{{ $landingElement->link }}"><div class="overlay"></div></a>
                                @else
                                    <div class="overlay"></div>
                                @endif
                            @endif
                            <div class=""></div>
                            {{--<div class="headline auto-height-holder">--}}
                                {{--<div class="v-content">--}}
                                      {{--<span class="ar" dir="rtl">--}}
                                        {{--{!! $pageService->getHomeData('headline-ar')->value !!}--}}
                                      {{--</span>--}}
                                    {{--<span class="en">--}}
                                        {{--{!! $pageService->getHomeData('headline-en')->value !!}--}}
                                      {{--</span>--}}

                                    {{--<span class="ar" dir="rtl" style="text-align:right; {{$landingElement->white_logos ? 'color:#000' : ''}}">--}}
                                    {{--{!! $landingElement->title_ar !!}--}}
                                    {{--</span>--}}
                                    {{--<span class="en" {{$landingElement->white_logos ? 'style=color:#000' : ''}}>--}}
                                    {{--{!! $landingElement->title !!}--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <div id="scroll-down"></div>
                    </div>
                </div>
            </div>
        </main><!-- /.container -->
    </div><!-- /.container -->

@endif

<div style="position:relative">
    <header class="clearfix">
        <div class="container-fluid dark min" id="floating-header">
            <div class="container" style="position: relative">
                <div class="row">
                    <a href="{{ url('/') }}" class="logo-link">
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
    </header>

    <div class="container text-center" id="home-content" style="padding-top: 260px;">
        <div class="body-section text-center">
			<span dir="rtl" class="ar" style="font-size: {{ $pageService->getHomeData('home-page-font-size-ar')->value }}px;line-height: {{ $pageService->getHomeData('home-page-font-line-ar')->value }}px">
			{!! $pageService->getHomeData('intro-ar')->value !!}
            </span>
            <br><br>
            <span class="en" style="font-size: {{ $pageService->getHomeData('home-page-font-size-en')->value }}px;line-height: {{ $pageService->getHomeData('home-page-font-line-en')->value }}px">
			{!! $pageService->getHomeData('intro-en')->value !!}
			</span>
        </div>
    </div>

    <div class="container text-center">
        <div class="body-section text-center">
            <div class="row" id="featured-list">
                @foreach($pageService->getHomeBoxes(0) as $item)
                    <a href="{{ $item->link }}">
                        <div class="col-md-6 col-sm-6 featured white-text"  >
                            {{--<div class="v-content">--}}
                                {{--<span class="ar" dir="rtl">--}}
                                    {{--{!! $item->title_ar !!}--}}
                                {{--</span><br>--}}
                                {{--<span class="en">--}}
                                    {{--{!! $item->title !!}--}}
                                {{--</span>--}}
                            {{--</div>--}}
                            <a href="{{ $item->link }}" class="overlay">
                                <img src="{{ $item->slider ? asset('public/'.$item->slider->square->url) : asset('public/img/placeholder-200x200.png') }}" class=" blk-border" width="100%">
                            </a>

                            <br>

                            <p class="ar" dir="rtl">
                            {!! $item->title_ar !!}
                            </p>
                            <p class="en">
                            {!! $item->title !!}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>


    <div class="container text-center">
        <div class="body-section">
			<span>
			{!! $pageService->getHomeData('additional')->value !!}
			</span>
        </div>
    </div>

</div>

@include('footer')
<!-- <div id="scoller" style="position:fixed;top:50%;left:0;z-index;100; background-color:red;">0</div>
<div id="dimensions" style="position:fixed;top:55%;left:0;z-index;100; background-color:blue;color:#fff">0</div>
<div id="home-video" style="position:fixed;top:60%;left:0;z-index;100; background-color:green;color:#fff">0</div> -->


@include('search')
@include('subscribe')

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('public/js/jquery-3.3.1.min.js') }}"></script>
<!--- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/js/main.js') }}"></script>
<!--End mc_embed_signup-->

<script>

    $(window).on('load', function(){
        // this is the first time
        if (! localStorage.noFirstVisit) {
            // show the element
            // and do the animation you want
            setTimeout(function(){
                $('#subscribeModal').modal('show');
            },2000);

            // check this flag for escaping this if block next time
            localStorage.noFirstVisit = true;
        }
    });
	
    /*********** HOME SCRIPTS **********************/
    checkBar();
    /**
     $('#shiftimg').mouseenter(function() {
			$(this).find('img').attr('src','img/home/2b.jpg')
		});

     $('#shiftimg').mouseleave(function() {
			$(this).find('img').attr('src','img/home/2.jpg')
		});

     $('#shiftimg2').mouseenter(function() {
			$(this).find('img').attr('src','img/home/Adrian2.jpg')
		});

     $('#shiftimg2').mouseleave(function() {
			$(this).find('img').attr('src','img/home/Adrian1.jpg')
		});
     **/
    $(window).resize(function(){
        setTimeout(function(){
            $('.innerpage h1').css('height','auto');
            $('.innerpage .breadcrumbs').css('height','auto');
        },100);

        checkBar();
        checkScroll();
    });

    function checkBar(){
        if($(window).outerWidth()<992){
            $('#logo').addClass('twoline');
        } else {
            $('#logo').removeClass('twoline');
        }

        if($(document).scrollTop()>$('#header').height()){
        } else {
            $('#logo').removeClass('oneline');
        }

        $('#logo').fadeIn();
    }

    var mouseDown = false;

    $(document).mousedown(function(){
        mouseDown = true;
    });

    $(document).on('touchstart',function(){
        mouseDown = true;
    });

    $(document).on('touchend',function(){
        mouseDown = false;
    });

    $(document).mouseup(function(){
        mouseDown = false;
    });

    var scrollAnimating = false;
    console.log($(document).scrollTop());
    console.log(parseInt($(window).outerHeight()));
    if($(document).scrollTop() > parseInt($(window).outerHeight())){
        $('#floating-header').addClass('floating');
    }

    var marginLeft = 0;

    function checkScroll(){
        if($(document).scrollTop()>($('#home-video-container').height()+$('#header').height())){
            $('#floating-header .menu-bar').addClass('active');
        } else {
            $('#floating-header .menu-bar').removeClass('active');
        }

        if($(document).scrollTop()>(wHeight)+150){
            if(!$('#logo').hasClass('oneline'))
                $('#logo').addClass('oneline');
        }
        else {
            $('#logo').removeClass('oneline');
        }
    }

    $(window).scroll(function(){

        checkScroll();

        /** $('#scoller').html($(document).scrollTop());
         $('#dimensions').html($(window).outerWidth()+'x'+$(window).outerHeight());
         $('#home-video').html($(window).outerHeight()); **/

        wHeight = parseInt($('#home-video-container').outerHeight());

        if($(document).scrollTop()>100){
            $('#scroll-down').hide();
        } else {
            $('#scroll-down').show();
        }

        if($(document).scrollTop()>(wHeight)){
            $('#floating-header').addClass('floating');
        }
        else if($(document).scrollTop()<(wHeight)+60) {
            $('#floating-header').css('top','30px').css('right','0').removeClass('floating');
        }

        $('#menu-bt-close').trigger('click');

        if(!scrollAnimating){
            hHeight = wHeight/2;
            if( $(document).scrollTop()>0 && $(document).scrollTop()<hHeight && scrollAnimating == false){
                if(!mouseDown){
                    scrollAnimating = true;
                    $('html, body').animate({
                        scrollTop: wHeight+($(window).width()<630 ? 45 : 60 )
                    }, 600, function(){

                        scrollAnimating = false;
                        $('#floating-header').addClass('floating');
                    });
                }
            }
            else if ( $(document).scrollTop()<(wHeight) && $(document).scrollTop() > (wHeight/2) && scrollAnimating == false ) {
                if(!mouseDown){
                    scrollAnimating = true;
                    $('html, body').animate({
                        scrollTop: 0
                    }, 600, function(){
                        scrollAnimating = false;
                    });
                }
            }
        }
    });

    $('#scroll-down').on('click', function(){
        if($(window).outerWidth() > 620)
            window.scroll(0,5);
        else
            $('html, body').animate({ scrollTop: wHeight+60 }, 300);
    });

    $('#video-menu').on('click', function(e){
        e.preventDefault();
        showMenu();
    });

    $(document).ready(function(){
        checkScroll();
        setTimeout(function(){alignVideo()},1000);
    });


    $(window).resize(function(){
        alignVideo();
    });

    function alignVideo(){
        setTimeout(function(){
            marginLeft = $('.home-video #video').width()/2;
            $('.home-video #video').css('margin-left','-'+(marginLeft)+'px');

            // if($('.home-video #video').width()>$(window).outerWidth()){
            //     marginLeft = $('.home-video #video').width()-$(window).outerWidth();
            //     marginLeft = marginLeft/2;
            //     $('.home-video #video').css('margin-left','-'+(marginLeft+7)+'px');
            // } else {
            //     $('.home-video #video').css('margin-left','0');
            // }
            //
            // if($('.margin-top-negative').height()>$(window).outerHeight()){
            //     marginTop = $('.home-video #video').height()-$(window).outerHeight();
            //     marginTop = marginTop/2;
            //
            //     $('.home-video #video').css('margin-top','-'+(marginTop+70)+'px');
            // }

        },100);

        setTimeout(function(){
            $('.home-video #video').css('opacity',1);
        },100);
    }

    // Get the <video> element with id="myVideo"
    var vid = document.getElementById("video");
    var maxVid = vid.duration - .8;
    // Assign an ontimeupdate event to the <video> element, and execute a function if the current playback position has changed
    vid.ontimeupdate = function() {myFunction()};
    function myFunction() {
// Display the current position of the video in a <p> element with id="demo"
        if(vid.currentTime >= maxVid)
            vid.currentTime = 0;
    }


    function getOS() {
        var userAgent = window.navigator.userAgent,
            platform = window.navigator.platform,
            macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
            windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
            iosPlatforms = ['iPhone', 'iPad', 'iPod'],
            os = null;
        if (macosPlatforms.indexOf(platform) !== -1) {
            os = 'Mac OS';
            $('.home-video').first().css('background-color','{{$landingElement->background_macos}}');
            $('#videoholder').css('background-color','{{$landingElement->background_macos}}');
            // $('.home-video').first().css('background-color','#0d5afb');
        }
        else if (iosPlatforms.indexOf(platform) !== -1) {
            os = 'iOS';
            $('.home-video').first().css('background-color','{{$landingElement->background_macos}}');
            $('#videoholder').css('background-color','{{$landingElement->background_macos}}');
            // $('.home-video').first().css('background-color','#0d5afb');
        } else if (windowsPlatforms.indexOf(platform) !== -1) {
            os = 'Windows';
            $('.home-video').first().css('background-color','{{$landingElement->background_windows}}');
            $('#videoholder').css('background-color','{{$landingElement->background_windows}}');
        } else if (/Android/.test(userAgent)) {
            os = 'Android';
            $('.home-video').first().css('background-color','{{$landingElement->background_windows}}');
            $('#videoholder').css('background-color','{{$landingElement->background_windows}}');
            // $('.home-video').first().css('background-color','#094df8');
        } else if (!os && /Linux/.test(platform)) {
            os = 'Linux';
            $('.home-video').first().css('background-color','{{$landingElement->background_windows}}');
            $('#videoholder').css('background-color','{{$landingElement->background_windows}}');
        }
        return os;
    }

    @if($randomElement->mime_type=='video/mp4')
        getOS();
    @endif

</script>
</body>
</html>