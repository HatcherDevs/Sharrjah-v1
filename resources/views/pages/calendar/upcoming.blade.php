@extends('pages.master')

@section('css')
    <style>
        .box-links.en a {
            background-image: url({{ asset('public/img/box-list-arrow-left.png') }}) !important;
        }
        .box-links.ar a {
            background-image: url({{ asset('public/img/box-list-arrow-right.png') }}) !important;
        }
    </style>
@endsection

@section('content')
    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="rtl">
                    <div class="col-md-6 text-right">
                        <div class="breadcrumbs">
                            @include('partials.breadcrumbs-ar')
                        </div>
                        <h1 class="short-title">الفعاليات المقبلة</h1>
                        {!! $page->content_ar !!}
                    </div>
                    <div class="col-md-6 text-left">
                        <div class="breadcrumbs en">
                            @include('partials.breadcrumbs')
                        </div>
                        <h1 class="en">Upcoming Events</h1>
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
        @include('partials.slide-images')

        <div class="container text-center">
            <div class="body-section contents">
                @if($page->page_type=="list")
                    @include('partials.lists.no-img')
                @elseif($page->page_type=="list-image")
                    @include('partials.lists.with-img')
                @endif
            </div>
        </div>

        <div class="container text-center">
            <div class="body-section contents">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 text-left" style="margin-top:0">
                        <div class="box-links en">
                            <ul style="padding:0;list-style: none">
                                <li><a style="    height: auto;
    line-height: 17px;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 30px;
    padding-right: 0;
    width: 200px;" href="{{ url('pages/programs/calendar/previous-events') }}"><span class="ar">الفعاليات السابقة <br/>PREVIOUS EVENTS</span></a></li>
                            <ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

