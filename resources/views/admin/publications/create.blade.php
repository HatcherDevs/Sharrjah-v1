@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Add {{ $page_name }} {{ $page_name == 'Calendar' ? "Event" : '' }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/publications') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">English</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title" value="{{ isset($page) ? $page->title : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Author</label>
                                    <input type="text" class="form-control" placeholder="Author" name="author" value="{{ isset($page) ? $page->author : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Publication</label>
                                    <input type="text" class="form-control" placeholder="Publication" name="publication" value="{{ isset($page) ? $page->publication : '' }}">
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
                                <div class="form-group">
                                    <label>Author</label>
                                    <input type="text" class="form-control" placeholder="Author" name="author_ar" value="{{ isset($page) ? $page->author_ar : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Publication</label>
                                    <input type="text" class="form-control" placeholder="Publication" name="publication_ar" value="{{ isset($page) ? $page->publication_ar : '' }}">
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
                                @include('admin.partials.pages.button-link')
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.pages.featured-image-form')
                                @include('admin.partials.pages.additional-content-form')
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
    <script src="{{ asset('public/admin/js/file-upload.js') }}"></script>
@endsection
