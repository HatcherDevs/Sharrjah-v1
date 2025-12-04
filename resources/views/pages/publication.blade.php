@extends('pages.master')

@section('content')
    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="rtl">
                    @if(isset($_GET['lang']))
                        @if($_GET['lang']=='ar')
                            <div class="col-md-12 text-right">
                                <div class="breadcrumbs">
                                    @include('partials.breadcrumbs-ar')
                                </div>
                                <h1>{!!  $post->title_ar !!}</h1>
                                <h3 class="ar">{!! $post->author_ar !!}</h3>
                                <h3 class="ar">{!! $post->publication_ar !!}</h3>
                                @if(!count($post->sliders))
                                    {!! $post->content_ar !!}
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="col-md-12 text-left">
                            <div class="breadcrumbs en">
                                @include('partials.breadcrumbs')
                            </div>
                            <h1 class="en">{!! $post->title !!}</h1>
                            <h3 class="en">{!! $post->author !!}</h3>
                            <h3 class="en">{!! $post->publication !!}</h3>
                            @if(!count($post->sliders))
                                {!! $post->content !!}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if(count($post->sliders))
            <?php $page = $post; ?>
                @if(count($page->sliders)>0)
                <div class="container text-center">
                    <div class="body-section contents with-img-header">

                        @if(count($page->sliders)>1)
                            mama
                            <div class="owl-carousel-holder">
                                <div class="arrows">
                                    <button class="prev float-left"></button>
                                    <button class="next float-right"></button>
                                </div>
                                <div class="owl-carousel owl-theme">
                                    @foreach($page->sliders as $slide)
                                        mama
                                        @if($page->parent->slug=="partners")
                                            @if($slide->original)
                                                <div class="item">
                                                    <img src="{{ url('public/'.$slide->original->url) }}" data-en="{{ $slide->original->caption }}" data-ar="{{ $slide->original->caption_ar }}">
                                                </div>
                                            @endif
                                        @else
                                            @if($slide->landscape)
                                                <div class="item">
                                                    <img src="{{ url('public/'.$slide->landscape->url) }}" data-en="{{ $slide->landscape->caption }}" data-ar="{{ $slide->landscape->caption_ar }}">
                                                </div>
                                            @endif
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
                                    @if($page->parent->slug=="partners")
                                        @if($page->slider->original)
                                            <img src="{{ url('public/'.$page->slider->original->url) }}" width="100%">
                                            <span class="imgcap">
                                    <span class="en float-left">{{ $page->slider->original->caption }}</span>
                                    <span dir="rtl" class="float-right">{{ $page->slider->original->caption_ar }}</span>
                                </span>
                                        @endif
                                    @else
                                        @if($page->slider->landscape)
                                            <img src="{{ url('public/'.$page->slider->landscape->url) }}" width="100%" class="featured-img">
                                            <span class="imgcap">
                                    <span class="en float-left">{{ $page->slider->landscape->caption }}</span>
                                    <span dir="rtl" class="float-right">{{ $page->slider->landscape->caption_ar }}</span>
                                </span>
                                        @endif
                                    @endif


                                    <br/>
                                    <br/>
                                </div>
                            @endif

                            @if(isset($_GET['lang']))
                                @if($_GET['lang']=='ar')
                                    <div class="col-md-12 text-right">
                                        {!! $page->content_ar !!}
                                    </div>
                                @endif
                            @else
                                <div class="col-md-12 text-left">
                                    {!! $page->content !!}
                                </div>
                            @endif

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

    </div>
@endsection

