@if ($lang == 'ar')
    <button class="backbutton" style="float:right!important">
        العودة إلى لأرشيف
    </button>
@endif
<div class="grid">
    <div class="leftColumn container">
        @if ($lang !== 'ar')
            <button class="backbutton">
                Back to repository
            </button><br>
        @endif

        @if ($repository->type_set == 'video')
            <div class="right-content vimeovid mobile-only video-placeholder" data-video-id="{{ $repository->video }}"
                style="cursor:pointer; position:relative; background:#000;">
                <img loading="lazy" src="https://vumbnail.com/{{ $repository->video }}.jpg" width="100%"
                    alt="Video thumbnail" onerror="this.src='{{ asset('public/img/video-placeholder.jpg') }}'">
                <div class="play-button"
                    style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:50px;color:#fff;">
                    ▶</div>
            </div>
        @else
            <div class="owl-carousel-holder right-content mb-3 mobile-only" dir="ltr">
                @if (count($repository->images) > 1)
                    <div class="arrows">
                        <button class="prev float-left"></button>
                        <button class="next float-right"></button>
                    </div>
                @endif
                <div class="owl-carousel owl-theme news-carousel">
                    @foreach ($repository->images as $image)
                        <div class="item"><img loading="lazy" src="{{ asset('public/' . $image->image) }}"
                                width="100%"></div>
                    @endforeach
                </div>
                <div id="owl-dots"></div>
            </div>
        @endif

        @if ($lang == 'ar')
            <h1>{{ $repository->title_ar }}</h1>
            <p><b>{{ $repository->subtitle_ar }}</b></p>
        @else
            <h1>{{ $repository->title }}</h1>
            <p><b>{{ $repository->subtitle }}</b></p>
        @endif

        @if ($lang == 'ar')
            {!! $repository->content_ar !!}
        @else
            {!! $repository->content !!}
        @endif

    </div>

    <div id="videoIframe" class="rightColumn {{ $repository->subtitle ? 'has_sub' : '' }}">
        <div class="gallery">
            <figure class="figureImg">
                @if ($repository->type_set == 'video')
                    <div class="right-content vimeovid video-placeholder" id="parent_iframe"
                        data-video-id="{{ $repository->video }}"
                        style="cursor:pointer; position:relative; background:#000;">
                        <img loading="lazy" src="https://vumbnail.com/{{ $repository->video }}.jpg" width="100%"
                            alt="Video thumbnail" onerror="this.src='{{ asset('public/img/video-placeholder.jpg') }}'">
                        <div class="play-button"
                            style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:50px;color:#fff;text-shadow:0 0 10px rgba(0,0,0,0.5);">
                            ▶</div>
                    </div>
                @else
                    <div class="owl-carousel-holder right-content mb-3" dir="ltr">
                        @if (count($repository->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($repository->images as $image)
                                <div class="item"><img src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>
                @endif
            </figure>
        </div>
    </div>
</div>
