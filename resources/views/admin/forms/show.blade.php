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

        button {
            border: 1px solid #ccc;
            background-color: #3694f7;
            color: #fff !important;
        }

        #surveyElements {
            background-color: #ebebeb;
            padding: 20px;
        }

        .addQBT {
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">


            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Form</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/forms/update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                @include('admin.forms.form')
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <div class="box-body pad">
                                    <form class="forms-sample" action="{{ url('admin/forms') }}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                                    <input type="hidden" value="{{ $form->id }}" name="id">
                                    <div class="col-md-12">
                                        <hr>
                                        <h3>Questions</h3>
                                        <div id="surveyElements">
                                            @foreach($form->questions as $index=>$question)
                                                <?php
                                                $el = '';

                                                if($question->type){

                                                    $el = '<div class="form-group clearfix ui-state-default" data-id="'.$question->id.'">';

                                                    if($question->type->slug=='text')
                                                    {
                                                        $el .='<label>Text Field Question </label>';
                                                    } else if ($question->type->slug=='textarea')
                                                    {
                                                        $el .='<label>Textarea Question </label>';
                                                    } else if ($question->type->slug=='radio')
                                                    {
                                                        $el .='<label>Multiple Choices with single answers</label>';
                                                    } else if ($question->type->slug=='checkbox')
                                                    {
                                                        $el .='<label>Multiple Choices with multiple answers</label>';
                                                    } else if ($question->type->slug=='date')
                                                    {
                                                        $el .='<label>Date Question </label>';
                                                    } else if ($question->type->slug=='file')
                                                    {
                                                        $el .='<label>Date Question </label>';
                                                    }

                                                    $el .='<div class="clearfix"><input type="text" class="form-control" name="question['.$question->id.'][question]" style="float:left; width:49%; margin-bottom: 10px;" value="'.$question->question.'" placeholder="Add question here...">';
                                                    $el .='<input type="text" class="form-control" name="question['.$question->id.'][question_ar]" style="float:right; width:49%; margin-bottom: 10px;" value="'.$question->question_ar.'" placeholder="Add question here..."></div>';
                                                    $el .='<span class="delete-question">X</span>';

                                                    if ($question->type->slug=='radio'|| $question->type->slug=='checkbox')
                                                    {
                                                        $el .='<div class="row"><div class="col-md-6"><label>Choices</label></div></div>';
                                                        $choiceCount = 1;

                                                        $el .= '<div class="choices">';
                                                            $el .= '<div class="row choice">';
                                                                $el .= '<div class="col-md-6 en">EN:</br>';
                                                                    foreach($question->choices as $question->idIn=>$choice){
                                                                        $el .= '<div class="choice"><input type="text" name="question['.$question->id.'][choices]['.$choiceCount.'][choice][en]" value="'.$choice->value.'">';

                                                                        if($choiceCount>1)
                                                                            $el .= '<span class="glyphicon glyphicon-remove-sign delete-choice" aria-hidden="true"></span>';

                                                                        $choiceCount++;

                                                                        $el .= '</div>';
                                                                    }
                                                                $el .= '</div>';

                                                                $choiceCount = 1;

                                                                $el .= '<div class="col-md-6 ar">AR:</br>';
                                                                    foreach($question->choices as $question->idIn=>$choice){
                                                                        $el .= '<div class="choice"><input type="text" name="question['.$question->id.'][choices]['.$choiceCount.'][choice][ar]" value="'.$choice->value_ar.'">';

                                                                        if($choiceCount>1)
                                                                            $el .= '<span class="glyphicon glyphicon-remove-sign delete-choice" aria-hidden="true"></span>';

                                                                        $choiceCount++;
                                                                        $el .= '</div>';
                                                                    }
                                                                $el .= '</div>';
                                                            $el .= '</div>';
                                                        $el .= '</div>';

                                                        $el .='<button type="button" class="addQBT">+ Add a choices</button><br>';
                                                    }

                                                    $el .='<div class="row"><div class="field-group col-md-6"><br><br>';

                                                    $el .='<input type="hidden" name="question['.$question->id.'][type]" value="'.$question->type->slug.'">';

                                                    $el .='<br></div><div class="col-md-6"><label class="pull-right answer-required">Answer required <input name="question['.$question->id.'][is_required]" value="1" type="checkbox" '.( $question->is_required ? 'checked' : '').'></label></div>';

                                                    $el .='</div>';

                                                    $el .='<input type="text" class="count" readonly="readonly" name="question['.$question->id.'][order]" value="'.$question->order.'">';

                                                    $el .='</div>';

                                                    echo $el;
                                                }
                                                ?>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <br>
                                        <br>
                                        <label>Type</label>

                                        <select class="selectpicker form-control" id="typeSelector">
                                            <option value="text">Text</option>
                                            <option value="checkbox">Multi-selection</option>
                                            <option value="radio">Selection</option>
                                            <option value="file">File Upload</option>
                                            <option value="date">Date</option>
                                            <option value="textarea">Paragraph</option>
                                        </select>

                                        <br>
                                        <button id="addQuestionBt" type="button" class="pull-left">Add a question</button>
                                        <button id="submitForm" class="pull-right">Save Form</button>
                                    </div>
                                    </div>

                                    </form>
                                </div>
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
    <script>
        addQBTClickEvent();
        addRBTClickEvent();
        addDeleteQuestionClickEvent();
        updateSortable();
    </script>
@endsection