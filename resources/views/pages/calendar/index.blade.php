@extends('pages.master')

@section('css')
    <link href="{{ asset('public/css/calendar.css') }}" rel="stylesheet">
    <style>
        .box-links.en a {
            background-image: url({{ asset('public/img/box-list-arrow-left.png') }}) !important;
        }
        .box-links.ar a {
            background-image: url({{ asset('public/img/box-list-arrow-right.png') }}) !important;
        }
    </style>
@endsection

@section('content')
    <div class="innerpage">
            <div class="container text-center">
                <div class="body-section contents with-img-header">
                    <div class="row" dir="rtl">
                        <div class="col-md-6 text-right">
                            <div class="breadcrumbs">
                                @include('partials.breadcrumbs-ar')
                            </div>
                            <h1 class="short-title">{!!  $page->name_ar !!}</h1>
                            {!! $page->content_ar !!}
                        </div>
                        <div class="col-md-6 text-left">
                            <div class="breadcrumbs en">
                                @include('partials.breadcrumbs')
                            </div>
                            <h1 class="en">{!! $page->name !!}</h1>
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="container text-center">
                <div class="body-section contents">
                    <div class="row">
                        <div class="container calendar-container">
                            <div class="controls">
                                <button class="next label" onclick="nextMonth()"><i class="fa fa-arrow-right"></i></button>
                                <button class="previous label" onclick="previousMonth()"><i class="fa fa-arrow-left"></i></button>
                                <p id="current-month" class="label bold" data-toggle="modal" data-target="#dateModal" >January</p>
                            </div>

                            <div id="datepicker">
                                <div class="year">
                                    <div class="head">
                                        <span class="en">YEAR</span>
                                        <span class="ar">السنة</span>
                                    </div>
                                    <ul>
                                        <li><a data-year="2019" href="#">2019</a></li>
                                        <li><a data-year="2020" href="#">2020</a></li>
                                        <li><a data-year="2021" href="#">2021</a></li>
                                        <li><a data-year="2022" href="#">2022</a></li>
                                        <li><a data-year="2023" href="#">2023</a></li>
                                        <li><a data-year="2024" href="#">2024</a></li>
                                        <li><a data-year="2025" href="#">2025</a></li>
                                        <li><a data-year="2026" href="#">2026</a></li>
                                        <li><a data-year="2027" href="#">2027</a></li>
                                        <li><a data-year="2028" href="#">2028</a></li>
                                        <li><a data-year="2029" href="#">2029</a></li>
                                        <li><a data-year="2030" href="#">2030</a></li>
                                    </ul>
                                </div>
                                <div class="month">
                                    <div class="head">
                                        <span class="en">MONTH</span>
                                        <span class="ar">الشهر</span>
                                    </div>
                                    <ul>
                                        <li><a data-month="0" href="#" class="en">JANUARY</a><a data-month="0" href="#" class="ar">يناير</a></li>
                                        <li><a data-month="1" href="#" class="en">FEBRUARY</a><a data-month="1" href="#" class="ar">فبراير</a></li>
                                        <li><a data-month="2" href="#" class="en">MARCH</a><a data-month="2" href="#" class="ar">مارس</a></li>
                                        <li><a data-month="3" href="#" class="en">APRIL</a><a data-month="3" href="#" class="ar">أبريل</a></li>
                                        <li><a data-month="4" href="#" class="en">MAY</a><a data-month="4" href="#" class="ar">مايو</a></li>
                                        <li><a data-month="5" href="#" class="en">JUNE</a><a data-month="5" href="#" class="ar">يونيو</a></li>
                                        <li><a data-month="6" href="#" class="en">JULY</a><a data-month="6" href="#" class="ar">يوليو</a></li>
                                        <li><a data-month="7" href="#" class="en">AUGUST</a><a data-month="7" href="#" class="ar">أغسطس</a></li>
                                        <li><a data-month="8" href="#" class="en">SEPTEMBER</a><a data-month="8" href="#" class="ar">سبتمبر</a></li>
                                        <li><a data-month="9" href="#" class="en">OCTOBER</a><a data-month="9" href="#" class="ar">أكتوبر</a></li>
                                        <li><a data-month="10" href="#" class="en">NOVEMER</a><a data-month="10" href="#" class="ar">نوفمبر</a></li>
                                        <li><a data-month="11" href="#" class="en">DECEMBER</a><a data-month="11" href="#" class="ar">ديسمبر</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="calendar" id="calendar">
                                <!-- Calandar HTML output here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container text-center">
                <div class="body-section contents">
                    <div class="row">
                        <div class="container calendar-container">
                            <div class="row" dir="rtl">
                                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                    <div class="box-links ar">
                                        <ul style="padding-right:0">
                                            <li><a style="    height: auto;float: left !important;
    line-height: 17px;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-right: 30px;" href="{{ url('pages/programs/calendar/upcoming-events') }}"><span class="ar">الفعاليات المقبلة </span><br/> UPCOMING EVENTS</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                                    <div class="box-links en">
                                        <ul>
                                            <li><a style="    height: auto;float: right !important;
    line-height: 17px;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 30px;" href="{{ url('pages/programs/calendar/previous-events') }}"><span class="ar">الفعاليات السابقة </span><br/>PREVIOUS EVENTS</a></li>
                                        <ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('js')
    <script>
        // Globally head date object for the month shown
        var date = new Date();
        var eventDates = [];
        var eventLinks = [];

        jQuery(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "{{ url('api/calendar/get-all-events') }}",
                method: 'get',
                success: function(result){
                    console.log(result);
                    $(JSON.parse(result)).each(function(){
                        eventDates.push(this.publish_date);
                        eventDates[this.publish_date] = this.link;
                        eventLinks[this.publish_date] = this.link;
                    })
                },
                complete: function(){
                    console.log(eventDates);
                    createMonth();
                }
            });
        });

    </script>
    <script src="{{ asset('public/js/calendar.js') }}"></script>
@endsection

