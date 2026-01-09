@include('pages.research.header')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        /* Css Code Here */
    </style>
@endsection

<div id="loader"></div>

<!--- Start Content Body ---->
<main>


    <!---- Start Intro or Main Page -------->
    <div class="w-100 pt-4" style="background: {!! $content['intro']->background ?? 'rgb(232,226,229)' !!}!important;overflow: auto;">
        <div class="intro_page container-fluid scrollbar {{-- scrollbar_intro --}}" {{-- id="scrollbar_intro" --}}>
            <div class="row ">
                <div class="col-md-6">
                    @if ($lang == 'ar')
                        {!! $content['intro']->content_ar !!}
                    @else
                        {!! $content['intro']->content !!}
                    @endif
                </div>
                <div class="col-md-6" style="padding-bottom:300px">
                    @if ($lang == 'ar')
                        {!! $content['intro']->content_ar_two !!}
                    @else
                        {!! $content['intro']->content_two !!}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!---- End Intro or Main Page -------->


    <!-- Start Main-Popup-video -->
    @if ($content['popup']->is_hidden == 0)
        <div class="modal fade show" id="RepoModalToggle"
            style="display: none;background-color: rgb(255 255 255 / 0%);z-index:1052;" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="background-color: {!! $content['popupcontent']->background !!};">
                    <div class="modal-header pl-2 pb-0 border-0 d-inline">
                        <button type="button" class="btn-close float-left btn_close_repo" aria-label="Close"></button>
                    </div>

                    <div class="modal-body ">
                        @if ($content['popupcontent']->title == video)
                            <div style="padding-bottom:56.25%; position:relative; display:block; width: 100%">
                                <iframe loading="lazy" id="RepoModalIframe" width="100%" height="100%"
                                    src="{!! $content['popupcontent']->content !!}" frameborder="0" allowfullscreen=""
                                    style="position:absolute; top:0; left: 0">
                                </iframe>
                            </div>
                            {{-- <iframe id="RepoModalIframe" width="100%" height="100%" src="{!! $content['popupcontent']->content !!}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> --}}
                        @endif
                        @if ($content['popupcontent']->title == image)
                            @foreach ($content['popupcontent']->images as $image)
                                <img loading="lazy" width="100%" class="videoPopup"
                                    src="{{ asset('public/' . $image->image) }}">
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End Main-Popup -->

    <!---- Start Tab Repository (Tab-1 Or Page-1) ----->



    <!----- Start Content Repo ----->

    <div class="repository-tab offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom_Repository"
        aria-labelledby="offcanvasBottomLabel">
        <!----- Start Filter by ------>
        <div class="container-fluid pt-2 pb-1 ">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-10 col-10 ">
                    <select class="btn btn-warning bg-transparent shadow-1 w-100" id="repositoryFilter">
                        <option value="all">All Media</option>
                        @foreach ($repositoryTypes as $type)
                            @if ($lang == 'ar')
                                @if (!$type->is_hidden)
                                    <option selected value="{{ $type->slug }}">{{ $type->title_ar }}</option>
                                @endif
                            @else
                                @if (!$type->is_hidden)
                                    <option value="{{ $type->slug }}">{{ $type->title }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!----- End Filter by ------>
        <div class="repository-tab " tabindex="-1" id="offcanvasBottom_Repository"
            style="overflow: hidden;border-top: 10px solid  {!! $content['tab-1']->background !!};background-color:{!! $content['tab-1']->background !!};visibility:visible;display:flex;"
            aria-labelledby="offcanvasBottomLabel">
            {{-- <div class="offcanvas-header">
      <p class="btn-close btn_back_to_repo" id="offcanvasBottomLabel" data-bs-dismiss="offcanvas" aria-label="Close">BACK TO REPOSITORY</button>
    </div> --}}
            <div class="offcanvas-body small scrollbar">
                <!--- Start (Modal) Code body Here ----->


                <!----- Start Popup Repo ----->
                @if ($content['tab-1']->content_ar_two == 0)
                    <div class="modal fade show" id="Repo_insid_ModalToggle"
                        style="display: flex!important;background-color: rgb(0 0 0 / 0%);" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content" style="background-color: #ccff00;height: 50vh;">
                                <div class="modal-header py-2 border-0 d-inline"
                                    style="background-color: #ccff00;z-index:100">
                                    <button type="button" class="btn-close float-left btn_close_repo_insid"
                                        aria-label="Close"></button>
                                </div>


                                <div class="modal-body pt-3 vh-100 scrollbar Repo_insid_ModalToggle_modal_body">

                                    {!! $content['tab-1']->content !!}

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!----- End Popup Repo ----->

                <div class="pl-2">

                    <div class="row">
                        @foreach ($repositories as $repository)
                            <div
                                class="col-lg-{!! $content['repo-rows']->content !!} col-md-4  type-{{ $repository->type->slug }} repos">
                                <div class="card bg-transparent border-0 text-center" data-bs-toggle="offcanvas"
                                    data-bs-target="#vido{{ $repository->id }}"
                                    aria-controls="vido{{ $repository->id }}">
                                    <div class="h-75">
                                        <img src="{{ asset('public/' . $repository->image) }}" class="card-img-top">
                                    </div>
                                    <div class="card-body bg-transparent">
                                        @if ($lang == 'ar')
                                            <h5 class="card-title mb-lg-0">{{ $repository->title_ar }}</h5>
                                            <h6 class="card-text">{{ $repository->subtitle_ar }}</h6>
                                            <h6 class="card-text">{{ $repository->type->title_ar }}</h6>
                                        @else
                                            <h5 class="card-title">{{ $repository->title }}</h5>
                                            <h6 class="card-text">{{ $repository->subtitle }}</h6>
                                            <h6 class="card-text">{{ $repository->type->title }}</h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!--- End (Modal) Code body Here ----->
            </div>
        </div>
    </div>

    <!--- Start Video Animation Show ----->
    @foreach ($repositories as $repository)
        <div class="offcanvas offcanvas-start repositories_vid" data-bs-scroll="true" id="vido{{ $repository->id }}"
            aria-labelledby="offcanvasScrollingLabel" style="background-color:{{ $repository->background }};">

            <div class="offcanvas-header" style="background-color:{{ $repository->background }};z-index:1000000;">
                <p class="btn-close btn_back_to_repo" data-bs-toggle="offcanvas" data-bs-toggle="modal"
                    data-bs-target="#offcanvasBottom_Repository" aria-controls="offcanvasBottom"
                    data-bs-toggle="modal" href="#offcanvasPopupRepo">BACK TO REPOSITORY</button>
            </div>
            <div class="offcanvas-body scrollbar">
                <div class="" style="{{-- padding-left:.5rem!important --}}">
                    <div class="row">
                        <div class="col-md-6">
                            <!---- Start Mobile Only ----->
                            <div class="d-sm-block d-lg-none d-md-none" style="padding-left: 10px">
                                @if ($repository->type_set == 'video')
                                    <div>
                                        <iframe loading="lazy" style="height: 30vh"
                                            src="https://player.vimeo.com/video/{{ $repository->video }}"
                                            width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen
                                            allowfullscreen style=""></iframe>
                                        <script src="https://player.vimeo.com/api/player.js"></script>
                                    </div>
                                @else
                                    <!-- Swiper slider -->
                                    <div class="swiper mySwiper_new" style="width: 100%;overflow-x: hidden;">
                                        <div class="swiper-wrapper">
                                            @foreach ($repository->images as $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('public/' . $image->image) }}" width="100%">
                                                </div>
                                            @endforeach

                                        </div>
                                        @if (count($repository->images) > 1)
                                            <div class="swiper-pagination"></div>
                                            {{-- <div class="swiper-button-next"></div>
                              <div class="swiper-button-prev"></div> --}}
                                        @endif
                                    </div>
                                    <!-- Swiper slider -->
                                @endif

                                @if ($lang == 'ar')
                                    <h1 style=" ">{{ $repository->title_ar }}</h1>
                                    <p><b>{{ $repository->subtitle_ar }}</b></p>
                                @else
                                    <h1 style="">{{ $repository->title }}</h1>
                                    <p style="border-bottom: 1px solid #000;padding-bottom: 10px;">
                                        <b>{{ $repository->subtitle }}</b>
                                    </p>
                                @endif

                                @if ($lang == 'ar')
                                    {!! $repository->content_ar !!}
                                @else
                                    {!! $repository->content !!}
                                @endif
                            </div>
                            <!---- End Mobile Only ------>

                            <div class="d-none d-md-block d-lg-block">
                                @if ($lang == 'ar')
                                    <h1 style=" ">{{ $repository->title_ar }}</h1>
                                    <p><b>{{ $repository->subtitle_ar }}</b> </p>
                                @else
                                    <h1 style="">{{ $repository->title }}</h1>
                                    <p style="border-bottom: 2px solid #000;padding-bottom: 10px;">
                                        <b>{{ $repository->subtitle }}</b>
                                    </p>
                                @endif



                                @if ($lang == 'ar')
                                    {!! $repository->content_ar !!}
                                @else
                                    {!! $repository->content !!}
                                @endif
                            </div>

                        </div>
                        <div class="col-md-6 d-none d-md-block d-lg-block">
                            <figure class="figureImg">

                                @if ($repository->type_set == 'video')
                                    <div class="vimeovid" id="parent_iframe">
                                        <iframe loading="lazy" id="vimeovid"
                                            src="https://player.vimeo.com/video/{{ $repository->video }}"
                                            width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen
                                            allowfullscreen style=""></iframe>
                                        <script src="https://player.vimeo.com/api/player.js"></script>
                                        <button data-bs-toggle="modal"
                                            href="#FullScreenVideoPopup{{ $repository->id }}" role="button">Play
                                            Iframe</button>
                                    </div>
                                @else
                                    <!-- Swiper slider -->
                                    <div class="swiper mySwiper_new" style="width: 100%;overflow-x: hidden;">
                                        <div class="swiper-wrapper">
                                            @foreach ($repository->images as $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('public/' . $image->image) }}" width="100%">
                                                </div>
                                            @endforeach

                                        </div>
                                        @if (count($repository->images) > 1)
                                            <div class="swiper-pagination"></div>
                                            {{-- <div class="swiper-button-next"></div>
                              <div class="swiper-button-prev"></div> --}}
                                        @endif
                                    </div>
                                    <!-- Swiper slider -->
                                @endif

                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!---- Start FullScreenVideoPopup ----->
        <div class="modal fade FullScreenVideoPopup" id="FullScreenVideoPopup{{ $repository->id }}"
            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
            aria-hidden="true" style="z-index: 99999999999999999999999999999999">
            <div class="modal-dialog modal-dialog-centered" style="max-width:66%">
                <div class="modal-content FullScreenVideoPopupAction">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height:70vh">
                        <iframe loading="lazy" src="https://player.vimeo.com/video/{{ $repository->video }}"
                            height="100%" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen
                            allowfullscreen style=""></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!---- Start FullScreenVideoPopup ----->
    @endforeach
    <!--- Start Video Animation Show ----->

    <!---- End Tab Repository (Tab-1 Or Page-1) ----->


    <!---- Start Tab News And Event (Tab-2 Or Page-2) ----->
    <div class="repository-tab offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom_News_and_Event"
        aria-labelledby="offcanvasBottomLabel">
        <div class="repository-tab " tabindex="-1" id="offcanvasBottom_News_and_Event"
            style="overflow: hidden;border-top: 10px solid {!! $content['tab-2']->background !!};visibility:visible;display:flex;"
            aria-labelledby="offcanvasBottomLabel">

            {{-- <div class="offcanvas-header">
      <p class="btn-close btn_back_to_repo" id="offcanvasBottomLabel" data-bs-dismiss="offcanvas" aria-label="Close">BACK TO REPOSITORY</button>
    </div> --}}
            <div class="offcanvas-body small scrollbar">
                <!--- Start Code body Here ----->

                <div class="pl-2">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="d-md-none d-lg-none d-sm-block">
                                <!-- Swiper slider -->
                                <div class="swiper mySwiper_new" style="width: 100%;overflow-x: hidden;">
                                    <div class="swiper-wrapper">
                                        @foreach ($content['tab-2']->images as $image)
                                            <div class="swiper-slide">
                                                <img loading="lazy" src="{{ asset('public/' . $image->image) }}"
                                                    width="100%">
                                            </div>
                                        @endforeach

                                    </div>
                                    @if (count($content['tab-2']->images) > 1)
                                        <div class="swiper-pagination"></div>
                                        {{-- <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div> --}}
                                    @endif
                                </div>
                                <!-- Swiper slider -->
                            </div>

                            @if ($lang == 'ar')
                                {!! $content['tab-2']->content_ar !!}
                            @else
                                {!! $content['tab-2']->content !!}
                            @endif
                        </div>
                        <div class="col-md-6 d-md-block d-lg-block d-none">
                            <figure class="figureImg">
                                <!-- Swiper slider -->
                                <div class="swiper mySwiper_new" style="width: 100%;overflow-x: hidden;">
                                    <div class="swiper-wrapper">
                                        @foreach ($content['tab-2']->images as $image)
                                            <div class="swiper-slide">
                                                <img loading="lazy" data-bs-toggle="modal"
                                                    href="#imgAction{{ $image->id }}" role="button"
                                                    src="{{ asset('public/' . $image->image) }}" width="100%">
                                            </div>
                                        @endforeach

                                    </div>
                                    @if (count($content['tab-2']->images) > 1)
                                        <div class="swiper-pagination"></div>
                                        {{-- <div class="swiper-button-next"></div>
                      <div class="swiper-button-prev"></div> --}}
                                    @endif
                                </div>
                                <!-- Swiper slider -->
                            </figure>
                        </div>
                    </div>
                </div>

                <!---- Start imgAction Modal ----->
                @foreach ($content['tab-2']->images as $image)
                    <div class="modal fade " id="imgAction{{ $image->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true" style="z-index: 99999999999999999999999999999999">
                        <div class="modal-dialog modal-dialog-centered" style="max-width:66%">
                            <div class="modal-content FullScreenVideoPopupAction">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body " style="">
                                    <img loading="lazy" src="{{ asset('public/' . $image->image) }}" height="100%"
                                        width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!---- Start imgAction Modal ----->




                <!--- End Code body Here ----->
            </div>
        </div>
    </div>
    <!---- End Tab News And Event (Tab-2 Or Page-2) ----->

    <!---- Start Tab (Tab-3 Or Page-3) ----->
    <div class="repository-tab offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom_tab_3"
        aria-labelledby="offcanvasBottomLabel">
        <div class="repository-tab " tabindex="-1" id="offcanvasBottom_tab_3"
            style="overflow: hidden;border-top: 10px solid {!! $content['tab-3']->background !!};background-color:{!! $content['tab-3']->background !!};visibility:visible;display:flex;"
            aria-labelledby="offcanvasBottomLabel">
            {{-- <div class="offcanvas-header">
      <p class="btn-close btn_back_to_repo" id="offcanvasBottomLabel" data-bs-dismiss="offcanvas" aria-label="Close">BACK TO REPOSITORY</button>
    </div> --}}
            <div class="offcanvas-body small scrollbar">
                <!--- Start (Modal) Code body Here ----->

                <div class="pl-2">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="d-md-none d-lg-none d-sm-block">
                                <!-- Swiper slider -->
                                <div class="swiper mySwiper_new" style="width: 100%;overflow-x: hidden;">
                                    <div class="swiper-wrapper">
                                        @foreach ($content['tab-3']->images as $image)
                                            <div class="swiper-slide">
                                                <img loading="lazy" src="{{ asset('public/' . $image->image) }}"
                                                    width="100%">
                                            </div>
                                        @endforeach

                                    </div>
                                    @if (count($content['tab-3']->images) > 1)
                                        <div class="swiper-pagination"></div>
                                        {{-- <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div> --}}
                                    @endif
                                </div>
                                <!-- Swiper slider -->
                            </div>

                            @if ($lang == 'ar')
                                {!! $content['tab-3']->content_ar !!}
                            @else
                                {!! $content['tab-3']->content !!}
                            @endif
                        </div>
                        <div class="col-md-6 d-md-block d-lg-block d-none">
                            <figure class="figureImg">
                                <!-- Swiper slider -->
                                <div class="swiper mySwiper_new" style="width: 100%;overflow-x: hidden;">
                                    <div class="swiper-wrapper">
                                        @foreach ($content['tab-3']->images as $image)
                                            <div class="swiper-slide">
                                                <img loading="lazy" data-bs-toggle="modal"
                                                    href="#imgAction{{ $image->id }}" role="button"
                                                    src="{{ asset('public/' . $image->image) }}" width="100%">
                                            </div>
                                        @endforeach

                                    </div>
                                    @if (count($content['tab-3']->images) > 1)
                                        <div class="swiper-pagination"></div>
                                        {{-- <div class="swiper-button-next"></div>
                      <div class="swiper-button-prev"></div> --}}
                                    @endif
                                </div>
                                <!-- Swiper slider -->
                            </figure>
                        </div>
                    </div>
                </div>

                <!---- Start imgAction Modal ----->
                @foreach ($content['tab-3']->images as $image)
                    <div class="modal fade " id="imgAction{{ $image->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true" style="z-index: 99999999999999999999999999999999">
                        <div class="modal-dialog modal-dialog-centered" style="max-width:66%">
                            <div class="modal-content FullScreenVideoPopupAction">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body ">
                                    <img loading="lazy" src="{{ asset('public/' . $image->image) }}" height="100%"
                                        width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!---- Start imgAction Modal ----->
                <!--- End (Modal) Code body Here ----->
            </div>
        </div>
    </div>
    <!---- End Tab Tab (Tab-3 Or Page-3) ----->


    <!---- Start Tab (Tab-4 Or Page-4) ----->
    <div class="repository-tab offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom_tab_4"
        aria-labelledby="offcanvasBottomLabel">
        <div class="repository-tab  " id="" tabindex="-1"
            style="overflow: hidden;border-top: 10px solid {!! $content['tab-4']->background !!};background-color:{!! $content['tab-4']->background !!};visibility:visible;display:flex;"
            aria-labelledby="offcanvasBottomLabel">
            {{-- <div class="offcanvas-header">
      <p class="btn-close btn_back_to_repo" id="offcanvasBottomLabel" data-bs-dismiss="offcanvas" aria-label="Close">BACK TO REPOSITORY</button>
    </div> --}}
            <div class="offcanvas-body small scrollbar">
                <!--- Start (Modal) Code body Here ----->

                <div class="pl-2">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="d-md-none d-lg-none d-sm-block">
                                <!-- Swiper slider -->
                                <div class="swiper mySwiper_new" style="width: 100%;overflow-x: hidden;">
                                    <div class="swiper-wrapper">
                                        @foreach ($content['tab-4']->images as $image)
                                            <div class="swiper-slide">
                                                <img loading="lazy" src="{{ asset('public/' . $image->image) }}"
                                                    width="100%">
                                            </div>
                                        @endforeach

                                    </div>
                                    @if (count($content['tab-4']->images) > 1)
                                        <div class="swiper-pagination"></div>
                                        {{-- <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div> --}}
                                    @endif
                                </div>
                                <!-- Swiper slider -->
                            </div>

                            @if ($lang == 'ar')
                                {!! $content['tab-4']->content_ar !!}
                            @else
                                {!! $content['tab-4']->content !!}
                            @endif
                        </div>
                        <div class="col-md-6 d-md-block d-lg-block d-none">
                            <figure class="figureImg">
                                <!-- Swiper slider -->
                                <div class="swiper mySwiper_new" style="width: 100%;overflow-x: hidden;">
                                    <div class="swiper-wrapper">
                                        @foreach ($content['tab-4']->images as $image)
                                            <div class="swiper-slide">
                                                <img loading="lazy" data-bs-toggle="modal"
                                                    href="#imgAction{{ $image->id }}" role="button"
                                                    src="{{ asset('public/' . $image->image) }}" width="100%">
                                            </div>
                                        @endforeach

                                    </div>
                                    @if (count($content['tab-4']->images) > 1)
                                        <div class="swiper-pagination"></div>
                                        {{-- <div class="swiper-button-next"></div>
                      <div class="swiper-button-prev"></div> --}}
                                    @endif
                                </div>
                                <!-- Swiper slider -->
                            </figure>
                        </div>
                    </div>
                </div>


                <!---- Start imgAction Modal ----->
                @foreach ($content['tab-4']->images as $image)
                    <div class="modal fade " id="imgAction{{ $image->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true" style="z-index: 99999999999999999999999999999999">
                        <div class="modal-dialog modal-dialog-centered" style="max-width:66%">
                            <div class="modal-content FullScreenVideoPopupAction">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body " style="">
                                    <img loading="lazy" src="{{ asset('public/' . $image->image) }}" height="100%"
                                        width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!---- Start imgAction Modal ----->

                <!--- End (Modal) Code body Here ----->
            </div>
        </div>
    </div>
    <!---- End Tab Tab (Tab-4 Or Page-4) ----->

    <!---- Start Script Intro or Main Page -------->
    <script>
        var scrollContainer = document.getElementById("scrollbar_intro");
        var reachedEnd = false;

        // Only add event listeners if element exists
        if (scrollContainer) {
            scrollContainer.addEventListener("scroll", handleScroll);
            scrollContainer.addEventListener("touchmove", handleScroll);
        }

        function handleScroll() {
            if (!scrollContainer) return;
            if (scrollContainer.scrollTop + scrollContainer.clientHeight >= scrollContainer.scrollHeight) {
                if (!reachedEnd) {
                    reachedEnd = true;

                    var x = scrollContainer.scrollTop; // أو أي قيمة أخرى تحددها
                    // حساب النسبة المئوية (10%)
                    var percentage = 10;
                    var discount = (percentage / 100) * x;

                    // القيمة بعد الخصم
                    result = x - discount;
                    scrollContainer.scrollTop = result;
                    // alert('end');
                }
            } else {
                reachedEnd = false;
            }
        }
    </script>

    <!---- End Script Intro or Main Page -------->



    <!---- Start Tab Map  ----->
    <div class="repository-tab offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom_tab_Map"
        aria-labelledby="offcanvasBottomLabel" style="height: 100%;">
        {{-- <div class="offcanvas-header">
      <p class="btn-close btn_back_to_repo" id="offcanvasBottomLabel" data-bs-dismiss="offcanvas" aria-label="Close">BACK TO REPOSITORY</button>
    </div> --}}
        <div class="offcanvas-body p-0" style="overflow: hidden">
            {{-- <i class="fa-solid fa-2x fa-spinner fa-spin" style="position: absolute;z-index: 1;"></i> --}}
            <!--- Start (Modal) Code body Here ----->
            {{-- <iframe  id="researchMap" width="100%" height="100%" style="position: relative;z-index: 2;"></iframe> --}}
            @include('pages.research.map.map')
            <!--- End (Modal) Code body Here ----->
        </div>
    </div>

    <!---- End Tab Map ----->


</main>

<!--- End Content Body ---->


<!--- Start Footer --->
<!-- Start Javascript Bootstrap 5 ---->
@include('pages.research.footer')
<!-- Start Javascript Bootstrap 5 ---->
<!--- End Footer --->
