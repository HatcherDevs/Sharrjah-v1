@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Research Building</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/research/buildings/update') }}" method="post" enctype="multipart/form-data">
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

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Lat</label>
                                    <input required type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="lat" value="{{ isset($data) ? $data->lat : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Long</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="lng" value="{{ isset($data) ? $data->lng : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group" style="border-top:3px solid #ccc" >
                                    <br/>
                                    <strong>Primary Image</strong>
                                    <br/>
                                    @if($data->image)
                                        <img src="{{ asset('public/'.$data->image) }}" width="300">
                                    @endif
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="file-upload card-box">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>(1000x700):</label>
                                                        <input type="file" class="form-control" name="image" placeholder="Upload Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                <div class="form-group" style="border-top:3px solid #ccc" >
                                    <br/>
                                    <strong>Gallery Images</strong>
                                    <br/>
                                    @if($data->images)
                                        <br/>
                                        <br/>
                                        <div class="row">
                                            @foreach($data->images as $image)
                                                <div class="col-md-3">
                                                    <img src="{{ asset('public/'.$image->image) }}" width="100%">
                                                    <a href="{{ url('admin/research/buildings/delete-image/'.$image->id) }}">Remove</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="file-upload card-box">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>(1000x700):</label>
                                                        <input type="file" class="form-control" name="gallery[]" placeholder="Upload Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                <div class="form-group">
                                    <strong>Year</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" name="year">
                                                <option value="pre-1960" {{ $data->year == 'pre-1960' ? 'selected' : '' }}>Pre-1960</option>
                                                <option value="1960-1980" {{ $data->year == '1960-1980' ? 'selected' : '' }}>1960-1980</option>
                                                <option value="1981-2000" {{ $data->year == '1981-2000' ? 'selected' : '' }}>1981-2000</option>
                                                <option value="2001-2020" {{ $data->year == '2001-2020' ? 'selected' : '' }}>2001-2020</option>
                                                <option value="post-2020" {{ $data->year == 'post-2020' ? 'selected' : '' }}>Post-2020</option>
                                            </select>
                                        </div>
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
                                <div class="form-group">
                                    <strong>Type</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" name="research_type_id">
                                                @foreach($types as $item)
                                                    <option value="{{ $item->id }}" {{$item->id == $data->research_type_id ? 'selected' : '' }}>{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
