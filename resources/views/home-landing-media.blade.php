@if ($randomElement->isImage())

    <main role="main"

        class="container-fluid bgimg home-video-container home-landing-media-contain landing-display-{{ $displayTarget }} {{ $landingElement->link == '#' ? 'fullmob' : '' }}"

        id="home-video-container"

        style="background-color: {{ $landingElement->background_windows }}; background-image: url({{ asset('public' . $randomElement->url) }});">

        <div class="row">

            <div class="container-fluid" style="position: relative;">

                <div class="row">

                    <a href="{{ url('/') }}" id="video-logo"

                        class="{{ $landingElement->white_logos ? 'black' : '' }}"></a>

                    <img src="{{ $landingElement->white_logos ? asset('public/img/menu-bt-dark.png') : asset('public/img/menu-bt.png') }}"

                        style="{{ $landingElement->white_logos ? 'border-color:#000000' : '' }}" id="video-menu"

                        class="video-menu" width="50">

                </div>

            </div>

        </div>

    </main>

@elseif (strpos($randomElement->mime_type, 'video/') === 0)

    @php

        $fallbackBackgroundImage = data_get($landingElement, 'background_image_url');

        $fallbackBackgroundImageUrl = $fallbackBackgroundImage ? asset('public' . $fallbackBackgroundImage) : null;

    @endphp

    <div id="videoholder" class="videoholder home-landing-media-contain landing-display-{{ $displayTarget }}"

        style="background-color: {{ $landingElement->background_windows }};"

        data-background-macos="{{ $landingElement->background_macos }}">

        <main role="main" class="container-fluid main home-video-container home-landing-media-contain" id="home-video-container"

            style="background-color: {{ $landingElement->background_windows }}; {{ $fallbackBackgroundImageUrl ? 'background-image: url(' . $fallbackBackgroundImageUrl . ');' : '' }}">

            <div class="row">

                <div class="container-fluid" style="position: relative;">

                    <div class="row">

                        <a href="{{ url('/') }}" id="video-logo"

                            class="{{ $landingElement->white_logos ? 'black' : '' }}"></a>

                        <img src="{{ $landingElement->white_logos ? asset('public/img/menu-bt-dark.png') : asset('public/img/menu-bt.png') }}"

                            style="{{ $landingElement->white_logos ? 'border-color:#000000' : '' }}" id="video-menu"

                            class="video-menu" width="50">

                        <div class="home-video auto-height home-landing-media-video-frame"

                            style="background-color: {{ $landingElement->background_windows }}; {{ $fallbackBackgroundImageUrl ? 'background-image: url(' . $fallbackBackgroundImageUrl . ');' : '' }}">

                            <?php

                            $mtClass = in_array($randomElement->original_name, ['4.mp4', '5.mp4', '6.mp4']) ? 'margin-top-negative' : '';

                            ?>

                            <video autoplay muted loop playsinline id="video"

                                class="landing-video {{ $mtClass }}"

                                @if ($fallbackBackgroundImageUrl) poster="{{ $fallbackBackgroundImageUrl }}" @endif>

                                <source src="{{ asset('public') . $randomElement->url }}"

                                    type="{{ $randomElement->mime_type }}">

                            </video>

                            @if ($landingElement->link)

                                <a href="{{ $landingElement->link }}">

                                    <div class="overlay"></div>

                                </a>

                            @else

                                <div class="overlay"></div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>



    @once

        <style>

            .home-landing-media-contain.videoholder,

            .home-landing-media-contain#home-video-container,

            .home-landing-media-contain.home-video-container,

            .home-landing-media-contain.bgimg {

                width: 100% !important;

                max-width: 100% !important;

                margin-left: 0 !important;

                margin-right: 0 !important;

                padding-left: 0 !important;

                padding-right: 0 !important;

            }



            .home-landing-media-contain > .row,

            .home-landing-media-contain .row > [class*='col'],

            .home-landing-media-contain .container-fluid {

                margin-left: 0 !important;

                margin-right: 0 !important;

                padding-left: 0 !important;

                padding-right: 0 !important;

                max-width: 100% !important;

            }



            .home-landing-media-contain.bgimg,

            main.home-landing-media-contain.bgimg {

                min-height: 100vh !important;

                min-height: 100svh !important;

                height: 100vh !important;

                height: 100svh !important;

                background-size: 100% auto !important;

                background-position: center center !important;

                background-repeat: no-repeat !important;

            }



            @media only screen and (max-width: 767px) {

                .home-landing-media-contain.bgimg.landing-display-mobile {

                    background-size: 100% auto !important;

                }

            }



            .home-landing-media-contain .home-landing-media-video-frame,

            .home-landing-media-contain .home-video {

                position: relative !important;

                padding: 0 !important;

                margin: 0 !important;

                width: 100% !important;

                max-width: 100% !important;

                height: 100vh !important;

                height: 100svh !important;

                min-height: 100vh !important;

                overflow: hidden !important;

                display: flex !important;

                align-items: center !important;

                justify-content: center !important;

                box-sizing: border-box !important;

            }



            .home-landing-media-contain .home-landing-media-video-frame .overlay {

                position: absolute;

                inset: 0;

                width: 100%;

                height: 100%;

                top: 0;

            }



            .home-landing-media-contain .home-landing-media-video-frame > a {

                position: absolute;

                inset: 0;

                z-index: 2;

            }



            /* Full width: no side crop; overflow clips top/bottom only if needed */

            .home-landing-media-contain video.landing-video,

            .home-landing-media-contain .home-video video.landing-video,

            .home-landing-media-contain .home-video #video.landing-video {

                position: relative !important;

                display: block !important;

                flex: 0 0 auto !important;

                top: auto !important;

                left: auto !important;

                right: auto !important;

                bottom: auto !important;

                width: 100% !important;

                height: auto !important;

                max-width: 100% !important;

                max-height: none !important;

                margin: 0 !important;

            }



            @media screen and (min-width: 2114px) {

                .home-landing-media-contain video.landing-video,

                .home-landing-media-contain .home-video #video.landing-video {

                    width: 100% !important;

                }

            }



            @media screen and (max-width: 620px) {

                .home-landing-media-contain video.landing-video,

                .home-landing-media-contain .home-video #video.landing-video {

                    width: 100% !important;

                    height: auto !important;

                }

            }



            @media screen and (min-width: 1921px) and (max-height: 840px),

                screen and (min-width: 1521px) and (max-height: 840px),

                screen and (max-height: 620px),

                screen and (max-width: 960px) and (max-height: 620px) {

                .home-landing-media-contain video.landing-video,

                .home-landing-media-contain .home-video #video.landing-video {

                    width: 100% !important;

                    height: auto !important;

                    margin-top: 0 !important;

                }

            }

        </style>

        <script>

            (function() {

                function applyLandingVideoFitWidth() {

                    document.querySelectorAll('.home-landing-media-contain video.landing-video').forEach(function(vid) {

                        vid.style.setProperty('position', 'relative', 'important');

                        vid.style.setProperty('left', 'auto', 'important');

                        vid.style.setProperty('bottom', 'auto', 'important');

                        vid.style.setProperty('margin-left', '0', 'important');

                        vid.style.setProperty('margin-top', '0', 'important');

                        vid.style.setProperty('width', '100%', 'important');

                        vid.style.setProperty('height', 'auto', 'important');

                        vid.style.setProperty('max-width', '100%', 'important');

                        vid.style.removeProperty('max-height');

                    });

                }



                function bindLandingVideos() {

                    document.querySelectorAll('.home-landing-media-contain video.landing-video').forEach(function(vid) {

                        if (vid.dataset.containBound) {

                            return;

                        }

                        vid.dataset.containBound = '1';

                        vid.addEventListener('loadedmetadata', applyLandingVideoFitWidth);

                    });

                    applyLandingVideoFitWidth();

                }



                function patchAlignVideo() {

                    if (typeof window.alignVideo !== 'function' || window.alignVideo.__landingContainPatched) {

                        return false;

                    }

                    window.alignVideo = function() {

                        applyLandingVideoFitWidth();

                        document.querySelectorAll('.home-landing-media-contain video.landing-video').forEach(function(vid) {

                            vid.style.setProperty('opacity', '1', 'important');

                        });

                    };

                    window.alignVideo.__landingContainPatched = true;

                    return true;

                }



                function initLandingVideoFit() {

                    bindLandingVideos();

                    patchAlignVideo();

                    applyLandingVideoFitWidth();

                }



                document.addEventListener('DOMContentLoaded', initLandingVideoFit);

                window.addEventListener('load', initLandingVideoFit);



                var alignPatchTimer = setInterval(function() {

                    if (patchAlignVideo()) {

                        applyLandingVideoFitWidth();

                    }

                }, 100);

                setTimeout(function() {

                    clearInterval(alignPatchTimer);

                    initLandingVideoFit();

                }, 3000);



                window.addEventListener('resize', applyLandingVideoFitWidth);

            })();

        </script>

    @endonce

@endif

