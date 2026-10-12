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
    <div id="videoholder" class="videoholder landing-display-{{ $displayTarget }}"
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
@endif
