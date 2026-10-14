@if ($randomElement->isImage())
    <main role="main"
        class="container-fluid bgimg home-video-container home-landing-media-contain landing-display-{{ $displayTarget }} {{ $landingElement->link == '#' ? 'fullmob' : '' }}"
        id="home-video-container" style="background-image: url({{ asset('public' . $randomElement->url) }})">
        <div class="row">
            <div class="container" style="position: relative;">
                <div class="row">
                    <a href="{{ url('/') }}" id="video-logo"
                        class="{{ $landingElement->white_logos ? 'black' : '' }}"></a>
                    <img src="{{ $landingElement->white_logos ? asset('public/img/menu-bt-dark.png') : asset('public/img/menu-bt.png') }}"
                        style="{{ $landingElement->white_logos ? 'border-color:#000000' : '' }}" id="video-menu"
                        class="video-menu" width="50">
                    {{-- <div id="scroll-down" class="scroll-down"></div> --}}
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
        style="background-color: {{ $landingElement->background_windows }}"
        data-background-macos="{{ $landingElement->background_macos }}">
        <main role="main" class="container main home-video-container home-landing-media-contain" id="home-video-container"
            style="{{ $fallbackBackgroundImageUrl ? 'background-image: url(' . $fallbackBackgroundImageUrl . ');' : '' }} background-size: contain; background-position: center; background-repeat: no-repeat;">
            <div class="row">
                <div class="container-fluidi" style="position: relative;">
                    <div class="row">
                        <a href="{{ url('/') }}" id="video-logo"
                            class="{{ $landingElement->white_logos ? 'black' : '' }}"></a>
                        <img src="{{ $landingElement->white_logos ? asset('public/img/menu-bt-dark.png') : asset('public/img/menu-bt.png') }}"
                            style="{{ $landingElement->white_logos ? 'border-color:#000000' : '' }}" id="video-menu"
                            class="video-menu" width="50">
                        <div class="home-video auto-height home-landing-media-video-frame"
                            style="background-color: {{ $landingElement->background_windows }}; {{ $fallbackBackgroundImageUrl ? 'background-image: url(' . $fallbackBackgroundImageUrl . ');' : '' }} background-size: contain; background-position: center; background-repeat: no-repeat;">
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
                        {{-- <div id="scroll-down" class="scroll-down"></div> --}}
                    </div>
                </div>
            </div>
        </main>
    </div>

    @once
        <style>
            .home-landing-media-contain#home-video-container,
            .home-landing-media-contain.home-video-container {
                max-width: 100% !important;
                width: 100% !important;
            }

            .home-landing-media-contain.bgimg,
            main.home-landing-media-contain.bgimg {
                background-size: contain !important;
                background-position: center center !important;
                background-repeat: no-repeat !important;
            }

            @media only screen and (max-width: 767px) {
                .home-landing-media-contain.bgimg.landing-display-mobile {
                    background-size: contain !important;
                }
            }

            .home-landing-media-contain .home-landing-media-video-frame,
            .home-landing-media-contain .home-video {
                position: relative !important;
                padding: 0 !important;
                margin-bottom: 0 !important;
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

            .home-landing-media-contain video.landing-video,
            .home-landing-media-contain .home-video video.landing-video,
            .home-landing-media-contain .home-video #video.landing-video {
                position: relative !important;
                display: block !important;
                flex: 0 1 auto !important;
                top: auto !important;
                left: auto !important;
                right: auto !important;
                bottom: auto !important;
                width: auto !important;
                height: auto !important;
                max-width: 100% !important;
                max-height: 100% !important;
                margin: 0 !important;
                object-fit: contain !important;
                object-position: center center !important;
            }

            @media screen and (min-width: 2114px) {
                .home-landing-media-contain video.landing-video,
                .home-landing-media-contain .home-video #video.landing-video {
                    max-width: 100% !important;
                    width: auto !important;
                }
            }

            @media screen and (max-width: 620px) {
                .home-landing-media-contain video.landing-video,
                .home-landing-media-contain .home-video #video.landing-video {
                    max-height: 100% !important;
                    height: auto !important;
                    top: auto !important;
                }
            }

            @media screen and (min-width: 1921px) and (max-height: 840px),
                screen and (min-width: 1521px) and (max-height: 840px),
                screen and (max-height: 620px),
                screen and (max-width: 960px) and (max-height: 620px) {
                .home-landing-media-contain video.landing-video,
                .home-landing-media-contain .home-video #video.landing-video {
                    max-width: 100% !important;
                    max-height: 100% !important;
                    width: auto !important;
                    height: auto !important;
                    margin-top: 0 !important;
                }
            }
        </style>
        <script>
            (function() {
                function applyLandingVideoContain() {
                    document.querySelectorAll('.home-landing-media-contain video.landing-video').forEach(function(vid) {
                        vid.style.setProperty('position', 'relative', 'important');
                        vid.style.setProperty('left', 'auto', 'important');
                        vid.style.setProperty('bottom', 'auto', 'important');
                        vid.style.setProperty('margin-left', '0', 'important');
                        vid.style.setProperty('margin-top', '0', 'important');
                        vid.style.setProperty('width', 'auto', 'important');
                        vid.style.setProperty('height', 'auto', 'important');
                        vid.style.setProperty('max-width', '100%', 'important');
                        vid.style.setProperty('max-height', '100%', 'important');
                        vid.style.setProperty('object-fit', 'contain', 'important');
                    });
                }

                function bindLandingVideos() {
                    document.querySelectorAll('.home-landing-media-contain video.landing-video').forEach(function(vid) {
                        if (vid.dataset.containBound) {
                            return;
                        }
                        vid.dataset.containBound = '1';
                        vid.addEventListener('loadedmetadata', applyLandingVideoContain);
                    });
                    applyLandingVideoContain();
                }

                function patchAlignVideo() {
                    if (typeof window.alignVideo !== 'function' || window.alignVideo.__landingContainPatched) {
                        return false;
                    }
                    window.alignVideo = function() {
                        applyLandingVideoContain();
                        document.querySelectorAll('.home-landing-media-contain video.landing-video').forEach(function(vid) {
                            vid.style.setProperty('opacity', '1', 'important');
                        });
                    };
                    window.alignVideo.__landingContainPatched = true;
                    return true;
                }

                function initLandingVideoContain() {
                    bindLandingVideos();
                    patchAlignVideo();
                    applyLandingVideoContain();
                }

                document.addEventListener('DOMContentLoaded', initLandingVideoContain);
                window.addEventListener('load', initLandingVideoContain);

                var alignPatchTimer = setInterval(function() {
                    if (patchAlignVideo()) {
                        applyLandingVideoContain();
                    }
                }, 100);
                setTimeout(function() {
                    clearInterval(alignPatchTimer);
                    initLandingVideoContain();
                }, 3000);

                window.addEventListener('resize', applyLandingVideoContain);
            })();
        </script>
    @endonce
@endif
