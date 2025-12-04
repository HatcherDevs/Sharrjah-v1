{{-- @include('pages.research.header') --}}

{{-- <div id="loader"></div> --}}
<!-- Modal -->
{{-- <div class="modal fade" id="mapModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="display: block; padding-right: 15px;">
      <div class="modal-content" style="background-color:#ccff00">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ................................................<br>
          ................................................<br>
          ................................................<br>
          ................................................<br>
          ................................................<br>
          ................................................<br>
          ................................................<br>
          ................................................<br>
          ................................................<br>
          ................................................<br>
          ................................................<br>
        </div>
        
      </div>
    </div>
  </div> --}}


@if ($content['map-page-title']->content_ar_two)
<div class="modal fade show d-block" id="mapModalCenter" style="display: flex!important;background-color: rgb(0 0 0 / 0%);"
    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="
    width: 100%;top:0%
">
<div class="modal-content" style="background-color: #ccff00;height: 65vh;width: 100%;max-width: 97%;">
    <div class="modal-header py-2 border-0 d-inline" style="background-color: #ccff00;z-index:100">
        <button type="button" id="close" class="btn-close float-left btn_close_repo_insid"
            data-bs-dismiss="modal" aria-label="Close"></button>
    </div>


    <div class="modal-body pt-3 vh-100 scrollbar Repo_insid_ModalToggle_modal_body" style="overflow-y: auto;">
     

        @if ($lang == 'ar')
        {!! $content['map-page-title']->content_ar !!}
    @else
    {!! $content['map-page-title']->content !!}
    @endif
    </div>
</div>

</div>
</div>


@endif

       



