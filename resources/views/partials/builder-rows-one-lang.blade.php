@php
    $builderRows = json_decode($page->builder_rows ?? '[]', true);
    $builderRows = is_array($builderRows) ? $builderRows : [];
@endphp

<style>
    .builder-rows-container .column-box {
        line-height: 22px;
        max-height: 480px;
        height: 480px;
        overflow: hidden;
    }

    .builder-rows-container .column-box img {
        border: 3px solid #000;
    }

    .builder-rows-container .publish_date {
        font-size: 12px;
        font-weight: normal;
        color: #969696;
        font-style: italic;
        margin-top: 10px;
    }

    .builder-rows-container .title {
        font-size: 20px;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .builder-rows-container .author {
        font-size: 16px;
        font-weight: bold;
    }

    .builder-rows-container .content {
        font-size: 16px;
        font-weight: normal;
        margin-bottom: 30px;
    }

    .builder-rows-container .column-box .ar {
        font-family: 'Tahoma' !important;
    }
</style>

@if (count($builderRows) > 0)
    <div class="container text-center builder-rows-container">
        @foreach ($builderRows as $row)
            @if (isset($row['type']) && $row['type'] == 'boxes')
                <div class="body-section contents" style="margin-top: 20px; margin-bottom: 20px;">

                    {{-- Row Header --}}
                    @if (
                        ($isArabic && !empty($row['title_ar'])) ||
                            (!$isArabic && !empty($row['title_en'])) ||
                            ($isArabic && !empty($row['subtitle_ar'])) ||
                            (!$isArabic && !empty($row['subtitle_en'])))
                        <div class="row-header"
                            style="margin-bottom: 30px; text-align: {{ $isArabic ? 'right' : 'left' }};"
                            dir="{{ $isArabic ? 'rtl' : 'ltr' }}">
                            @if ($isArabic && !empty($row['title_ar']))
                                <h2 style="color: #222; font-weight: bold;">{{ $row['title_ar'] }}</h2>
                            @elseif(!$isArabic && !empty($row['title_en']))
                                <h2 class="en" style="color: #222; font-weight: bold;">{{ $row['title_en'] }}</h2>
                            @endif

                            @if ($isArabic && !empty($row['subtitle_ar']))
                                <h4 style="color: #666;">{{ $row['subtitle_ar'] }}</h4>
                            @elseif(!$isArabic && !empty($row['subtitle_en']))
                                <h4 class="en" style="color: #666;">{{ $row['subtitle_en'] }}</h4>
                            @endif
                        </div>
                    @endif

                    {{-- Row Items (Boxes) --}}
                    @if (isset($row['items']) && is_array($row['items']) && count($row['items']) > 0)
                        <div class="row" dir="{{ $isArabic ? 'rtl' : 'ltr' }}">
                            @foreach ($row['items'] as $item)
                                @php
                                    $formattedDate = null;
                                    if (!empty($item['date'])) {
                                        try {
                                            $formattedDate = \Carbon\Carbon::parse($item['date'])->format('d-m-Y');
                                        } catch (\Exception $exception) {
                                            $formattedDate = $item['date'];
                                        }
                                    }
                                @endphp
                                <div class="col-md-4 col-sm-6 {{ $isArabic ? 'text-right' : 'text-left' }} column-box"
                                    style="margin-bottom: 15px !important;">
                                    @php
                                        $itemUrl = !empty($item['url']) ? $item['url'] : 'javascript:void(0)';
                                    @endphp
                                    <a href="{{ $itemUrl }}">
                                        @if (!empty($item['image']))
                                            <img src="{{ url('public/' . $item['image']) }}" width="100%"
                                                alt="Image">
                                        @else
                                            <img src="{{ asset('public/img/placeholder-square.jpg') }}" width="100%"
                                                alt="Image">
                                        @endif

                                        @if ($formattedDate)
                                            <div class="publish_date en">{{ $formattedDate }}</div>
                                        @endif

                                        @if ($isArabic)
                                            @if (!empty($item['title_ar']))
                                                <div class="title ar pt-2">{{ $item['title_ar'] }}</div>
                                            @endif
                                            @if (!empty($item['subtitle_ar']))
                                                <div class="author ar">{{ $item['subtitle_ar'] }}</div>
                                            @endif
                                            @if (!empty($item['description_ar']))
                                                <div class="content ar">{{ $item['description_ar'] }}</div>
                                            @endif
                                        @else
                                            @if (!empty($item['title_en']))
                                                <div class="title en pt-2">{{ $item['title_en'] }}</div>
                                            @endif
                                            @if (!empty($item['subtitle_en']))
                                                <div class="author en">{{ $item['subtitle_en'] }}</div>
                                            @endif
                                            @if (!empty($item['description_en']))
                                                <div class="content en">{{ $item['description_en'] }}</div>
                                            @endif
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
@endif
