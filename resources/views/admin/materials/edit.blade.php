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

            <form class="forms-sample" action="{{ url('admin/materials/update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <input type="hidden" value="{{ $page->id  }}" name="id">
                <input type="hidden" value="{{ $page->is_video }}" name="is_video">
                <input type="hidden" value="{{ $page->is_open }}" name="is_open">

                {{--<div class="row">--}}
                    {{--<div class="col-md-12 grid-margin stretch-card">--}}
                        {{--<div class="card">--}}
                            {{--<div class="card-body">--}}
                                {{--<a target="_blank" href="{{ URL('materials/preview/'.$page->id) }}">Click here to preview page</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">English</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title" value="{{ isset($page) ? $page->title : '' }}">
                                </div>

                                <div class="form-group" style="">
                                    <div class="form-group">
                                        <label>Excerpt:</label>
                                        <input type="text" class="form-control" placeholder="Excerpt (Max 10 words)" name="excerpt" value="{{ isset($page) ? $page->excerpt : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Type</label>
                                    <?php
                                    $types = [
                                        ['value'=>'page','name'=>'Page'],
                                        ['value'=>'url','name'=>'Link to external page'],
                                        ['value'=>'file','name'=>'Links to file'],
                                        ['value'=>'blank','name'=>'No link']
                                    ];

                                    if($pageType['en']['type'] == "url" && $pageType['en']['value']->url == "#")
                                        $pageType['en']['type'] = "blank";
                                    ?>

                                    <select class="form-control type_select" name="external[en][type]" data-lang="en">
                                        @foreach($types as $type)
                                            <option value="{{ $type['value'] }}" {{ $pageType['en']['type'] == $type['value'] ? 'selected=selected' : ""  }}>{{ $type['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group type-box url" style="{{ ($pageType['en']['type'] == 'url' && $pageType['en']['value']->url != '#') ? 'display:block' : ''}}">
                                    <div class="hidden link">
                                        <label>Page URL:</label>
                                        <input type="text" class="form-control" placeholder="External link" name="external[en][value]" value="{{ $pageType['en']['type']  == 'url' ? $pageType['en']['value']->url : ""  }}">
                                    </div>
                                </div>

                                <div class="form-group type-box file" style="{{ $pageType['en']['type']  == 'file' ? 'display:block' : ''}}">
                                    <div class="hidden link">
                                        <label>
                                            Upload file: <br/><br/>
                                            @if($pageType['en']['type'] == 'file')
                                                <a href="{{ url('public/'.$pageType['en']['value']->path.'/'.$pageType['en']['value']->file_name) }} ">{{ $pageType['en']['value']->original_name }}</a>
                                            @endif
                                        </label>

                                        <input type="file" class="form-control" placeholder="External link" name="external_file_en">
                                    </div>
                                </div>

                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Content</label>
                                    <input type="hidden" name="content" value="{{ isset($page) ? $page->content : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($page) ? $page->content : '' !!}
                                    </div>
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
                                <div class="form-group" style="">
                                    <div class="form-group">
                                        <label>Excerpt:</label>
                                        <input type="text" class="form-control" placeholder="Excerpt (Max 10 words)" name="excerpt_ar" value="{{ isset($page) ? $page->excerpt_ar : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Type</label>
                                    <?php
                                    $types = [
                                        ['value'=>'page','name'=>'Page'],
                                        ['value'=>'url','name'=>'Link to external page'],
                                        ['value'=>'file','name'=>'Links to file'],
                                        ['value'=>'blank','name'=>'No link']
                                    ];

                                    if($pageType['ar']['type'] == "url" && $pageType['ar']['value']->url == "#")
                                        $pageType['ar']['type'] = "blank";
                                    ?>

                                    <select class="form-control type_select" name="external[ar][type]" data-lang="en">
                                        @foreach($types as $type)
                                            <option value="{{ $type['value'] }}" {{ $pageType['ar']['type'] == $type['value'] ? 'selected=selected' : ""  }}>{{ $type['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group type-box url" style="{{ ($pageType['ar']['type'] == 'url' && $pageType['ar']['value']->url != '#') ? 'display:block' : ''}}">
                                    <div class="hidden link">
                                        <label>Page URL:</label>
                                        <input type="text" class="form-control" placeholder="External link" name="external[ar][value]" value="{{ $pageType['ar']['type']  == 'url' ? $pageType['ar']['value']->url : ""  }}">
                                    </div>
                                </div>


                                <div class="form-group type-box file" style="{{ $pageType['ar']['type']  == 'file' ? 'display:block' : ''}}">
                                    <div class="hidden link">
                                        <label>
                                            Upload file:
                                            @if($pageType['ar']['type'] == 'file')
                                                <a href="{{ url('public/'.$pageType['ar']['value']->path.'/'.$pageType['ar']['value']->file_name) }} ">{{ $pageType['ar']['value']->original_name }}</a>
                                            @endif
                                        </label>
                                        <input type="file" class="form-control" placeholder="External link" name="external_file_ar">
                                    </div>
                                </div>

                                <div class="form-group content">
                                    <label for="exampleInputEmail3">Content</label>
                                    <input type="hidden" name="content_ar" value="{{ isset($page) ? $page->content_ar : '' }}"/>
                                    <div class="summernote">
                                        {!! isset($page) ? $page->content_ar : '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($page->is_video)
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Video (Vimeo video ID) Example (https://vimeo.com/<b style="color: red;">252443587</b>):</label>
                                        @if($page->video_file)
                                            <br/>
                                            <iframe id="vimeovid" src="https://player.vimeo.com/video/{{ $page->video_file }}" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                            <script src="https://player.vimeo.com/api/player.js"></script>
                                            <br/>
                                            <br/>
                                        @endif
                                        <input type="text" class="form-control" placeholder="" name="video_file" value="{{ $page->video_file }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.posts.publish-date')
                                @include('admin.partials.pages.status')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @if(count($page->sliders))
                                    <div class="form-group" style="border-top:3px solid #ccc">
                                        <br/>
                                        <strong>Post Page Image</strong>
                                        <br/><br/>

                                        <div class="row" id="current-images">

                                            <div class="col-md-3">
                                                @if($page->sliders[0]->landscape)
                                                    <img src="{{ asset('public'.$page->sliders[0]->landscape->url) }}" width="100%">
                                                    <br/>
                                                    <br/>
                                                    <div class="form-group">
                                                        <label>Replace Thumbnail and Actual Page Image(1000x1000):</label>
                                                        <input type="file" class="form-control" name="images[{{$page->sliders[0]->landscape->id}}][landscape]" placeholder="Upload Image">
                                                    </div>
                                                @else
                                                    <div class="form-group">
                                                        <label>Add Thumbnail and Actual Page Image(1000x1000):</label>
                                                        <input type="hidden" name="newUploads[slide_id]" value="{{$page->sliders[0]->id}}">
                                                        <input type="file" class="form-control" name="images[0][landscape]" placeholder="Upload Image">
                                                    </div>
                                                @endif
                                                <input type="hidden" name="uploads[{{$slide->square->id}}][id]" value="{{ $slide->square->id }}" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            @if(!$page->is_video)
                                @if(count($page->sliders))
                                    <div class="form-group" style="border-top:3px solid #ccc">
                                        <br/>
                                        <strong>Podcast Slide Images</strong>
                                        <br/>

                                        <div class="row" id="current-images">
                                            <?php $c = 1; ?>
                                            @foreach($page->sliders as $slide)
                                                <div class="file-upload" style="width:100%;">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <img src="{{ asset('public'.$slide->square->url) }}" width="100%">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Caption EN:</label>
                                                                <input type="text" class="form-control" placeholder="Image Caption EN" name="upload-captions[{{$slide->square->id}}][EN]"  value="{{ $slide->square->caption }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Caption AR:</label>
                                                                <input type="text" class="form-control" placeholder="Image Caption AR" name="upload-captions[{{$slide->square->id}}][AR]"  value="{{ $slide->square->caption_ar }}">
                                                            </div>

                                                            @if($slide->square)
                                                                <div class="form-group">
                                                                    <label>Replace Image (1000x1000):</label>
                                                                    <input type="file" class="form-control" name="uploads[{{$slide->square->id}}]" placeholder="Upload Image">
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <label>Add Image (1000x1000)::</label>
                                                                    <input type="hidden" name="newUploads[slide_id]" value="{{$slide->id}}">
                                                                    <input type="file" class="form-control" name="newUploads[square]" placeholder="Upload Image">
                                                                </div>
                                                            @endif

                                                            @if($c>1)
                                                                <div class="form-group">
                                                                    <label>Delete: <br/><br/><input type="checkbox" class="form-control" name="delete[{{$slide->id}}]" placeholder="Upload Image" value="{{$slide->id}}"></label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $c++; ?>
                                            @endforeach

                                            <div class="col-md-12" id="file-uploads">
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button class="form-control" id="add-file" type="button">Add more images</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if(!$page->is_video)
                                <div class="form-group" style="border-top:3px solid #ccc;display: none;" >
                                    <div class="row">
                                        <div class="col-md-12" id="file-uploads">
                                            <div class="file-upload card-box">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="file" class="form-control" name="images[1][square]" placeholder="Upload Image">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="file" class="form-control" name="images[1][landscape]" placeholder="Upload Image">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Image Caption EN" name="captions[1][EN]">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Image Caption AR" name="captions[1][AR]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if(!$page->is_video)
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.pages.button-link')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group" style="border-top: 3px solid #ccc;padding-top: 20px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="exampleTextareaa1">Additional Content EN</label>
                                            <div class="form-group">
                                                <input type="hidden" name="additional_content_bottom" value="{{ isset($page) ? $page->additional_content_bottom : '' }}">
                                                <div class="summernote">
                                                    @if(isset($page))
                                                        {!! $page->additional_content_bottom !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <br/>
                                            <br/>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="exampleTextareaa1">Additional Content AR</label>
                                            <div class="form-group">
                                                <input type="hidden" name="additional_content_top" value="{{ isset($page) ? $page->additional_content_top : '' }}">
                                                <div class="summernote">
                                                    @if(isset($page))
                                                        {!! $page->additional_content_top !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <br/>
                                            <br/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endif

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
        $('#add-file').on('click',function(){
            index = $('#file-uploads .file-upload').length + 1;

            el = '\n' +
                '            <div class="file-upload card-box">\n' +
                '                <div class="row">\n' +
                '                <button class="remove-box" type="button">X</button>\n' +
                '                    <div class="col-md-12">\n' +
                '                        <div class="form-group">\n' +
                '                            <label>Additional Image (1000x1000):</label>\n' +
                '                            <input required type="file" class="form-control" name="images['+index+'][square]" placeholder="Upload Image">\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '                <div class="row">\n' +
                '                    <div class="col-md-6">\n' +
                '                        <div class="form-group">\n' +
                '                            <label>Image Caption EN:</label>\n' +
                '                            <input type="text" class="form-control" placeholder="Image Caption EN" name="captions['+index+'][EN]">\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                    <div class="col-md-6">\n' +
                '                        <div class="form-group">\n' +
                '                            <label>Image Caption AR:</label>\n' +
                '                            <input type="text" class="form-control" placeholder="Image Caption AR" name="captions['+index+'][AR]">\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '            </div>';

            $('#file-uploads').append(el);


            removeBoxBtEvent();
        });

        function removeBoxBtEvent(){
            $('.remove-box').on('click',function(){
                $(this).closest('.file-upload').remove();
            });
        }

        $(document).ready(function(){
            removeBoxBtEvent();
        });

    </script>
@endsection
