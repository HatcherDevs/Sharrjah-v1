@extends('pages.master')

@section('css')
    <style>
        .lang-switch {
            font-size: 12px;
        }
    </style>
@endsection

@section('content')
    @php
        $isArabic = isset($_GET['lang']) && $_GET['lang'] == 'ar';
                //  dd();
    @endphp

    <div class="innerpage">

        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="{{ $isArabic ? 'rtl' : 'ltr' }}">
                    <div class="col-md-12 {{ $isArabic ? 'text-right' : 'text-left' }}">
                        @if ($isArabic)
                            <div class="breadcrumbs">
                                @include('partials.breadcrumbs-ar')
                            </div>
                        @else
                            <div class="breadcrumbs en">
                                @include('partials.breadcrumbs')
                            </div>
                        @endif

                        <div class="m-0 {{ $isArabic ? 'text-left' : 'text-right' }}">
                            @if ($isArabic)
                                <a class="lang-switch" href="{{ url('pages/' . $page->slug) }}">Switch to English</a>
                            @else
                                <a class="lang-switch" href="{{ url('pages/' . $page->slug) }}?lang=ar">التبديل إلى اللغة
                                    العربية</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($isArabic)
                        <div class="col-md-12 text-right">
                            <h1>{!! $page->name_ar !!}</h1>
                        </div>
                    @else
                        <div class="col-md-12 text-left">
                            <h1 class="en">{!! $page->name !!}</h1>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (($isArabic && $page->additional_content_ar_top) || (!$isArabic && $page->additional_content_top))
            <div class="container text-center">
                <div class="body-section contents with-img-header">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $isArabic ? $page->additional_content_ar_top : $page->additional_content_top !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row">
                    @if ($isArabic)
                        <div class="col-md-12 text-right cairo">
                            @if (!$page->sliders || $page->sliders->count() == 0)
                                {!! $page->content_ar !!}
                            @endif
                        </div>
                    @else
                        <div class="col-md-12 text-left">
                            @if (!$page->sliders || $page->sliders->count() == 0)
                                {!! $page->content !!}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if ($page->sliders && $page->sliders->count() > 0)
            @include('partials.slide-images-one-lang')
        @endif

        @inject('pageService', 'App\Services\PageService')
        <div class="container text-center">
            <div class="body-section contents">
                <ul class="figure-list full full-items">
                    @foreach ($data ?? [] as $child)
                        <li class="al-right">
                            <div class="colm titles">
                                @if ($isArabic)
                                    <div class="title clearfix" dir="rtl">
                                        <a href="{{ $child->linkAr }}"
                                            {{ $child->pageType['type'] == 'url' || $child->pageType['type'] == 'file' ? 'target="_blank"' : '' }}>
                                            <strong><span class="ar">{{ $child->title_ar }}</span></strong><br />
                                            <span class="ar">{{ $child->description_ar }}</span><br />
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
                                            <span class="en" dir="ltr">
                                                <strong>{{ $child->title }}</strong><br />
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
                @if ($data)
                    {{ $data->links('vendor.pagination.bootstrap-3') }}
                @endif
            </div>
        </div>

        @if (isset($formdata) && $formdata)
            <div class="container text-center">
                <div class="body-section contents">
                    @include('partials.form')
                </div>
            </div>
        @endif

        @if (($isArabic && $page->additional_content_ar_bottom) || (!$isArabic && $page->additional_content_bottom))
            <div class="container text-center">
                <div class="body-section contents with-img-header">
                    <div class="row">
                        <div class="col-md-12">

                            {!! $isArabic ? $page->additional_content_ar_bottom : $page->additional_content_bottom !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
