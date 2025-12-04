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

            <div class="row" dir="">
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
                <div class="col-md-6 text-left">
                    {!! $page->content !!}
                </div>
                <div class="col-md-6 text-right cairo">
                    {!! $page->content_ar !!}
                </div>
            </div>
        </div>
    </div>
@endif