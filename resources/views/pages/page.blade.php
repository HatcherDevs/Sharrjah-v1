@extends('pages.master')

@section('css')
    <style>
        .table-bordered div,
        .table-bordered span {
            font-size: 16px !important;
            font-family: 'Roboto';
            font-weight: normal;
        }

        .table-bordered p.Body span,
        .table-bordered p.Default span {
            font-family: 'Tahoma';
        }
    </style>
@endsection

@section('content')

    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="">
                    <div class="col-md-6 text-left">
                        <div class="breadcrumbs en">
                            @include('partials.breadcrumbs')
                        </div>
                        <h1 class="en">{!! $page->name !!}</h1>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="breadcrumbs">
                            @include('partials.breadcrumbs-ar')
                        </div>
                        <h1>{!! $page->name_ar !!}</h1>
                    </div>
                </div>
            </div>
        </div>





        @if ($page->additional_content_ar_active == 0)
            @if ($page->additional_content_top)
                <div class="container text-center">
                    <div class="body-section contents with-img-header">
                        <div class="row" dir="rtl">
                            <div class="col-md-12 text-left">
                                {!! $page->additional_content_top !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            @if ($page->additional_content_top)
                <div class="container text-center">
                    <div class="body-section contents with-img-header">
                        <div class="row" dir="rtl">
                            <div class="col-md-6 text-left">
                                {!! $page->additional_content_top !!}
                            </div>
                            <div class="col-md-6 text-right">
                                {!! $page->additional_content_ar_top !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="">
                    <div class="col-md-6 text-left">
                        @if (!count($page->sliders))
                            {!! $page->content !!}
                        @endif
                    </div>
                    <div class="col-md-6 text-right cairo">
                        @if (!count($page->sliders))
                            {!! $page->content_ar !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if (count($page->sliders))
            @include('partials.slide-images')
        @endif

        @if ($page->page_type == 'main')
            <div class="container text-center">
                <div class="body-section contents">
                    <div class="row">
                        <ul class="pages-list">
                            @foreach ($page->children as $child)
                    @if ($child->active && $child->link !== 'pages/about/open-call-exhibition-designer')
                        <li><a href="{{ url($child->link) }}">{{ $child->name_ar }}<br><span
                                    class="en">{{ $child->name }}</span></a></li>
                    @endif
@endforeach
@php
    // dd($page);
@endphp
@if ($page->slug == 'about')
<li>
    <a href="{{ url('pages/about/opportunities') }}">
        <span class="ar">فرص العمل</span><br />Opportunities
    </a>
</li>
@endif
                        </ul>
                    </div>
                </div>
            </div>
        @elseif($page->page_type == 'list')
            <div class="container text-center">
                <div class="body-section contents">
                    <ul class="figure-list">
                        @include('partials.lists.no-img')
                    </ul>
                    {{ $data->links() }}
                </div>
            </div>
        @elseif($page->page_type == 'list-one-lang')
            @inject('pageService', 'App\Services\PageService')
            <div class="container text-center">
                <div class="body-section contents">
                    <ul class="figure-list full full-items">
                        @foreach ($data as $child)
                            <li class="al-right">
                                <div class="colm titles">
                                    @if (trim($child->title_ar))
                                        <div class="title clearfix" dir="rtl">
                                            <a href="{{ $child->linkAr }}"
                                                {{ $child->pageType['type'] == 'url' || $child->pageType['type'] == 'file' ? 'target="_blank"' : '' }}>
                                                <strong><span class="ar">{{ $child->title_ar }}</span></strong><br />
                                                <span class="ar">{{ $child->description_ar }}</span>
                                                {{ $child->description }}<br />
                                                @if ($child->publish_date)
                                                    <span
                                                        class="ar">{{ $pageService->getArabicDate($child->publish_date->format('d'), intval($child->publish_date->format('m')), $child->publish_date->format('Y')) }}</span>
                                                @endif
                                            </a>
                                        </div>
                                    @else
                                        <div class="title clearfix">
                                            <a href="{{ $child->link }}"
                                                {{ $child->pageType['type'] == 'url' || $child->pageType['type'] == 'file' ? 'target="_blank"' : '' }}>
                                                <span class="en"
                                                    dir="ltr"><strong>{{ $child->title }}</strong><br />
                                                    {{ $child->description }}<br />
                                                    @if ($child->publish_date)
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
        @elseif($page->page_type == 'list-image')
            <div class="container text-center">
                <div class="body-section contents">
                    <ul class="figure-list">
                        @include('partials.lists.with-img')
                    </ul>
                    {{ $data->links() }}
                </div>
            </div>
        @endif


        @if ($formdata)
            <div class="container text-center">
                <div class="body-section contents">
                    @include('partials.form')
                </div>
            </div>
        @endif


        @if ($page->additional_content_ar_active == 0)
            @if ($page->additional_content_bottom)
                <div class="container text-center">
                    <div class="body-section contents with-img-header">
                        <div class="row">
                            <div class="col-md-12">
                                {!! $page->additional_content_bottom !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            @if ($page->additional_content_bottom)
                <div class="container text-center">
                    <div class="body-section contents with-img-header">
                        <div class="row">
                            <div class="col-md-6">
                                {!! $page->additional_content_bottom !!}
                            </div>
                            <div class="col-md-6">
                                {!! $page->additional_content_ar_bottom !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif


        @if (Request::is('*/venues-and-times'))
            @php
                $additional2_content_en = json_decode($page->additional2_content_en);
                $additional2_content_ar = json_decode($page->additional2_content_ar);
                $currentImgs = json_decode($page->additional2_content_img);
            @endphp

            <div class="container text-center">
                <div class="body-section contents with-img-header">
                    <div class="row">
                        @foreach ($additional2_content_en as $i =>$value)
                            <div class="col-md-12">
                                @if($currentImgs[$i] != null)
                                    <img src="{{ url('public/'.$currentImgs[$i]) }}" class="w-100">
                                @endif
                            </div>
                            <div class="col">
                                {!! $additional2_content_en[$i] !!}
                            </div>
                            
                            @if(str_word_count(strip_tags($additional2_content_ar[$i], allowed_tags)) > 0)
                                <div class="col">
                                    {!! $additional2_content_ar[$i] !!}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif


        @if ($page->slug == contact)
            <div class="container text-center">
                <div class="body-section contents with-img-header">
                    <div class="row">
                        <div class="col-md-12">
                            <iframe class="blk-border"
                                src="https://www.google.com/maps/d/embed?mid=1T6MzzrZJQQYUhbVDosxwIZKifHqs3sVd"
                                width="100%" height="500"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
