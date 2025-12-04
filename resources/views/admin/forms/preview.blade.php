
@extends('admin.partials.master')

@section('css')
    <style>
        #surveyElements {
            position: relative;
            float: left;
            width: 100%;
        }
        #surveyElements .form-group {
            border: 3px solid #3694f7;
            padding: 5px 20px;
            width: 100%;
            background-color: #fff;
            position: relative;
            float: left;
        }
        #surveyElements .count, #surveyElements .delete-question, #surveyElements .move-question {
            border: 0;
            width: auto;
            background-color: #3694f7;
            width: 30px;
            height: 30px;
            text-align: center;
            padding-left: 5px;
            color: #fff;
            position: absolute;
            top: -3px;
            left: -32px;
            border-top-left-radius: 50%;
            border-bottom-left-radius: 50%;
            font-size: 16px;
        }

        #surveyElements .glyphicon {
            line-height: 30px;
            cursor: pointer;
        }

        #surveyElements .delete-question {
            top: 32px;
            left: -32px;
        }

        #surveyElements .form-group .delete-choice {
            margin-left: 5px;
            color: #fb4c4c;
        }
        #surveyElements .move-question {
            top: 67px;
            left: -32px;
        }

        .field-group input {
            margin-bottom: 5px;
            padding: 0px 10px;
        }

        .answer-required {
            border: 1px solid #ccc;
            padding: 5px 10px;
            font-weight: normal;
            margin-top: 10px;
        }

        button,input[type="submit"] {
            border: 1px solid #ccc;
            background-color: #3694f7;
            color: #fff !important;
        }

        #surveyElements {
            background-color: #ebebeb;
            padding: 20px;
        }
    </style>
@endsection

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <form class="forms-sample" action="{{ url('admin/forms') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @if($data)
                                    <h1 class="panel-title">{{ $data->title }}</h1>

                                    @if($data->photo || $data->thumbnailLong)
                                        <img src="{{ $data->photo ? $data->photo : $data->thumbnailLong }}" width="100%" class="margin-b-10">
                                    @endif

                                    {!! str_replace("&nbsp;"," ",$data->description) !!}
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    @foreach($data->questions as $index=>$question)
                                        <?php $qID = $data->questions[$index]->id; ?>
                                        <div class="form-group clearfix ui-state-default" data-id="{{ $question->id }}">
                                            <div class="row">
                                                <div class="col-md-6 text-left">
                                                    <label>{{ $question->question }}</label>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <label>{{ $question->question_ar }}</label>
                                                </div>
                                            </div>
                                            <br>
                                            @if($question->type->slug=='radio' || $question->type->slug=='checkbox')

                                            <div class="row">
                                                <div class="col-md-6 text-left">
                                                    @foreach($question->choices as $index=>$choice)
                                                        <input id="{{$choice->id}}"  {{ $index==0 ? 'checked' : '' }} type="{{ $question->type->slug }}" name="questions[{{$qID}}][]" value="{{$choice->value}}">
                                                        <label for="{{$choice->id}}">{{$choice->value}}</label>
                                                        <br>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    @foreach($question->choices as $index=>$choice)
                                                        <input id="{{$choice->id}}"  {{ $index==0 ? 'checked' : '' }} type="{{ $question->type->slug }}" name="questions[{{$qID}}][]" value="{{$choice->value_ar}}">
                                                        <label for="{{$choice->id}}">{{$choice->value_ar}}</label>
                                                        <br>
                                                    @endforeach
                                                </div>
                                            </div>

                                            @elseif($question->type->slug=='textarea')
                                                <textarea name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}></textarea>

                                            @elseif($question->type->slug=='file')
                                                <input type="file" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}>
                                            @elseif($question->type->slug=='date')
                                                <input type="text" class="datepicker" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}>
                                            @else

                                                <div class="row">
                                                    <div class="col-md-6 text-left">
                                                        <input type="text" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <input type="text" name="questions[{{$qID}}]" {{ $question->is_required ? 'required="required"' : '' }}>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    @endforeach
                                @else
                                    <h1 class="alert-danger alert">Article not found.</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('public/js/survey.js') }}"></script>
@endsection