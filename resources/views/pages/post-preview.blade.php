@extends('pages.master')

@section('content')
    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row">
                    <div class="col-md-12 alert alert-info">
                        THIS IS A PREVIEW
                    </div>
                </div>
                <div class="row" dir="rtl">
                    <div class="col-md-6 text-right">
                        <div class="breadcrumbs">
                        </div>
                        <h1>{!!  $post->title_ar !!}</h1>
                        @if(!count($post->sliders))
                            {!! $post->content_ar !!}
                        @endif
                    </div>
                    <div class="col-md-6 text-left">
                        <div class="breadcrumbs en">
                        </div>
                        <h1 class="en">{!! $post->title !!}</h1>
                        @if(!count($post->sliders))
                            {!! $post->content !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(count($post->sliders))
            <?php $page = $post; ?>
            @include('partials.slide-images')
        @endif

        @if($post->additional_content_bottom)
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

        @if($formdata)
            <div class="container text-center">
                <div class="body-section contents">
                    @include('partials.form')
                </div>
            </div>
        @endif

        @if(count($relatedPages['pages']) || count($relatedPages['posts'])  )
            <div class="container text-center">
                <div class="body-section related-links">
                    <div class="row" dir="rtl">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            الصفحات المرتبطة
                            <br/>
                            @foreach($relatedPages['pages'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->name_ar }}</a><br/>
                            @endforeach
                            @foreach($relatedPages['posts'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->title_ar }}</a><br/>
                            @endforeach
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left en">
                            RELATED PAGES
                            <br/>
                            @foreach($relatedPages['pages'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->name }}</a><br/>
                            @endforeach
                            @foreach($relatedPages['posts'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->title }}</a><br/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($post->buttonLinks)
            <div class="container text-center">
                <div class="body-section contents">
                    <div class="row" dir="rtl">
                        <div class="col-md-6 text-right">
                            @if($post->buttonLinks->title && $post->buttonLinks->value)
                                <a href="{{$post->buttonLinks->value_ar}}"><input type="submit" class="ar" value="{{ $post->buttonLinks->title_ar }}"></a>
                            @endif
                        </div>
                        <div class="col-md-6 text-left">
                            @if($post->buttonLinks->title && $post->buttonLinks->value)
                                <a href="{{$post->buttonLinks->value}}"><input type="submit" class="en" value="{{ $post->buttonLinks->title }}"></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(count($relatedPages['pages']) || count($relatedPages['posts'])  )
            <div class="container text-center">
                <div class="body-section related-links">
                    <div class="row" dir="rtl">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            الصفحات المرتبطة
                            <br/>
                            @foreach($relatedPages['pages'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->name_ar }}</a><br/>
                            @endforeach
                            @foreach($relatedPages['posts'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->title_ar }}</a><br/>
                            @endforeach
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left en">
                            RELATED PAGES
                            <br/>
                            @foreach($relatedPages['pages'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->name }}</a><br/>
                            @endforeach
                            @foreach($relatedPages['posts'] as $item)
                                <a href="{{ url($item->link) }}">{{ $item->title }}</a><br/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