<div id="main-wrap" class="">
    <div id="map-wrap" class="">
        <div id="map-canvas"></div>
        <div id="introwrap" style="opacity: 0!important;">
            <span id="clickstart">
                @if ($lang == 'ar')
                    للبدء، اضغط في أي مكان
                @else
                    <div class="desk-only">
                        Click anywhere<br /> to enter
                    </div>
                    <div class="mobile-only">
                        Tap here to enter
                    </div>
                @endif
            </span>
        </div>

        {{-- <div class="animateleft audiofy" id="intropop">
            <div class="copy">
                <div>

                    @if ($lang == 'ar')
                        <h1>{{ $content['intro']->title_ar }}</h1>
                    @else
                        <h1>{{ $content['intro']->title }}</h1>
                    @endif

                    <div class="pagecontent " data-simplebar data-simplebar-auto-hide="false">
                        @if ($lang == 'ar')
                            {!! $content['intro']->content_ar !!}
                        @else
                            {!! $content['intro']->content !!}
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}

        <?php
        $types->toArray();
        $timelines = ['pre-1960', '1960-1980', '1981-2000', '2001-2020', 'post-2020'];
        ?>

        <div class="slide-in-left animateleft" id="catpop">
            <ul id="typeSelection" style="padding-left: 15px;">
                @foreach ($types as $type)
                    @if($type['content_is_hidden'])
                        <style>
                            #cat-{{$type['id']}}{
                                display:none!important;
                            }
                        </style>
                    @endif
                    {{--                    <li><a href="#" data-id="{{$type->id}}" data-color="{{ $type->color }}" style="border-color:{{ $type->color }};color:{{ $type->color }}">{{$type->title}}</a></li> --}}
                    <li class=""><a href="#" class="audiofy" data-id="{{ $type['id'] }}"
                            data-slug="{{ $type['slug'] }}" data-color="{{ $type['color'] }}">
                            @if ($lang == 'ar')
                                {{ $type['title_ar'] }}
                            @else
                                {{ $type['title'] }}
                            @endif
                        </a></li>
                @endforeach
            </ul>
        </div>

        @foreach ($types as $type)
            {{--            <div class="valign slide-in-left animateleft catdetail" id="cat-{{$type->id}}" style="background-color: {{ $type->color }}"> --}}
            @if (($lang == 'en' && $type['content']) || ($lang == 'ar' && $type['content_ar']))
                <div class="valign slide-in-left catdetail typeOnly" id="cat-{{ $type['id'] }}">
                    <div class="close"></div>
                    <div class="audiofy">
                        <div class="scrollwrap " data-simplebar data-simplebar-auto-hide="false">
                            @if ($lang == 'ar')
                                <p>{!! $type['content_ar'] !!}</p>
                            @else
                                <p>{!! $type['content'] !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @foreach ($timelines as $timeline)
                @if($type[$timeline.'_is_hidden'] == 0)
                    
                    @if ($lang == 'ar' && $type[$timeline . '_ar'])
                        <div class="valign slide-in-right catdetail {{ $timeline }} {{ $type['slug'] }}" data-type="">
                            <div class="close"></div>
                            <div class="scrollwrap" data-simplebar data-simplebar-auto-hide="false">
                                {!! $type[$timeline . '_ar'] !!}
                            </div>
                        </div>
                    @elseif($lang == 'en' && $type[$timeline])
                        <div class="valign slide-in-right catdetail {{ $timeline }} {{ $type['slug'] }}"
                            data-type="">
                            <div class="close"></div>
                            <div class="scrollwrap" data-simplebar data-simplebar-auto-hide="false">
                                {!! $type[$timeline] !!}
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        @endforeach

        @foreach ($timelineContent as $slug => $timeline)
            @if (trim(strip_tags($timeline->content)))
                @if($timeline->is_hidden == 0 || $timeline->content == "")
                    
                <div class="valign slide-in-left catdetail {{ $slug }} timeline-only" data-type="">
                    <div class="close"></div>
                    <div class="scrollwrap" data-simplebar data-simplebar-auto-hide="false">
                        @if ($lang == 'ar')
                            {!! $timeline->content_ar !!}
                        @else
                            {!! $timeline->content !!}
                        @endif

                    </div>
                </div>
                @endif
            @endif
        @endforeach

        <div class="page page-3 content-page">
            {{--                <div class="animateleft pagepop"> --}}
            {{--                    <div class="copy"> --}}
            {{--                        <div> --}}

            {{--                            @if ($lang == 'ar') --}}
            {{--                                <h1>{{$content['tab-3']->title_ar}}</h1> --}}
            {{--                            @else --}}
            {{--                                <h1>{{$content['tab-3']->title}}</h1> --}}
            {{--                            @endif --}}

            {{--                            <div class="pagecontent " data-simplebar data-simplebar-auto-hide="false"> --}}
            {{--                                @if ($lang == 'ar') --}}
            {{--                                    {!! $content['tab-3']->content_ar !!} --}}
            {{--                                @else --}}
            {{--                                    {!! $content['tab-3']->content !!} --}}
            {{--                                @endif --}}
            {{--                            </div> --}}
            {{--                        </div> --}}
            {{--                    </div> --}}
            {{--                </div> --}}
            <div class="container relative">
                <div class="left">
                    <div class="owl-carousel-holder right-content mb-3 mobile-only" dir="ltr">
                        @if (count($content['tab-3']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-3']->images as $image)
                                <div class="item"><img loading="lazy"  src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>

                    @if ($lang == 'ar')
                        <h1 class="">{{ $content['tab-3']->title_ar }}</h1>
                    @else
                        <h1 class="">{{ $content['tab-3']->title }}</h1>
                    @endif

                    <div class="copy" data-simplebar data-simplebar-auto-hide="false">

                        @if ($lang == 'ar')
                            {!! $content['tab-3']->content_ar !!}
                        @else
                            {!! $content['tab-3']->content !!}
                        @endif

                    </div>
                </div>
                <div class="right order-first order-lg-last">
                    <div class="owl-carousel-holder right-content mb-3" dir="ltr">
                        @if (count($content['tab-3']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-3']->images as $image)
                                <div class="item"><img loading="lazy"  src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page page-2 content-page">
            {{--            <div class="animateleft pagepop"> --}}
            {{--                <div class="copy"> --}}
            {{--                    <div> --}}

            {{--                        @if ($lang == 'ar') --}}
            {{--                            <h1>{{$content['tab-2']->title_ar}}</h1> --}}
            {{--                        @else --}}
            {{--                            <h1>{{$content['tab-2']->title}}</h1> --}}
            {{--                        @endif --}}

            {{--                        <div class="pagecontent " data-simplebar data-simplebar-auto-hide="false"> --}}
            {{--                            @if ($lang == 'ar') --}}
            {{--                                {!! $content['tab-2']->content_ar !!} --}}
            {{--                            @else --}}
            {{--                                {!! $content['tab-2']->content !!} --}}
            {{--                            @endif --}}
            {{--                        </div> --}}
            {{--                    </div> --}}
            {{--                </div> --}}
            {{--            </div> --}}
            <div class="container relative">
                <div class="left">
                    <div class="owl-carousel-holder right-content mb-3 mobile-only" dir="ltr">
                        @if (count($content['tab-2']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-2']->images as $image)
                                <div class="item"><img loading="lazy"  src="{{ asset('public/' . $image->image) }}" width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>

                    @if ($lang == 'ar')
                        <h1 class="">{{ $content['tab-2']->title_ar }}</h1>
                    @else
                        <h1 class="">{{ $content['tab-2']->title }}</h1>
                    @endif

                    <div class="copy" data-simplebar data-simplebar-auto-hide="false">

                        @if ($lang == 'ar')
                            {!! $content['tab-2']->content_ar !!}
                        @else
                            {!! $content['tab-2']->content !!}
                        @endif

                    </div>
                </div>
                <div class="right order-first order-lg-last desk-only">
                    <div class="owl-carousel-holder right-content mb-3" dir="ltr">
                        @if (count($content['tab-2']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-2']->images as $image)
                                <div class="item"><img loading="lazy"  src="{{ asset('public/' . $image->image) }}"
                                        width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page page-1 content-page {{ isset($_GET['article']) ? 'active' : '' }}" id="repositories">
            <div class="container" style="position:relative; height: 100%;">
                <div class="">

                    @if ($lang == 'ar')
                        <h1 class="">{{ $content['tab-1']->title_ar }}</h1>
                    @else
                        <h1 class="">{{ $content['tab-1']->title }}</h1>
                    @endif

                    <div class="pagecontent" data-simplebar data-simplebar-auto-hide="false">

                        @if ($lang == 'ar')
                            {!! $content['tab-1']->content_ar !!}
                        @else
                            {!! $content['tab-1']->content !!}
                        @endif

                        <div class="row mt-4">
                            <div class="col-md-12">
                                {{--                        <b>Filter: </b> <a href="#">Seminars</a> | <a href="#">Webinars</a> | <a href="#">Discussions</a> | <a href="#">Publications</a> --}}
                                <span class="filterlabel">
                                    Filter by:</span>
                                <select id="repositoryFilter">
                                    <option value="all">All Media</option>

                                    @foreach ($repositoryTypes as $type)
                                        {{--                            <button class="submit repository-type-bt" data-slug="{{$type->slug}}" is_video="{{$type->is_video}}">{{$type->title}}</button> --}}

                                        @if ($lang == 'ar')
                                            <option value="{{ $type->slug }}">{{ $type->title_ar }}</option>
                                        @else
                                            <option value="{{ $type->slug }}">{{ $type->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-5">
                            @foreach ($repositories as $repository)
                                <div class="col-lg-3 col-md-4 type-{{ $repository->type->slug }} repos">
                                    <div class="vid {{ $repository->type->is_video ? 'is_video' : '' }}"
                                        data-id="{{ $repository->id }}">
                                        <div class="wrap">
                                            <img loading="lazy"  src="{{ asset('public/' . $repository->image) }}" width="100%">
                                        </div>

                                        @if ($lang == 'ar')
                                            <h5>{{ $repository->title_ar }}</h5>
                                            <p class="text-center" style="margin-bottom: 5px">
                                                {{ $repository->subtitle_ar }}</p>
                                            <p class="text-center">{{ $repository->type->title_ar }}</p>
                                        @else
                                            <h5>{{ $repository->title }}</h5>
                                            <p class="text-center" style="margin-bottom: 5px">
                                                {{ $repository->subtitle }}</p>
                                            <p class="text-center">{{ $repository->type->title }}</p>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($repositories as $repository)
                <div class="video-pop video-{{ $repository->id }}
                <?php
                if (isset($_GET['article'])) {
                    echo $repository->slug == $_GET['article'] ? 'active' : '';
                }
                ?>">
                    <div class="container relative">
                        <div class="left">
                            @if ($repository->type_set == 'video')
                                {{-- <iframe class="right-content vimeovid  mobile-only"
                                    src="https://player.vimeo.com/video/{{ $repository->video }}" width="100%"
                                    frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                <script src="https://player.vimeo.com/api/player.js"></script> --}}
                            @else
                                <div class="owl-carousel-holder right-content mb-3 mobile-only" dir="ltr">
                                    @if (count($repository->images) > 1)
                                        <div class="arrows">
                                            <button class="prev float-left"></button>
                                            <button class="next float-right"></button>
                                        </div>
                                    @endif
                                    <div class="owl-carousel owl-theme news-carousel">
                                        @foreach ($repository->images as $image)
                                            <div class="item"><img loading="lazy"  src="{{ asset('public/' . $image->image) }}"
                                                    width="100%"></div>
                                        @endforeach
                                    </div>
                                    <div id="owl-dots"></div>
                                </div>
                            @endif

                            @if ($lang == 'ar')
                                <h1>{{ $repository->title_ar }}</h1>
                                <p><b>{{ $repository->subtitle_ar }}</b></p>
                            @else
                                <h1>{{ $repository->title }}</h1>
                                <p><b>{{ $repository->subtitle }}</b></p>
                            @endif

                            <div class="copy" data-simplebar data-simplebar-auto-hide="false">
                                @if ($lang == 'ar')
                                    {!! $repository->content_ar !!}
                                @else
                                    {!! $repository->content !!}
                                @endif
                            </div>
                            <button class="backbutton">

                                @if ($lang == 'ar')
                                    العودة إلى لأرشيف
                                @else
                                    Back to repository
                                @endif
                            </button>
                        </div>
                        <div
                            class="right order-first order-lg-last desk-only right-content {{ $repository->subtitle ? 'has_sub' : '' }}">
                            @if ($repository->type_set == 'video')
                                {{-- <iframe class="right-content vimeovid"
                                    src="https://player.vimeo.com/video/{{ $repository->video }}" width="100%"
                                    frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                <script src="https://player.vimeo.com/api/player.js"></script> --}}
                            @else
                                <div class="owl-carousel-holder right-content mb-3" dir="ltr">
                                    @if (count($repository->images) > 1)
                                        <div class="arrows">
                                            <button class="prev float-left"></button>
                                            <button class="next float-right"></button>
                                        </div>
                                    @endif
                                    <div class="owl-carousel owl-theme news-carousel">
                                        @foreach ($repository->images as $image)
                                            <div class="item"><img loading="lazy"  src="{{ asset('public/' . $image->image) }}"
                                                    width="100%"></div>
                                        @endforeach
                                    </div>
                                    <div id="owl-dots"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="page page-4 content-page">
            {{--            <div class="animateleft pagepop"> --}}
            {{--                <div class="copy"> --}}
            {{--                    <div> --}}

            {{--                        @if ($lang == 'ar') --}}
            {{--                            <h1>{{$content['tab-4']->title_ar}}</h1> --}}
            {{--                        @else --}}
            {{--                            <h1>{{$content['tab-4']->title}}</h1> --}}
            {{--                        @endif --}}

            {{--                        <div class="pagecontent " data-simplebar data-simplebar-auto-hide="false"> --}}
            {{--                            @if ($lang == 'ar') --}}
            {{--                                {!! $content['tab-4']->content_ar !!} --}}
            {{--                            @else --}}
            {{--                                {!! $content['tab-4']->content !!} --}}
            {{--                            @endif --}}
            {{--                        </div> --}}
            {{--                    </div> --}}
            {{--                </div> --}}
            {{--            </div> --}}

            <div class="container relative">
                <div class="left">
                    <div class="owl-carousel-holder right-content mb-3 mobile-only" dir="ltr">
                        {{--                        @if (count($content['tab-4']->images) > 1) --}}
                        {{--                            <div class="arrows"> --}}
                        {{--                                <button class="prev float-left"></button> --}}
                        {{--                                <button class="next float-right"></button> --}}
                        {{--                            </div> --}}
                        {{--                        @endif --}}
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-4']->images as $image)
                                <div class="item"><img loading="lazy"  src="{{ asset('public/' . $image->image) }}"
                                        width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>

                    @if ($lang == 'ar')
                        <h1 class="">{{ $content['tab-4']->title_ar }}</h1>
                    @else
                        <h1 class="">{{ $content['tab-4']->title }}</h1>
                    @endif

                    <div class="copy" data-simplebar data-simplebar-auto-hide="false">

                        @if ($lang == 'ar')
                            {!! $content['tab-4']->content_ar !!}
                        @else
                            {!! $content['tab-4']->content !!}
                        @endif

                    </div>
                </div>
                <div class="right order-first order-lg-last desk-only">
                    <div class="owl-carousel-holder right-content mb-3" dir="ltr">
                        @if (count($content['tab-4']->images) > 1)
                            <div class="arrows">
                                <button class="prev float-left"></button>
                                <button class="next float-right"></button>
                            </div>
                        @endif
                        <div class="owl-carousel owl-theme news-carousel">
                            @foreach ($content['tab-4']->images as $image)
                                <div class="item"><img loading="lazy"  src="{{ asset('public/' . $image->image) }}"
                                        width="100%">
                                </div>
                            @endforeach
                        </div>
                        <div id="owl-dots"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="timeline">
        <div class="line">
        </div>
        {{-- @foreach ($types as $type)
            <ul id="timelineSelect" class="timeline_{{$type['slug']}}">
                @foreach ($timelines as $timeline)
                    @if($type[$timeline.'_is_hidden'] == 0)
                        <li><span><a href="#" data-id="{{ $timeline }}">
                                @if ($lang == 'ar')
                                    {{ $content[$timeline]->title_ar }}
                                @else
                                    {{ $content[$timeline]->title }}
                                @endif
                            </a></span>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endforeach --}}
        <ul id="timelineSelect" class="timeline_global">
            @foreach ($timelines as $timeline)
                <li><span><a href="#" data-id="{{ $timeline }}">
                        @if ($lang == 'ar')
                            {{ $content[$timeline]->title_ar }}
                        @else
                            {{ $content[$timeline]->title }}
                        @endif
                    </a></span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="page" id="building" style="overflow-y:auto">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div id="content">
                        <div class="pull-left position-relative">
                            <button class="backbutton position-absolute pt-0 mt-0" style="top: 0">
                                @if ($lang == 'ar')
                                    العودة إلى الخريطة
                                @else
                                    BACK TO MAP
                                @endif
                            </button><br>

                            <h3 class="page-heading pt-4" id="building-title"></h3>
                            <div class="copy mb-3" data-simplebar data-simplebar-auto-hide="false">
                                <div id="building-content">
                                </div>
                            </div>
                        </div>
                        <a href="#" id="showform"><b>

                                @if ($lang == 'ar')
                                    ساهم بقصتك أو معلوماتك <br />عن هذا المبنى
                                @else
                                    Contribute with your story <br />
                                    or data related to this building
                                @endif
                            </b></a>
                    </div>
                    <div id="successAlert" class="alert-success alert">Thank you for your feedback.</div>
                    <div id="form">
                        <form action="{{ url('research/submit') }}" method="post" id="researchForm">
                            <input type="hidden" name="research_building_id" id="researchId">
                            <label>
                                @if ($lang == 'ar')
                                    Email:
                                @else
                                    Email:
                                @endif
                            </label>
                            <input type="text" class="form-control" name="email" required>
                            <label>
                                @if ($lang == 'ar')
                                    Message:
                                @else
                                    Message:
                                @endif
                            </label>
                            <textarea class="form-control" name="message" required></textarea>
                            <input type="submit" value="Submit" class="submit">
                        </form>
                    </div>


                </div>
                <div class="col-lg-6 col-md-12 order-first order-lg-last">
                    <figure class="figureImg">
                        <div class="owl-carousel-holder right-content" dir="ltr">
                            <div class="arrows">
                                {{--                            <button class="prev float-left"></button> --}}
                                <button class="next float-right"></button>
                            </div>
                            <div class="owl-carousel owl-theme" id="building-carousel">
                            </div>
                            <div id="owl-dots"></div>
                        </div>
                    </figure>

                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div id="cursor"></div> --}}
{{-- <div id="cursorFollow"></div> --}}


