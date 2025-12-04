@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Media</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/research/repositories/types/update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <input type="hidden" value="{{ $data->id }}" name="id">

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">English</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Title</label>
                                    <input required type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title" value="{{ isset($data) ? $data->title : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">Arabic</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title_ar" value="{{ isset($data) ? $data->title_ar : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--                <div class="row">--}}
                {{--                    <div class="col-md-12 grid-margin stretch-card">--}}
                {{--                        <div class="card">--}}
                {{--                            <div class="card-body">--}}
                {{--                                <div class="form-group" style="border-top:3px solid #ccc" >--}}
                {{--                                    <br/>--}}
                {{--                                    <strong>Podcasts Page Image</strong>--}}
                {{--                                    <br/>--}}
                {{--                                    <br/>--}}
                {{--                                    <div class="row">--}}
                {{--                                        <div class="col-md-12">--}}
                {{--                                            <div class="file-upload card-box">--}}
                {{--                                                <div class="row">--}}
                {{--                                                    <div class="col-md-12">--}}
                {{--                                                        <label>List Page Image (1000x1000):</label>--}}
                {{--                                                        <input type="file" class="form-control" name="images[1][landscape]" placeholder="Upload Image">--}}
                {{--                                                    </div>--}}
                {{--                                                </div>--}}
                {{--                                            </div>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}


                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <select name="is_video" class="form-control">
                                        <option value="1" {{ $data->is_video ? 'selected' : '' }}>Video</option>
                                        <option value="0" {{ !$data->is_video ? 'selected' : '' }}>Article (No Video)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">show on " Filter by: "</h4>
                                <div class="form-group">
                                    <select class="form-control" name="is_hidden">


                                        <option value="1" {{!$data->is_hidden? 'selected' : ''}}>Hidden</option>
                                        <option value="0" {{!$data->is_hidden? 'selected' : ''}}>Visible</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
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

@endsection
