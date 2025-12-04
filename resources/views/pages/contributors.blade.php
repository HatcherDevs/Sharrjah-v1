@extends('pages.master')

@section('content')

<div class="innerpage">
    <div class="container text-center">
        <div class="body-section contents with-img-header">
            <div class="row" dir="">
                <div class="col-md-6 text-left">
                    <div class="breadcrumbs en">
                        @include('partials.breadcrumbs')
                    </div>
                    <h1 class="en">{{ $page->name }}</h1>
                    {!! $page->content !!}
                    <br/>
                </div>
                <div class="col-md-6 text-right">
                    <div class="breadcrumbs">
                        @include('partials.breadcrumbs-ar')
                    </div>
                    <h1 class="short-title">{{ $page->name_ar }}</h1>
                    {!! $page->content_ar !!}
                    <br/>
                </div>
            </div>
        </div>
    </div>

        <div class="container text-center">
            <div class="body-section alphabet-list">
                <div class="row">
                    <div class="col-md-2">
                        <ul class="en">
                            @foreach($letters['en'] as $letter)
                                <li>{{ $letter }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="alphabet-list-content">


                            @foreach($letters['en'] as $letter)
                                <ul class="en" id="{{$letter}}">
                                    @if(isset($data_en[$letter]))
                                        @foreach($data_en[$letter] as $item)
                                            <li><a href="{{$item['link']}}">{{ $item['name'] }}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            @endforeach

                            @foreach($letters['ar'] as $letter)
                                <ul class="ar" id="{{$letter}}">
                                    @if(isset($data_ar[$letter]))
                                        @foreach($data_ar[$letter] as $item)
                                            <li><a href="contributors/{{$item['slug']}}">{{ $item['name'] }}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2">
                        <ul class="ar letters">
                            @foreach($letters['ar'] as $letter)
                                <li>{{ $letter }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        $('.alphabet-list ul li').on('click',function(){
            $('.alphabet-list-content ul').removeClass('active');
            $('.alphabet-list li').removeClass('active');
            $('#'+$(this).html()).addClass('active');

            if($(window).outerWidth()>767){
                height = $(this).height()+ 6;
                margin = parseInt($(this).css('margin-bottom'));
                targetList = $(this).closest('ul').hasClass('en') ? $('.alphabet-list ul.en li') : $('.alphabet-list .letters li');
                mtop = (margin + height) * ( targetList.index($(this)));
                $('#'+$(this).html()).css('margin-top',mtop);
            }
            $(this).addClass('active');
        });
    </script>
@endsection

