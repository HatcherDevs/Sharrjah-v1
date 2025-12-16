@extends('pages.master')

@section('css')
    <style>
        .title {
            font-size: 20px;
            margin: 15px 0;
        }

        .author {}

        .publication,
        .author {
            font-size: 16px;
            font-weight: bold;
        }

        .publication {
            font-size: 12px;
            font-weight: normal;
            color: #969696;
        }

        .content {
            font-size: 16px;
            font-weight: normal;
            margin-bottom: 30px;
        }

        .column-box .ar {
            font-family: 'Tahoma' !important;
        }

        .publish_date {
            font-size: 12px;
            font-weight: normal;
            color: #969696;
            font-style: italic;
            margin-top: 10px;
        }

        .column-box {
            line-height: 22px;
            max-height: 480px;
            height: 380px;
            overflow: hidden;
        }

        #sort-form input,
        #sort-form select {
            outline: none !important;
            font-size: 16px;
            background-color: transparent;
            border: 3px solid #000;
            height: 40px;
            line-height: 36px;
            padding: 0 10px;
            width: 100%;
        }

        .select-style {
            padding: 0;
            margin: 0;
            width: 100%;
            background-color: #fff;
            background-size: 20px auto;
            background-image: url({{ asset('public/img/icons/arrow-down-black-thin.png') }});
            background-repeat: no-repeat;
            background-position: 94% center;
        }

        .select-style.ar {
            background-position: 6% center;
        }

        .select-style.ar select {
            line-height: 26px !important;
            padding-left: 35px !important;
            padding-right: 10px !important;
        }

        .select-style select {
            padding: 5px 8px;
            width: 130%;
            border: none;
            box-shadow: none;
            background-color: transparent;
            background-image: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0;
            padding-right: 35px !important;
        }

        .select-style select:focus {
            outline: none;
        }

        #sort-form input[type=submit] {
            font-size: 16px;
            line-height: 37px;
            border: 0;
            height: 37px;
        }

        #sort-form input[type=submit]:hover {
            background-color: #fff !important;
        }

        .lang-switch {
            font-size: 12px;
            height: 34px;
            line-height: 34px;
            display: block;
            text-transform: uppercase;
        }

        .column-box img {
            border: 3px solid #000;
        }

        .select-style select {
            display: block;
        }

        #sort-form input,
        #sort-form select {
            margin-bottom: 10px;
        }

        .owl-carousel-holder .arrows .prev {
            left: -80px;
            position: absolute;
            background-image: url({{ asset('public/img/store-arrow-left.png') }});
        }

        .owl-carousel-holder .arrows .next {
            right: -80px;
            position: absolute;
            background-image: url({{ asset('public/img/store-arrow-right.png') }});
        }

        @media only screen and (min-width: 1520px) {
            .column-box {
                height: 460px;
            }
        }

        @media only screen and (max-width: 1120px) {

            .owl-carousel-holder .arrows .prev {
                left: 30px;
            }

            .owl-carousel-holder .arrows .next {
                right: 30px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="innerpage">

        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="rtl">
                    @if (isset($_GET['lang']))
                        @if ($_GET['lang'] == 'ar')
                            <div class="col-md-12 text-right">
                                <div class="breadcrumbs">
                                    @include('partials.breadcrumbs-ar')
                                </div>
                                @include('partials.podcast-language')
                                <h1>{!! $page->name_ar !!}</h1>
                                @if (!$page->sliders || $page->sliders->count() == 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            {!! $page->content_ar !!}
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <br />
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="col-md-12 text-left">
                            <div class="breadcrumbs en">
                                @include('partials.breadcrumbs')
                            </div>

                            @include('partials.podcast-language')
                            <h1 class="en">{!! $page->name !!}</h1>
                            @if (!$page->sliders || $page->sliders->count() == 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! $page->content !!}
                                    </div>
                                </div>
                                <br />
                                <br />
                                <br />
                            @endif

                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                @if ($page->sliders && $page->sliders->count() > 1)
                    <div class="owl-carousel-holder">
                        <div class="arrows">
                            <button class="prev float-left"></button>
                            <button class="next float-right"></button>
                        </div>
                        <div class="owl-carousel owl-theme">
                            @foreach ($page->sliders as $slide)
                                @if ($page->parent->slug == 'partners')
                                    @if ($slide->original)
                                        <div class="item">
                                            <img src="{{ url('public/' . $slide->original->url) }}"
                                                data-en="{{ $slide->original->caption }}"
                                                data-ar="{{ $slide->original->caption_ar }}">
                                        </div>
                                    @endif
                                @else
                                    @if ($slide->landscape)
                                        <div class="item">
                                            <img src="{{ url('public/' . $slide->landscape->url) }}"
                                                data-en="{{ $slide->landscape->caption }}"
                                                data-ar="{{ $slide->landscape->caption_ar }}">
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <div id="owl-caption"></div>
                        <div id="owl-dots"></div>
                    </div>
                @endif

                <div class="row" dir="">
                    @if ($page->sliders && $page->sliders->count() == 1)
                        <div class="col-md-12">
                            @if ($page->parent->slug == 'partners')
                                @if ($page->slider->original)
                                    <img src="{{ url('public/' . $page->slider->original->url) }}" width="100%">
                                    <span class="imgcap">
                                        <span class="en float-left">{{ $page->slider->original->caption }}</span>
                                        <span dir="rtl"
                                            class="float-right">{{ $page->slider->original->caption_ar }}</span>
                                    </span>
                                @endif
                            @else
                                @if ($page->slider->landscape)
                                    <img src="{{ url('public/' . $page->slider->landscape->url) }}" width="100%"
                                        class="featured-img">
                                    <span class="imgcap">
                                        <span class="en float-left">{{ $page->slider->landscape->caption }}</span>
                                        <span dir="rtl"
                                            class="float-right">{{ $page->slider->landscape->caption_ar }}</span>
                                    </span>
                                @endif
                            @endif
                            <br />
                            <br />
                        </div>
                    @endif
                    <div class="col-md-12 <?php echo isset($_GET['lang']) ? 'text-right cairo' : 'text-left'; ?>" <?php echo isset($_GET['lang']) ? 'dir="rtl"' : ''; ?>>
                        {!! isset($_GET['lang']) ? $page->content_ar : $page->content !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="container text-center">
            <div class="body-section contents" <?php echo isset($_GET['lang']) ? 'dir="rtl"' : ''; ?>>

                <div class="row">
                    @foreach ($data as $collectionId => $collectionItems)
                        <div class="col-md-12">
                            @php
                                // Retrieve the collection category details based on the collection_id
                                $collectionCategory = App\Models\CollectionCategory::find($collectionId);
                                $collectionName = $collectionCategory ? $collectionCategory->name : '';
                                $collectionNameAr = $collectionCategory ? $collectionCategory->name_ar : '';

                            @endphp
                            <br />
                            <br />
                            <h3 style="font-weight:bold;text-align: <?php echo isset($_GET['lang']) ? 'right' : 'left'; ?>"><?php echo isset($_GET['lang']) ? $collectionNameAr : $collectionName; ?> </h3>
                            <br />

                            <div class="row">
                                @foreach ($collectionItems as $item)
                                    @if ($_GET['lang'] == 'ar')
                                        <div class="col-md-4 col-sm-6 text-right column-box"
                                            style="margin-bottom: 15px !important;">
                                        @else
                                            <div class="col-md-4 col-sm-6 text-left column-box"
                                                style="margin-bottom: 15px !important;">
                                    @endif

                                    @if (isset($_GET['lang']) && $_GET['lang'] == 'ar')
                                        <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                            {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                                        @else
                                            <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                                {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                                    @endif

                                    @if ($item->sliders->count() > 0 && $item->sliders[0]->landscape)
                                        <img src="{{ asset('public/' . $item->sliders[0]->landscape->url) }}"
                                            width="100%">
                                    @else
                                        <img src="{{ asset('public/img/placeholder-square.jpg') }}" width="100%">
                                    @endif
                                    </a>
                                    @if (isset($_GET['lang']) && $_GET['lang'] == 'ar')
                                        <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                            {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>

                                            <div class="title ar">{{ $item->title_ar }}</div>
                                        </a>
                                    @else
                                        <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                            {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>

                                            <div class="title en">{{ $item->title }}</div>
                                        </a>
                                    @endif
                            </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        {{--                 
                <div class="row">
                    @foreach ($data as $item)
                        @if ($_GET['lang'] == 'ar')
                            <div class="col-md-4 col-sm-6 text-right column-box" style="margin-bottom: 15px !important;">
                            @else
                                <div class="col-md-4 col-sm-6 text-left column-box"
                                    style="margin-bottom: 15px !important;;">
                        @endif

                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                    {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                            @endif
                        @else
                            <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                        @endif

                        @if (count($item->sliders[0]))
                            @if ($item->sliders[0]->landscape)
                                <img src="{{ asset('public/' . $item->sliders[0]->landscape->url) }}" width="100%">
                            @else
                                <img src="{{ asset('public/img/placeholder-square.jpg') }}" width="100%">
                            @endif
                        @else
                            <img src="{{ asset('public/img/placeholder-square.jpg') }}" width="100%">
                        @endif
                        </a>
                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <a href="/pages/about/contributors/{{ $series }}">
                                    <div class="publish_date en">{{ $item->artist_ar }}</div>
                                </a>

                                <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                    {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>

                                    <div class="title ar">{{ $item->title_ar }}</div>
                                </a>


                               
                            @endif
                        @else
                            <a href="/pages/about/contributors/{{ $series }}">

                                <div class="publish_date en">{{ $item->artist }}</div>
                            </a>
                            

                            <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>


                                <div class="title en">{{ $item->title }}</div>

                            </a>
                    
                        @endif


                </div>
                @endforeach

            </div> --}}

        <br />

        @if (isset($upcoming) && count($upcoming) > 0)
            <div class="<?php echo isset($_GET['lang']) ? 'text-right' : 'text-left'; ?>" <?php echo isset($_GET['lang']) ? 'dir="rtl"' : ''; ?>>
                <h3 style="font-weight:bold;text-align: <?php echo isset($_GET['lang']) ? 'right' : 'left'; ?>"><?php echo isset($_GET['lang']) ? 'الفعاليات القادمة' : 'UPCOMING EVENTS'; ?> </h3>
                <br />
                <div style="text-align: <?php echo isset($_GET['lang']) ? 'right' : 'left'; ?>">
                    @foreach ($upcoming as $item)
                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                    {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                            @endif
                        @else
                            <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                        @endif
                        </a>

                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <h4 style="font-weight:bold;text-transform: uppercase;">{{ $item->title_ar }}</h4>
                                <p>{{ is_string($item->publish_date) ? \Carbon\Carbon::parse($item->publish_date)->format('d-m-Y') : $item->publish_date->format('d-m-Y') }}
                                </p>
                                <p>{{ $item->excerpt }}</p>
                            @else
                                <h4 style="font-weight:bold;text-transform: uppercase;">{{ $item->title }}</h4>
                                <p>{{ is_string($item->publish_date) ? \Carbon\Carbon::parse($item->publish_date)->format('d-m-Y') : $item->publish_date->format('d-m-Y') }}
                                </p>
                                <p>{{ $item->excerpt_ar }}</p>
                            @endif
                        @endif

                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                    {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                            @endif
                        @else
                            <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                        @endif
                        <br />

                        {{ isset($_GET['lang']) ? 'اقرأ أكثر' : 'READ MORE' }}</a>
                        <hr />
                    @endforeach
                </div>
            </div>
        @endif


        <hr />
        @if (isset($opencalls) && count($opencalls) > 0)
            <div class="<?php echo isset($_GET['lang']) ? 'text-right' : 'text-left'; ?>" <?php echo isset($_GET['lang']) ? 'dir="rtl"' : ''; ?>>
                <h3 style="font-weight:bold;text-align: <?php echo isset($_GET['lang']) ? 'right' : 'left'; ?> <?php echo isset($_GET['lang']) ? 'font-family:"Cairo"' : ''; ?>">
                    {{ isset($_GET['lang']) ? ' OPEN CALL' : 'OPEN CALL' }}</h3>
                <br />
                <div style="text-align: <?php echo isset($_GET['lang']) ? 'right' : 'left'; ?>">
                    @foreach ($opencalls as $opencallsitem)
                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <a href="{{ $opencallsitem->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                    {!! $opencallsitem->pageType['type'] == 'file'
                                        ? 'download="' . $opencallsitem->fileDataAr->original_name . '"'
                                        : '' !!} {!! $opencallsitem->pageType['type'] == 'url' || $opencallsitem->pageType['type'] == 'file'
                                        ? 'target="_blank"'
                                        : '' !!}>
                            @endif
                        @else
                            <a href="{{ $opencallsitem->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                {!! $opencallsitem->pageType['type'] == 'file'
                                    ? 'download="' . $opencallsitem->fileData->original_name . '"'
                                    : '' !!} {!! $opencallsitem->pageType['type'] == 'url' || $opencallsitem->pageType['type'] == 'file'
                                    ? 'target="_blank"'
                                    : '' !!}>
                        @endif
                        </a>

                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <h4 style="font-weight:bold;text-transform: uppercase;">{{ $opencallsitem->title_ar }}
                                </h4>
                                <p>{{ is_string($opencallsitem->publish_date) ? \Carbon\Carbon::parse($opencallsitem->publish_date)->format('d-m-Y') : $opencallsitem->publish_date->format('d-m-Y') }}
                                </p>
                                {{--                                                            <p>{{ $item->excerpt }}</p> --}}
                            @else
                                <h4 style="font-weight:bold;text-transform: uppercase;">{{ $opencallsitem->title }}
                                </h4>
                                <p>{{ is_string($opencallsitem->publish_date) ? \Carbon\Carbon::parse($opencallsitem->publish_date)->format('d-m-Y') : $opencallsitem->publish_date->format('d-m-Y') }}
                                </p>
                                {{--                                                            <p>{{ $item->excerpt_ar }}</p> --}}
                            @endif
                        @else
                            <h4 style="font-weight:bold;text-transform: uppercase;">{{ $opencallsitem->title }}</h4>
                            <p>{{ is_string($opencallsitem->publish_date) ? \Carbon\Carbon::parse($opencallsitem->publish_date)->format('d-m-Y') : $opencallsitem->publish_date->format('d-m-Y') }}
                            </p>
                            {{--                                                        <p>{{ $item->excerpt }}</p> --}}
                        @endif

                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <a href="{{ $opencallsitem->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                    {!! $item->pageType['type'] == 'file' ? 'download="' . $opencallsitem->fileDataAr->original_name . '"' : '' !!} {!! $opencallsitem->pageType['type'] == 'url' || $opencallsitem->pageType['type'] == 'file'
                                        ? 'target="_blank"'
                                        : '' !!}>
                            @endif
                        @else
                            <a href="{{ $opencallsitem->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                {!! $opencallsitem->pageType['type'] == 'file'
                                    ? 'download="' . $opencallsitem->fileData->original_name . '"'
                                    : '' !!} {!! $opencallsitem->pageType['type'] == 'url' || $opencallsitem->pageType['type'] == 'file'
                                    ? 'target="_blank"'
                                    : '' !!}>
                        @endif
                        <br />

                        {{ isset($_GET['lang']) ? 'اقرأ أكثر' : 'READ MORE' }}</a>
                        <hr />
                    @endforeach
                </div>
            </div>
        @endif
        @if (isset($workshops) && count($workshops) > 0)
            <div class="<?php echo isset($_GET['lang']) ? 'text-right' : 'text-left'; ?>" <?php echo isset($_GET['lang']) ? 'dir="rtl"' : ''; ?>>
                <h3 style="font-weight:bold;text-align: <?php echo isset($_GET['lang']) ? 'right' : 'left'; ?> <?php echo isset($_GET['lang']) ? 'font-family:"Cairo"' : ''; ?>">
                    {{ isset($_GET['lang']) ? ' WORKSHOPS' : 'WORKSHOPS' }}</h3>
                <br />
                <div style="text-align: <?php echo isset($_GET['lang']) ? 'right' : 'left'; ?>">
                    @foreach ($workshops as $item)
                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                    {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                            @endif
                        @else
                            <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                        @endif
                        </a>

                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <h4 style="font-weight:bold;text-transform: uppercase;">{{ $item->title_ar }}</h4>
                                <p>{{ is_string($item->publish_date) ? \Carbon\Carbon::parse($item->publish_date)->format('d-m-Y') : $item->publish_date->format('d-m-Y') }}
                                </p>
                                {{--                                                            <p>{{ $item->excerpt }}</p> --}}
                            @else
                                <h4 style="font-weight:bold;text-transform: uppercase;">{{ $item->title }}</h4>
                                <p>{{ is_string($item->publish_date) ? \Carbon\Carbon::parse($item->publish_date)->format('d-m-Y') : $item->publish_date->format('d-m-Y') }}
                                </p>
                                {{--                                                            <p>{{ $item->excerpt_ar }}</p> --}}
                            @endif
                        @else
                            <h4 style="font-weight:bold;text-transform: uppercase;">{{ $item->title }}</h4>
                            <p>{{ is_string($item->publish_date) ? \Carbon\Carbon::parse($item->publish_date)->format('d-m-Y') : $item->publish_date->format('d-m-Y') }}
                            </p>rbon::parse($item->publish_date)->format('d-m-Y') : $item->publish_date->format('d-m-Y') }}
                            </p>
                            {{--                                                        <p>{{ $item->excerpt }}</p> --}}
                        @endif

                        @if (isset($_GET['lang']))
                            @if ($_GET['lang'] == 'ar')
                                <a href="{{ $item->linkAr }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                    {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileDataAr->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                            @endif
                        @else
                            <a href="{{ $item->link }}{{ isset($_GET['lang']) ? '?lang=ar' : '' }}"
                                {!! $item->pageType['type'] == 'file' ? 'download="' . $item->fileData->original_name . '"' : '' !!} {!! $item->pageType['type'] == 'url' || $item->pageType['type'] == 'file' ? 'target="_blank"' : '' !!}>
                        @endif
                        <br />

                        {{ isset($_GET['lang']) ? 'اقرأ أكثر' : 'READ MORE' }}</a>
                        <hr />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    </div>

    @if ($formdata)
        <div class="container text-center">
            <div class="body-section contents">
                @include('partials.form')
            </div>
        </div>
    @endif


    @if ($page->additional_content_bottom)
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


@section('js')
    <script>
        // function selectY(){
        // var x, i, j, l, ll, selElmnt, a, b, c;
        // /* Look for any elements with the class "custom-select": */
        // x = document.getElementsByClassName("select-style");
        // l = x.length;
        // for (i = 0; i < l; i++) {
        //     selElmnt = x[i].getElementsByTagName("select")[0];
        //     ll = selElmnt.length;
        //     /* For each element, create a new DIV that will act as the selected item: */
        //     a = document.createElement("DIV");
        //     a.setAttribute("class", "select-selected");
        //     a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        //     x[i].appendChild(a);
        //     /* For each element, create a new DIV that will contain the option list: */
        //     b = document.createElement("DIV");
        //     b.setAttribute("class", "select-items select-hide");
        //     for (j = 1; j < ll; j++) {
        //         /* For each option in the original select element,
        //         create a new DIV that will act as an option item: */
        //         c = document.createElement("DIV");
        //         c.innerHTML = selElmnt.options[j].innerHTML;
        //         c.addEventListener("click", function(e) {
        //             /* When an item is clicked, update the original select box,
        //             and the selected item: */
        //             var y, i, k, s, h, sl, yl;
        //             s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        //             sl = s.length;
        //             h = this.parentNode.previousSibling;
        //             for (i = 0; i < sl; i++) {
        //                 if (s.options[i].innerHTML == this.innerHTML) {
        //                     s.selectedIndex = i;
        //                     h.innerHTML = this.innerHTML;
        //                     y = this.parentNode.getElementsByClassName("same-as-selected");
        //                     yl = y.length;
        //                     for (k = 0; k < yl; k++) {
        //                         y[k].removeAttribute("class");
        //                     }
        //                     this.setAttribute("class", "same-as-selected");
        //                     break;
        //                 }
        //             }
        //             h.click();
        //         });
        //         b.appendChild(c);
        //     }
        //     x[i].appendChild(b);
        //     a.addEventListener("click", function(e) {
        //         /* When the select box is clicked, close any other select boxes,
        //         and open/close the current select box: */
        //         e.stopPropagation();
        //         closeAllSelect(this);
        //         this.nextSibling.classList.toggle("select-hide");
        //         this.classList.toggle("select-arrow-active");
        //     });
        // }
        //
        // function closeAllSelect(elmnt) {
        //     /* A function that will close all select boxes in the document,
        //     except the current select box: */
        //     var x, y, i, xl, yl, arrNo = [];
        //     x = document.getElementsByClassName("select-items");
        //     y = document.getElementsByClassName("select-selected");
        //     xl = x.length;
        //     yl = y.length;
        //     for (i = 0; i < yl; i++) {
        //         if (elmnt == y[i]) {
        //             arrNo.push(i)
        //         } else {
        //             y[i].classList.remove("select-arrow-active");
        //         }
        //     }
        //     for (i = 0; i < xl; i++) {
        //         if (arrNo.indexOf(i)) {
        //             x[i].classList.add("select-hide");
        //         }
        //     }
        // }
        //
        // /* If the user clicks anywhere outside the select box,
        // then close all select boxes: */
        // document.addEventListener("click", closeAllSelect);
        // }
    </script>
@endsection
