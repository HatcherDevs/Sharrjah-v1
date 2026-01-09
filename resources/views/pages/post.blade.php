@extends('pages.master')

@section('content')
    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="">
                    <div class="col-md-6 text-left">
                        <div class="breadcrumbs en">
                            @include('partials.breadcrumbs')
                        </div>
                        @if ($post->parent->slug == 'partners' || $post->parent->slug == 'calendar')
                            <h1 class="en">{!! $post->description !!}</h1>
                        @else
                            <h1 class="en">{!! $post->title !!}</h1>
                        @endif
                        @if (!count($post->sliders))
                            {!! $post->content !!}
                        @endif
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="breadcrumbs">
                            @include('partials.breadcrumbs-ar')
                        </div>

                        @if ($post->parent->slug == 'partners' || $post->parent->slug == 'calendar')
                            <h1>{!! $post->description_ar !!}</h1>
                        @else
                            <h1>{!! $post->title_ar !!}</h1>
                        @endif

                        @if (!count($post->sliders))
                            @if ($post->parent->slug == 'open-call-exhibition-designer')
                                <style>
                                    .innerpage .contents .text-right span {
                                        font-family: 'Cairo' !important;
                                    }
                                </style>
                                <div style="font-family: 'Cairo' !important;">{!! $post->content_ar !!}</div>
                            @else
                                {!! $post->content_ar !!}
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if (count($post->sliders))
            <?php $page = $post; ?>
            @include('partials.slide-images')
        @endif

        @if ($post->additional_content_bottom)
            <div class="container text-center">
                <div class="body-section contents with-img-header">
                    <div class="row" dir="rtl">
                        <div class="col-md-12 text-left">
                            {!! $post->additional_content_bottom !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (isset($formdata) && $formdata)
            <div class="container text-center">
                <div class="body-section contents">
                    @include('partials.form')
                </div>
            </div>
        @endif

        @if ($post->buttonLinks)
            <div class="container text-center">
                <div class="body-section contents">
                    <div class="row" dir="rtl">
                        <div class="col-md-6 text-right">
                            @if ($post->buttonLinks->title && $post->buttonLinks->value)
                                <a href="{{ $post->buttonLinks->value_ar }}"><input type="submit" class="ar"
                                        value="{{ $post->buttonLinks->title_ar }}"></a>
                            @endif
                        </div>
                        <div class="col-md-6 text-left">
                            @if ($post->buttonLinks->title && $post->buttonLinks->value)
                                <a href="{{ $post->buttonLinks->value }}"><input type="submit" class="en"
                                        value="{{ $post->buttonLinks->title }}"></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (count($relatedPages['pages'] ?? []) || count($relatedPages['posts'] ?? []))
            <div class="container text-center">
                <div class="body-section related-links">
                    <div class="row" dir="rtl">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            الصفحات المرتبطة
                            <br />
                            @foreach ($relatedPages['pages'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->name_ar }}</a><br />
                            @endforeach
                            @foreach ($relatedPages['posts'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->title_ar }}</a><br />
                            @endforeach
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left en">
                            RELATED PAGES
                            <br />
                            @foreach ($relatedPages['pages'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->name }}</a><br />
                            @endforeach
                            @foreach ($relatedPages['posts'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->title }}</a><br />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
