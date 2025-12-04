@extends('pages.master')

@section('content')

    <div class="row" style="position: absolute;
    top: 0;
    z-index: 111;
    width: 100%;
    left: 0;
    font-size: 10px;
    padding: 0;margin:0;">
        <div class="col-md-12 alert alert-warning" style="padding: 0;text-align: center;">
            THIS IS A PREVIEW
        </div>
    </div>

    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="rtl">
                    <div class="col-md-6 text-right">
                        <div class="breadcrumbs">
                            @include('partials.breadcrumbs-ar')
                        </div>
                        <h1>{!!  $page->name_ar !!}</h1>
                        @if(!count($page->sliders))
                            {!! $page->content_ar !!}
                        @endif
                    </div>
                    <div class="col-md-6 text-left">
                        <div class="breadcrumbs en">
                            @include('partials.breadcrumbs')
                        </div>
                        <h1 class="en">{!! $page->name !!}</h1>
                        @if(!count($page->sliders))
                            {!! $page->content !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(count($page->sliders))
            @include('partials.slide-images')
        @endif

        @if($page->page_type=="main")
            <div class="container text-center">
                <div class="body-section contents">
                    <div class="row">
                        <ul class="pages-list">
                            @foreach($page->children as $child)
                                <li><a href="{{ url($child->link) }}">{{ $child->name_ar }}<br><span class="en">{{ $child->name }}</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        @elseif($page->page_type=="list")
            <div class="container text-center">
                <div class="body-section contents">
                    <ul class="figure-list">
                        @include('partials.lists.no-img')
                    </ul>
                    {{ $data->links() }}
                </div>
            </div>


        @elseif($page->page_type=="list-one-lang")

            <div class="container text-center">
                <div class="body-section contents">
                    <ul class="figure-list full full-items">
                        @foreach($data as $child)
                            <li class="al-right">
                                <div class="colm titles">
                                    @if($child->title_ar)
                                        <div class="title clearfix" dir="rtl">
                                            <a href="{{ $child->linkAr }}">
                                                <strong><span class="ar">{{ $child->title_ar }}</span></strong><br/>
                                                <span class="ar">{{ $child->description_ar }}</span> {{ $child->description }}<br/>
                                                @if($child->publish_date)
                                                    <span class="ar">{{ $pageService->getArabicDate($child->publish_date->format('d'),intval($child->publish_date->format('m')),$child->publish_date->format('Y')) }}</span>
                                                @endif
                                            </a>
                                        </div>
                                    @else
                                        <div class="title clearfix">
                                            <a href="{{ $child->link }}">
                                            <span class="en" dir="ltr"><strong>{{ $child->title }}</strong><br/>
                                                {{ $child->description }}<br/>
                                                @if($child->publish_date)
                                                    {{ $child->publish_date->format('F d, Y') }}
                                                @endif
                                            </span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    {{ $data->links() }}
                </div>
            </div>

        @elseif($page->page_type=="list-image")
            <div class="container text-center">
                <div class="body-section contents">
                    <ul class="figure-list">
                        @include('partials.lists.with-img')
                    </ul>
                    {{ $data->links() }}
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


        @if($page->additional_content_bottom)
            <div class="container text-center">
                <div class="body-section contents with-img-header">
                    <div class="row" dir="rtl">
                        <div class="col-md-12 text-left">
                            {!! $page->additional_content_bottom !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>
@endsection

