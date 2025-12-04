@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Research Type</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/research/types/update') }}" method="post" enctype="multipart/form-data">
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
                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Content</label>
                                    {{-- <input type="hidden" name="content" value="{{ isset($data) ? $data->content : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($data) ? $data->content : '' !!}
                                    </div> --}}
                                    <textarea name="content" id="editor">{!! isset($data) ? $data->content : '' !!}</textarea>
                                </div>
                                <div class="checkbox-wrapper">
                                    {{-- <input type="hidden" name="{{$timeline}}_is_hidden" value="0">  --}}
                                    <input type="hidden" name="content_is_hidden" value="0">

                                    <input type="checkbox" class="form-check-input checkbox-style" id="contentIsHidden" name="content_is_hidden" value="1" {{ isset($data) && $data->content_is_hidden ? 'checked' : '' }}>
                                    <label class="checkbox-label" for="contentIsHidden">Hide Content</label>
                                
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
                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Content</label>
                                    {{-- <input type="hidden" name="content_ar" value="{{ isset($data) ? $data->content_ar : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($data) ? $data->content_ar : '' !!}
                                    </div> --}}
                                    <textarea name="content_ar" id="editor">{!! isset($data) ? $data->content_ar : '' !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $timelines = ['pre-1960','1960-1980','1981-2000','2001-2020','post-2020']; ?>

                <?php
                    $data->toArray();
                ?>

                @foreach($timelines as $timeline)
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body"><h4 class="card-title">English</h4>
                                    <div class="form-group content">
                                        <label for="exampleInputEmail3">{{$timeline}} Content</label>
                                        <textarea class="form-control" name="{{$timeline}}" rows="10">{{$data[$timeline]}}</textarea>
                                    </div>

                                    <div class="checkbox-wrapper">
                                        <input type="hidden" name="{{$timeline}}_is_hidden" value="0"> <!-- Add this hidden input -->
                                        
                                        <input type="checkbox" class="form-check-input checkbox-style" name="{{$timeline}}_is_hidden" value="1" {{ $data[$timeline.'_is_hidden'] ? 'checked' : '' }}>
                                        <label class="checkbox-label" for="{{$timeline}}_is_hidden">Hide Content</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body"><h4 class="card-title">Arabic</h4>
                                    <div class="form-group content">
                                        <label for="exampleInputEmail3">{{$timeline}} Content</label>
                                        <textarea class="form-control" name="{{$timeline}}_ar" rows="10">{{$data[$timeline.'_ar']}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

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
