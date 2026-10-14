@if ($randomElement->isImage())
    <main role="main"
        class="container-fluid bgimg home-video-container landing-display-{{ $displayTarget }} {{ $landingElement->link == '#' ? 'fullmob' : '' }}"
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
        <main role="main" class="container main home-video-container" id="home-video-container"
            style="{{ $fallbackBackgroundImageUrl ? 'background-image: url(' . $fallbackBackgroundImageUrl . ');' : '' }} background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div class="row">
                <div class="container-fluidi" style="position: relative;">
                    <div class="row">
                        <a href="{{ url('/') }}" id="video-logo"
                            class="{{ $landingElement->white_logos ? 'black' : '' }}"></a>
                        <img src="{{ $landingElement->white_logos ? asset('public/img/menu-bt-dark.png') : asset('public/img/menu-bt.png') }}"
                            style="{{ $landingElement->white_logos ? 'border-color:#000000' : '' }}" id="video-menu"
                            class="video-menu" width="50">
                        <div class="home-video auto-height"
                            style="background-color: {{ $landingElement->background_windows }}; {{ $fallbackBackgroundImageUrl ? 'background-image: url(' . $fallbackBackgroundImageUrl . ');' : '' }} background-size: cover; background-position: center; background-repeat: no-repeat;">
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
            .home-landing-media-contain .home-video {
                overflow: hidden;
            }

            .home-landing-media-contain .home-video video.landing-video,
            .home-landing-media-contain .home-video #video.landing-video {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100% !important;
                height: 100% !important;
                max-width: 100% !important;
                max-height: 100% !important;
                margin: 0 !important;
                object-fit: contain !important;
                object-position: center center !important;
            }

            @media screen and (min-width: 2114px) {
                .home-landing-media-contain .home-video video.landing-video,
                .home-landing-media-contain .home-video #video.landing-video {
                    width: 100% !important;
                }
            }

            @media screen and (max-width: 620px) {
                .home-landing-media-contain .home-video video.landing-video,
                .home-landing-media-contain .home-video #video.landing-video {
                    height: 100% !important;
                    top: 0 !important;
                }
            }

            @media screen and (min-width: 1921px) and (max-height: 840px),
                screen and (min-width: 1521px) and (max-height: 840px),
                screen and (max-height: 620px),
                screen and (max-width: 960px) and (max-height: 620px) {
                .home-landing-media-contain .home-video video.landing-video,
                .home-landing-media-contain .home-video #video.landing-video {
                    width: 100% !important;
                    height: 100% !important;
                    margin-top: 0 !important;
                }
            }
        </style>
        <script>
            (function() {
                function applyLandingVideoContain() {
                    document.querySelectorAll('.home-landing-media-contain video.landing-video').forEach(function(vid) {
                        vid.style.setProperty('margin-left', '0', 'important');
                        vid.style.setProperty('margin-top', '0', 'important');
                        vid.style.setProperty('object-fit', 'contain', 'important');
                        vid.style.setProperty('width', '100%', 'important');
                        vid.style.setProperty('height', '100%', 'important');
                    });
                }

                function bindLandingVideos() {
                    document.querySelectorAll('.home-landing-media-contain video.landing-video').forEach(function(vid) {
                        if (vid.dataset.containBound) {
                            return;
                        }
                        vid.dataset.containBound = '1';
                        vid.addEventListener('loadedmetadata', function() {
                            setTimeout(applyLandingVideoContain, 150);
                        });
                    });
                    applyLandingVideoContain();
                }

                function scheduleContainAfterAlign() {
                    bindLandingVideos();
                    setTimeout(applyLandingVideoContain, 150);
                }

                document.addEventListener('DOMContentLoaded', scheduleContainAfterAlign);
                window.addEventListener('load', function() {
                    bindLandingVideos();
                    setTimeout(applyLandingVideoContain, 1100);
                });
                window.addEventListener('resize', scheduleContainAfterAlign);
            })();
        </script>
    @endonce
@endif
