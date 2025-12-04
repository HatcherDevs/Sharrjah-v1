@extends('pages.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('public/css/search.css') }}">
@endsection

@section('content')
    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents">
                <div class="row" dir="rtl">
                    <div class="col-md-6 text-right">
                        <h1>نتائج البحث</h1>
                    </div>
                    <div class="col-md-6 text-left">
                        <h1>SEARCH RESULT</h1>
                    </div>
                </div>
            </div>
            <div class="body-section contents">
                <div class="row" dir="rtl">
                    <div class="col-md-12 text-left">
                        <form action="{{ url('search') }}" method="post">
                            <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                            <input type="text" id="searchbox" name="keyword" value="{{$keyword}}">
                            <input type="submit" id="searchbt" value="">
                        </form>
                    </div>
                </div>
            </div>
            <div class="body-section contents">
                <div class="row" dir="rtl">
                    <div class="col-md-12 text-left">
                        <label>Your search query for ‘{{$keyword}}’ returned the following  matches:</label>
                        <ul style="width:100%;">
                            <li><a href="#"> </a></li>
                            @foreach($data['pages'] as $item)
                                <li><a href="{{url($item->link)}}">{{$item->name}}</a></li>
                            @endforeach
                            @foreach($data['posts'] as $item)
                                <li><a href="{{url($item->link)}}">{{$item->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

