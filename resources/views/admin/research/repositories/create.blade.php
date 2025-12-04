@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Add Repository</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/research/repositories') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">English</h4>
                               
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Title</label>
                                    <input required type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title" value="{{ isset($page) ? $page->title : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Sub Title</label>
                                    <input required type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="subtitle" value="{{ isset($page) ? $page->subtitle : '' }}">
                                </div>
                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Content</label>
                                    {{-- <input type="hidden" name="content" value="{{ isset($page) ? $page->content : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($page) ? $page->content : '' !!}
                                    </div> --}}
                                    <textarea name="content" id="editor">{!! isset($page) ? $page->content : '' !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">Arabic</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title_ar" value="{{ isset($page) ? $page->title_ar : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Sub Title</label>
                                    <input required type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="subtitle_ar" value="{{ isset($page) ? $page->subtitle_ar : '' }}">
                                </div>
                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Content</label>
                                    {{-- <input type="hidden" name="content_ar" value="{{ isset($page) ? $page->content_ar : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($page) ? $page->content_ar : '' !!}
                                    </div> --}}
                                    <textarea name="content_ar" id="editor">{!! isset($page) ? $page->content_ar : '' !!}</textarea>
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
                                <div class="form-group">
                                    <strong>Type</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" name="repository_type_id" id="type">
                                                @foreach($types as $item)
                                                    <option value="{{ $item->id }}" data-is_video="{{$item->is_video}}">{{ $item->title }}</option>
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
                                    <strong>Type</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                          
                                                <label for="exampleInputNamea1">color</label>
                                                <input required type="color" class="form-control" id="exampleInputNamea1" placeholder="color" name="background" value="{{ $data->background }}">
                                            
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
                                    <input type="radio" id="video"
                                    name="type_set" value="video" checked>
                    
                                    <label for="image">&nbspimage</label>
                                   <input type="radio" id="image"
                                   name="type_set" value="image">
                                  
                                </div>
                                <div class="form-group">
                                <strong>Image </strong>
                                <input type="file" class="form-control" name="content_image" placeholder="Upload Image content">
                                </div>
                                <div class="form-group">
                                    <strong>Video (Vimeo video ID) Example (https://vimeo.com/<span style="color: red;">252443587):</span></strong>
                                    <input type="text" class="form-control" placeholder="" name="video" value="">
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
                                    <br/>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="file-upload card-box">
                                                <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                        <label>(700x1000):</label>
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
