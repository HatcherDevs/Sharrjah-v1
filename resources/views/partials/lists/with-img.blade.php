@inject('pageService', 'App\Services\PageService')

<?php
$loop = 1;
?>
<div class="container text-center">
    <div class="row">
        <div class="body-section contents">
            <div class="row">
            <ul class="figure-list">
            @foreach($data as $child)
                @if($loop%2==1)
                    <li class="al-right">
                        <div class="colm titles">
                            {{ $child->pageType }}
                            <div class="title ar" dir="rtl">
                                <a href="{{ $child->linkAr }}" {{ $child->pageType['type']=="url" || $child->pageType['type']=="file" ? 'target="_blank"' : "" }}>
                                    <strong>{{ $child->title_ar }}</strong><br/>
                                    <span class="ar-date"dir="rtl">

                                    @if($child->publish_date)
                                        {{
                                            $pageService->getArabicDate(
                                                $child->publish_date->format('d'),
                                                intval($child->publish_date->format('m')),
                                                $child->publish_date->format('Y')
                                            )
                                         }}
                                    @endif
                                </span><br/>
                                </a>
                            </div>
                            <div class="title en">
                                <a href="{{ $child->link }}" {{ $child->pageType['type']=="url" || $child->pageType['type']=="file" ? 'target="_blank"' : "" }}>
                                    <strong>{{ $child->title }}</strong><br/>
                                    @if($child->publish_date)
                                        {{ $child->publish_date->format('F d, Y') }}<br/>
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="img colm">
                            @if(count($child->sliders[0]))
                                @if($child->sliders[0]->square)
                                    <img src="{{ asset('public/'.$child->sliders[0]->square->url) }}">
                                @else
                                    <img src="{{ asset('public/img/placeholder-200x200.png') }}">
                                @endif
                            @else
                                <img src="{{ asset('public/img/placeholder-200x200.png') }}">
                            @endif
                            <div class="title enar">
                                {{$child->pageType['type']}}
                                <a href="#">
                                    <strong>
                                        <a href="{{ $child->linkAr }}" {{ $child->pageType['type']=="url" || $child->pageType['type']=="file" ? 'target="_blank"' : "" }}>{{ $child->title_ar }}</a><br>
                                        <a href="{{ $child->link }}" {{ $child->pageType['type']=="url" || $child->pageType['type']=="file" ? 'target="_blank"' : "" }}>{{ $child->title }}</a>
                                    </strong><br/>

                                    @if($child->publish_date)
                                        {{ $child->publish_date->format('F d, Y') }}<br/>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </li>
                @else
                    <li class="al-left">
                        <div class="img colm">
                            @if(count($child->sliders[0]))
                                @if($child->sliders[0]->square)
                                    <img src="{{ asset('public/'.$child->sliders[0]->square->url) }}">
                                @else
                                    <img src="{{ asset('public/img/placeholder-200x200.png') }}">
                                @endif
                            @else
                                <img src="{{ asset('public/img/placeholder-200x200.png') }}">
                            @endif
                            <div class="title enar">
                                <a href="#">
                                    <strong>
                                        <a href="{{ $child->linkAr }}" {{ $child->pageType['type']=="url" || $child->pageType['type']=="file" ? 'target="_blank"' : "" }}>{{ $child->title_ar }}</a><br>
                                        <a href="{{ $child->link }}" {{ $child->pageType['type']=="url" || $child->pageType['type']=="file" ? 'target="_blank"' : "" }}>{{ $child->title }}</a>
                                    </strong><br/>

                                    @if($child->publish_date)
                                        {{ $child->publish_date->format('F d, Y') }}<br/>
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="colm titles">
                            <div class="title ar" dir="rtl">
                                <a href="{{ $child->linkAr }}" {{ $child->pageType['type']=="url" || $child->pageType['type']=="file" ? 'target="_blank"' : "" }}>
                                    <strong>{{ $child->title_ar }}</strong><br/>
                                    <span class="ar-date"dir="rtl">
                                        @if($child->publish_date)
                                            {{
                                                $pageService->getArabicDate(
                                                    $child->publish_date->format('d'),
                                                    intval($child->publish_date->format('m')),
                                                    $child->publish_date->format('Y')
                                                )
                                            }}
                                        @endif
                                    </span><br/>
                                </a>
                            </div>
                            <div class="title en">
                                <a href="{{ $child->link }}" {{ $child->pageType['type']=="url" || $child->pageType['type']=="file" ? 'target="_blank"' : "" }}>
                                    <strong>{{ $child->title }}</strong><br/>

                                    @if($child->publish_date)
                                        {{ $child->publish_date->format('F d, Y') }}<br/>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </li>
                @endif
                <?php $loop++; ?>
            @endforeach

            </ul>
        </div>
        </div>
    </div>
</div>
