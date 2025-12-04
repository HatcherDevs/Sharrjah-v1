@extends('pages.master')

@section('content')
    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="rtl">
                    <div class="col-md-6 text-right">
                        <div class="breadcrumbs">
                            @include('partials.breadcrumbs-ar')
                        </div>
                        <h1>{!!  $post->title_ar !!}</h1>
                        @if(!count($post->sliders))
                            {!! $post->content_ar !!}
                        @endif
                    </div>
                    <div class="col-md-6 text-left">
                        <div class="breadcrumbs en">
                            @include('partials.breadcrumbs')
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
                @if(count($page->sliders)>0)
                    <div class="container text-center">
                        <div class="body-section contents with-img-header">

                            @if(count($page->sliders)>1)
                                <div class="owl-carousel-holder">
                                    <div class="arrows">
                                        <button class="prev float-left"></button>
                                        <button class="next float-right"></button>
                                    </div>
                                    <div class="owl-carousel owl-theme">
                                        @foreach($page->sliders as $slide)
                                            @if($slide->landscape)
                                                <div class="item">
                                                    <img src="{{ url('public/'.$slide->original->url) }}" data-en="{{ $slide->original->caption }}" data-ar="{{ $slide->original->caption_ar }}">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div id="owl-caption"></div>
                                    <div id="owl-dots"></div>
                                </div>
                            @endif

                            <div class="row" dir="rtl">
                                @if(count($page->sliders)==1)
                                    <div class="col-md-12">
                                        <img src="{{ url('public/'.$page->slider->original->url) }}" width="100%" class="featured-img">
                                        <span class="imgcap">
                            <span class="en float-left">{{ $page->slider->original->caption }}</span>
                            <span dir="rtl" class="float-right">{{ $page->slider->original->caption_ar }}</span>
                        </span>
                                        <br/>
                                        <br/>
                                    </div>
                                @endif
                                <div class="col-md-6 text-right">
                                    {!! $page->content_ar !!}
                                </div>
                                <div class="col-md-6 text-left">
                                    {!! $page->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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

    </div>
@endsection

