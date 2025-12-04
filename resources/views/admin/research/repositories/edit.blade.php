@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Repository</h3>

                            Link: <a href="{{ url('research?article='.$data->slug) }}">{{ url('research?article='.$data->slug) }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/research/repositories/update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                               
                                    <div class="row">
                                        <div class="col-md-12">
                                          
                                                <input type="hidden" value="{{ isset($data) ? $data->id : '' }}" name="id">
                                            
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <strong>Artical Order</strong>
                                    <div class="row">
                                        <div class="col-md-1">
                                          
                                                
                                            <input type="text" class="text-center" name="order_by"value="{{ isset($data) ? $data->order_by : '' }}" style="width: 40px;height: 37px;">                                            
                                        </div>
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
                                    <label for="exampleInputNamea1">Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title" value="{{ isset($data) ? $data->title : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Sub Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="subtitle" value="{{ isset($data) ? $data->subtitle : '' }}">
                                </div>
                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Content</label>
                                    {{-- <input type="hidden" name="content" value="{{ isset($data) ? $data->content : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($data) ? $data->content : '' !!}
                                    </div> --}}
                                    
                                    <textarea name="content" id="editor">{{  isset($data) ? $data->content : ''  }}</textarea>
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
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Sub Title</label>
                                    <input required type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="subtitle_ar" value="{{ isset($data) ? $data->subtitle_ar : '' }}">
                                </div>
                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Content</label>
                                    {{-- <input type="hidden" name="content_ar" value="{{ isset($data) ? $data->content_ar : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($data) ? $data->content_ar : '' !!}
                                    </div> --}}
                                    <textarea name="content_ar" id="editor">{{  isset($data) ? $data->content_ar : ''  }}</textarea>
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
                                    <strong>Image</strong>
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
                <div class="row" id="is_video">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group">

                                    <strong>Choose:</strong>

                                    <label for="video">&nbspvideo</label>
                                    <input type="radio" id="video" name="type_set" value="video" {{ $data->type_set == 'video' ? 'checked' : '' }}>

                                    <label for="image">&nbspimage</label>
                                   <input type="radio" id="image" name="type_set" value="image" {{ $data->type_set == 'video' ? '' : 'checked' }}>

                    
                                </div>
                                @if($data->content_image)
                                <br/>
                                <img src="{{ asset('public/'.$data->content_image )}}" width="25%">
                                
                                <br/>
                                <br/>

                               
                            @endif
                                <div class="form-group">
                                <strong>Image </strong>
                                <input type="file" class="form-control" name="content_image" placeholder="Upload Image content">
                                </div>


                                <div class="form-group">
                                    <label>Video (Vimeo video ID) Example (https://vimeo.com/<b style="color: red;">252443587</b>):</label>
                                    @if($data->video)
                                        <br/>
                                        <iframe id="vimeovid" src="https://player.vimeo.com/video/{{ $data->video }}" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                        <script src="https://player.vimeo.com/api/player.js"></script>
                                        <br/>
                                        <br/>
                                    @endif

                                    <input type="text" class="form-control" placeholder="" name="video" value="{{ $data->video }}">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="is_not_video">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group" style="" >
                                    <strong>Gallery Images</strong>
                                    @if($data->images)
                                        <br/>
                                        <br/>
                                        <div class="row">
                                            @foreach($data->images as $image)
                                                <div class="col-md-3">
                                                     <img src="{{ asset('public/'.$image->image) }}" width="100%">
                                                    <a href="{{ url('admin/research/repositories/delete-image/'.$image->id) }}">Remove</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <br/>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="file-upload card-box">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Add more (700x1000):</label>
                                                        <input type="file" class="form-control" name="gallery[]" placeholder="Upload Image" multiple>
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
                               
                                    <div class="row">
                                        <div class="col-md-12">
                                          
                                                <input type="hidden" value="{{ isset($data) ? $data->id : '' }}" name="id">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <strong>Artical background</strong>
                                    <div class="row">
                                        <div class="col-md-1">
                                          
                                                
                                                <input required type="color" class="form-control" id="exampleInputNamea1" placeholder="color" name="background" value="{{ isset($data) ? $data->background : '' }}">
                                            
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
                                            <select class="form-control" name="repository_type_id" id="type">
                                                @foreach($types as $item)
                                                    <option value="{{ $item->id }}" {{$item->id == $data->repository_type_id ? 'selected' : '' }}  data-is_video="{{$item->is_video}}">{{ $item->title }}</option>
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
    <script>
        function checkType(){
            is_video = parseInt($('#type option:selected').attr('data-is_video'));

            console.log(is_video);
            if(is_video){
                $('#is_not_video').hide();
                $('#is_video').show();
            } else {
                $('#is_not_video').show();
                $('#is_video').hide();
            }
        }
        checkType();

        $('#type').on('change',function () {
            checkType();
        })
    </script>

@endsection
