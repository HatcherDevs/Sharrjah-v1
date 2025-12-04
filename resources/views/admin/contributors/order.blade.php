@extends('admin.partials.master')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        ul {
            list-style: none;
        }

        #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
        #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
        #sortable li span { position: absolute; margin-left: -1.3em; }

        .ui-icon-arrowthick-2-n-s {
            width:5%;
            margin: 10px 0;
            cursor: move;
        }

        .ui-state-default {
            margin-bottom:3px;
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
                            <h3>Change Contributor Ordering</h3>
                        </div>
                    </div>
                </div>
            </div>
            <form class="forms-sample" action="{{ url('admin/contributors/order') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row flex-grow">

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @foreach($data_en as $key=>$group)
                                    <label for="exampleInputName1">{{$key}}</label>
                                    <ul class="form-group sortable">
                                        <?php $order = 0; ?>
                                        @foreach($group as $item)
                                            <li class="form-group clearfix ui-state-default">
                                                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                                <input type="hidden" value="{{ $item['id'] }}" name="contributors[{{ $item['id'] }}][id]">
                                                <input type="hidden" value="{{ $item['order'] }}" name="contributors[{{ $item['id'] }}][order]" class="roworder form-control" style="float:left;width:10%">
                                                <input type="text" value="{{ $item['name'] }}" class="form-control" disabled="disabled" style="float:left;width:95%">
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="form-group">
                                        <h3>&nbsp;</h3>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @foreach($data_ar as $key=>$group)
                                    <label for="exampleInputName1">{{$key}}</label>

                                    <ul class="form-group sortable" style="text-align:right;">
                                        <?php $order = 0; ?>
                                        @foreach($group as $item)
                                            <li class="form-group clearfix ui-state-default">
                                                <input type="hidden" value="{{ $item['id'] }}" name="contributors[{{ $item['id'] }}][id]">
                                                <input type="text" value="{{ $item['name'] }}" class="form-control" disabled="disabled" style="float:left;width:95%;text-align: right;">
                                                <input type="hidden" value="{{ $item['order'] }}" name="contributors[{{ $item['id'] }}][order_ar]" class="form-control roworder" style="float:left;width:9%">
                                                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="form-group">
                                        <h1>&nbsp;</h1>
                                    </div>
                                @endforeach
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
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( ".sortable" ).sortable({
                update: function( event, ui ) {
                    updateOrderData();
                }
            });
            $( ".sortable" ).disableSelection();
        } );

        function updateOrderData(){
            $('.sortable').each(function(){
                loop = 1;
                $(this).find('li').each(function(){
                    $(this).find('.roworder').val(loop);
                    loop++;
                });
            });
        }
    </script>
@endsection