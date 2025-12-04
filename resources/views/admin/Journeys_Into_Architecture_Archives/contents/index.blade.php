@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Event</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/Journeys_Into_Architecture_Archives/series-contents') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <input type="hidden" value="{{ $data->id  }}" name="id">

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">English</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Series 1 Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="series_1_title" value="{{ isset($data) ? $data->series_1_title : '' }}">
                                </div>

                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Series 1 Description</label>
                                    <input type="hidden" name="series_1_description" value="{{ isset($data) ? $data->series_1_description : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($data) ? $data->series_1_description : '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">Arabic</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Series 1 Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="series_1_title_ar" value="{{ isset($data) ? $data->series_1_title_ar : '' }}">
                                </div>
                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Series 1 Description</label>
                                    <input type="hidden" name="series_1_description_ar" value="{{ isset($data) ? $data->series_1_description_ar : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($data) ? $data->series_1_description_ar : '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">English</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Series 2 Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="series_2_title" value="{{ isset($data) ? $data->series_2_title : '' }}">
                                </div>

                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Series 2 Description</label>
                                    <input type="hidden" name="series_2_description" value="{{ isset($data) ? $data->series_2_description : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($data) ? $data->series_2_description : '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">Arabic</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Series 2 Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="series_2_title_ar" value="{{ isset($data) ? $data->series_2_title_ar : '' }}">
                                </div>
                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Series 2 Description</label>
                                    <input type="hidden" name="series_2_description_ar" value="{{ isset($data) ? $data->series_2_description_ar : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($data) ? $data->series_2_description_ar : '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <label for="exampleInputEmail3">Show Series</label>
                                <select class="form-control" name="show_series">
                                    <option @if($data->show_series ==1) selected @endif value="1">Show</option>
                                    <option @if($data->show_series ==0) selected @endif value="0">Hidden</option>
                                </select>
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
    <script>

    </script>
@endsection
