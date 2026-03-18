<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <meta name="description"
        content="Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and Asia." />
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Sharjah Architecture Triennial">
    <meta itemprop="description"
        content="Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and Asia.">
    <meta itemprop="image" content="http://sharjaharchitecture.org/og.JPG">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="http://sharjaharchitecture.org/og.JPG">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="Sharjah Architecture Triennial">
    <meta name="twitter:description"
        content="Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and Asia.">
    <meta name="twitter:creator"
        content="@author_handle">
	<!-- Twitter summary card with large image must be at least 280x150px -->
	<meta name="twitter:image:src" content="ttp://sharjaharchitecture.org/og.JPG">

	<!-- Open Graph data -->
	<meta property="og:title" content="Sharjah Architecture Triennial" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="http://sharjaharchitecture.org/" />
	<meta property="og:image" content="http://sharjaharchitecture.org/og.JPG" />
	<meta property="og:description" content="Sharjah Architecture Triennial is the first major platform for architecture and urbanism in the Middle East, North and East Africa, and Asia." />
	<meta property="og:site_name" content="Site Name, i.e. Moz" />
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
	<link href="https://fonts.googleapis.com/css?family=Lateef&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="{{ asset('public/fonts/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fonts/roboto/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style2.css') }}?v={{ rand(1, 99999) }}" rel="stylesheet">
    <link href="{{ asset('public/css/responsive.css') }}?v={{ rand(1, 99999) }}" rel="stylesheet">
    <link href="{{ asset('public/css/owl.carousel.min.css') }}" rel="stylesheet">
	<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
	<style>
		.figure-list li .title.en, .figure-list li .title.ar {
			overflow: hidden;
		}

		#menu ul li ul li {
			padding: 5px 15px 0 0;
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

		/* The container must be positioned relative: */
		.select-style {
			position: relative;
		}

		.select-style select {
			display: none; /*hide original SELECT element: */
		}

		.select-selected {
			background-color: #fff;
		}

		/*!* Style the arrow inside the select element: *!*/
		/*.select-selected:after {*/
			/*position: absolute;*/
			/*content: "";*/
			/*top: 14px;*/
			/*right: 10px;*/
			/*width: 0;*/
			/*height: 0;*/
			/*border: 6px solid transparent;*/
			/*border-color: #fff transparent transparent transparent;*/
		/*}*/

		/*!* Point the arrow upwards when the select box is open (active): *!*/
		/*.select-selected.select-arrow-active:after {*/
			/*border-color: transparent transparent #fff transparent;*/
			/*top: 7px;*/
		/*}*/

		/* style the items (options), including the selected item: */
		.select-items div,.select-selected {
			padding: 8px 16px;
			border: 3px solid #000;
			border-bottom: 0;
			/* border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent; */
			cursor: pointer;
			background-color: #fff;
		}
		.select-selected {
			background-color: transparent;
			border-bottom: 3px solid #000;
		}

		/* Style items (options): */
		.select-items {
			position: absolute;
			top: 93%;
			left: 0;
			right: 0;
			z-index: 99;
		}

		.select-items div:last-of-type {
			border-bottom: 3px solid #000;
		}

		/* Hide the items when the select box is closed: */
		.select-hide {
			display: none;
		}

		.select-items div:hover, .same-as-selected {
			background-color: #d9d9d9;
		}

		.cairo, .cairo span, .cairo p, .cairo h1, .cairo h2, .cairo h3, .cairo h4, .cairo h5 {
			font-family: 'Cairo' !important;
		}
	</style>

    @yield('css')

    @if (isset($page) && $page->slug == 'website-credits')
	  <style>
		  .body-section.contents a {
			  font-weight: 300;
		  }
	  </style> @endif
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
                Sharjah Architecture Triennal Website <br />
                {{ \Carbon\Carbon::now()->format('F d, Y') }} <br />
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
