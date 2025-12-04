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
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Form Entries</h3>
                        </div>
                    </div>
                </div>
            </div>
            <form class="forms-sample" action="{{ url('admin/forms') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <table width="100%" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($entries))
                                        @foreach($entries as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td><a href="{{ url('admin/forms/entries/items/'.$item->id) }}">View</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
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


