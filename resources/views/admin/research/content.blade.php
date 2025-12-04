@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Research Main Content</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/research/contents') }}" method="post"
                enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                @foreach ($contents as $page)
                    @if (
                        $page->slug != 'map-page-title' &&
                            $page->slug != 'show-arabic' &&
                            $page->slug != 'svg-logo' &&
                            $page->slug != 'popup' &&
                            $page->slug != 'repo-rows' &&
                            $page->slug != 'popupcontent' &&
                            $page->slug != 'intro' &&
                            $page->slug != 'pre-1960' &&
                            $page->slug != '1960-1980' &&
                            $page->slug != '1981-2000' &&
                            $page->slug != '2001-2020' &&
                            $page->slug != 'post-2020')
                        <div class="row">
                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        @if ($page->slug == 'tab-1')
                                            <h2 class="card-title"><b>Repository Popup Content</b></h2>
                                        @elseif ($page->slug == 'tab-2')
                                            <h2 class="card-title"><b>Bulletin Page Content – Opt 1</b></h2>
                                        @elseif ($page->slug == 'tab-3')
                                            <h2 class="card-title"><b>Bulletin Page Content – Opt 2</b></h2>
                                        @elseif ($page->slug == 'tab-4')
                                            <h2 class="card-title"><b>Acknowledgments Page Content</b></h2>
                                        @else
                                            <h2 class="card-title"><b>{{ $page->slug }} content (English)</b></h2>
                                        @endif

                                        <div class="form-group">
                                            <label for="exampleInputNamea1">Title</label>
                                            <input required type="text" class="form-control" id="exampleInputNamea1"
                                                placeholder="Title" name="data[{{ $page->id }}][title]"
                                                value="{{ isset($page) ? $page->title : '' }}">
                                        </div>


                                        <div class="form-group content">
                                            <label for="exampleInputEmail3">Content</label>
                                            {{-- <input type="hidden" name="data[{{$page->id}}][content]" value="{{ isset($page) ? $page->content : '' }}" />
                                <div class="summernote">
                                    {!! isset($page) ? $page->content : '' !!}
                                </div> --}}
                                            <textarea name="data[{{ $page->id }}][content]" id="editor">{!! isset($page) ? $page->content : '' !!}</textarea>
                                        </div>
                                        @if ($page->slug == 'tab-1')
                                            <h2 class="card-title"><b> Visibility popup</b></h2>


                                            <div class="form-group">
                                                <select class="form-control"
                                                    name="data[{{ $page->id }}][content_ar_two]">
                                                    <option value="1" {{ $page->content_ar_two ? 'selected' : '' }}>
                                                        Hidden</option>
                                                    <option value="0" {{ !$page->content_ar_two ? 'selected' : '' }}>
                                                        Visible</option>
                                                </select>
                                            </div>
                                        @endif
                                        @if (
                                            $page->slug == 'tab-1' ||
                                                $page->slug == 'tab-2' ||
                                                $page->slug == 'tab-3' ||
                                                $page->slug == 'tab-4' ||
                                                $page->slug == 'popup')
                                            <h2 class="card-title"><b> Visibility Status</b></h2>


                                            <div class="form-group">
                                                <select class="form-control" name="data[{{ $page->id }}][is_hidden]">
                                                    <option value="1" {{ $page->is_hidden ? 'selected' : '' }}>Hidden
                                                    </option>
                                                    <option value="0" {{ !$page->is_hidden ? 'selected' : '' }}>
                                                        Visible
                                                    </option>
                                                </select>
                                            </div>
                                        @endif

                                        @if (
                                            $page->slug == 'intro' ||
                                                $page->slug == 'tab-1' ||
                                                $page->slug == 'tab-2' ||
                                                $page->slug == 'tab-3' ||
                                                $page->slug == 'tab-4')
                                            <h2 class="card-title"><b>Background Color:</b></h2>
                                            <input type="color" name="data[{{ $page->id }}][background]"
                                                value="{{ isset($page) ? $page->background : '' }}">
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                        @endif

                                        @if (
                                            $page->slug == 'tab-1' ||
                                                $page->slug == 'tab-2' ||
                                                $page->slug == 'tab-3' ||
                                                $page->slug == 'tab-4' ||
                                                $page->slug == 'svg-logo')
                                            @if (count($page->images))
                                                <strong>Images</strong>
                                                <br />
                                                <br />
                                                <div class="row">
                                                    @foreach ($page->images as $image)
                                                        <div class="col-md-3">
                                                            <img src="{{ asset('public/' . $image->image) }}"
                                                                width="100%">
                                                            <a
                                                                href="{{ url('admin/research/contents/delete-image/' . $image->id) }}">Remove</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <br />
                                            @endif
                                            <br>
                                            <h2 class="card-title"><b>Upload image (1000x700):</b></h2>
                                            <input type="file" class="form-control"
                                                name="data[{{ $page->id }}][gallery][]" placeholder="Upload Image"
                                                multiple>
                                            <br> <br>
                                            <br> <br>
                                        @endif
                                        @if ($page->slug == 'popup')
                                            @if (count($page->images))
                                                <strong>Images</strong>
                                                <br />
                                                <br />
                                                <div class="row">
                                                    @foreach ($page->images as $image)
                                                        <div class="col-md-3">
                                                            <img src="{{ asset('public/' . $image->image) }}"
                                                                width="100%">
                                                            <a
                                                                href="{{ url('admin/research/contents/delete-image/' . $image->id) }}">Remove</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <br />
                                                <br />
                                                <br />
                                            @endif
                                            <h2 class="card-title"><b>Upload background image :</b></h2>
                                            <input type="file" class="form-control"
                                                name="data[{{ $page->id }}][norm][]" placeholder="Upload Image"
                                                multiple>
                                        @endif



                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        @if ($page->slug == 'tab-1')
                                            <h2 class="card-title"><b>Repository Popup Content </b></h2>
                                        @elseif ($page->slug == 'tab-2')
                                            <h2 class="card-title"><b>Bulletin Page Content – Opt 1 </b></h2>
                                        @elseif ($page->slug == 'tab-3')
                                            <h2 class="card-title"><b>Bulletin Page Content – Opt 2 </b></h2>
                                        @elseif ($page->slug == 'tab-4')
                                            <h2 class="card-title"><b>Acknowledgments Page Content </b></h2>
                                        @else
                                            <h2 class="card-title"><b>{{ $page->slug }} content (Arabic)</b></h2>
                                        @endif

                                        <div class="form-group">
                                            <label for="exampleInputNamea1">Title</label>
                                            <input type="text" class="form-control" id="exampleInputNamea1"
                                                placeholder="Title" name="data[{{ $page->id }}][title_ar]"
                                                value="{{ isset($page) ? $page->title_ar : '' }}">
                                        </div>
                                        <div class="form-group content">
                                            <label for="exampleInputEmail3">Content</label>
                                            {{-- <input type="hidden" name="data[{{$page->id}}][content_ar]" value="{{ isset($page) ? $page->content_ar : '' }}" />
                                <div class="summernote">
                                    {!! isset($page) ? $page->content_ar : '' !!}
                                </div> --}}
                                            <textarea name="data[{{ $page->id }}][content_ar]" id="editor">{!! isset($page) ? $page->content_ar : '' !!}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @if ($page->slug == 'popup')
                            <div class="row">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>Research Popup Content </b></h2>
                                            <div class="form-group">
                                                <label for="exampleInputNamea1">Title</label>
                                                <input required type="text" class="form-control" id="exampleInputNamea1"
                                                    placeholder="Title" name="data[{{ $page->id }}][title]"
                                                    value="{{ isset($page) ? $page->title : '' }}">
                                            </div>

                                            <div class="form-group">
                                                <h2 class="card-title"><b>Visibility :</b></h2>
                                                <select class="form-control" name="data[{{ $page->id }}][is_hidden]">
                                                    <option value="1" {{ $page->is_hidden ? 'selected' : '' }}>Hidden
                                                    </option>
                                                    <option value="0" {{ !$page->is_hidden ? 'selected' : '' }}>
                                                        Visible</option>
                                                </select>
                                                <br>
                                                <br>
                                                <br>
                                                <div class="row">
                                                    @foreach ($page->images as $image)
                                                        <div class="col-md-3">
                                                            <img src="{{ asset('public/' . $image->image) }}"
                                                                width="100%">
                                                            <a
                                                                href="{{ url('admin/research/contents/delete-image/' . $image->id) }}">Remove</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <br />


                                                <br>
                                                <h2 class="card-title"><b>Upload Background Color</b></h2>
                                                <input type="file" class="form-control"
                                                    name="data[{{ $page->id }}][norm][]" placeholder="Upload Image"
                                                    multiple>
                                                <br> <br>
                                                <br>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($page->slug == 'intro')
                            <div class="row">
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>{{ $page->slug }} content </b></h2>
                                            <div class="form-group">
                                                <label for="exampleInputNamea1">Title</label>
                                                <input required type="text" class="form-control"
                                                    id="exampleInputNamea1" placeholder="Title"
                                                    name="data[{{ $page->id }}][title]"
                                                    value="{{ isset($page) ? $page->title : '' }}">
                                            </div>



                                            <div class="form-group content">
                                                <label for="exampleInputEmail3">Intro Content English (Left)</label>
                                                {{-- <input type="hidden" name="data[{{$page->id}}][content]" value="{{ isset($page) ? $page->content : '' }}" />
                                <div class="summernote">
                                    {!! isset($page) ? $page->content : '' !!}
                                </div> --}}
                                                <textarea name="data[{{ $page->id }}][content]" id="editor">{!! isset($page) ? $page->content : '' !!}</textarea>
                                            </div>
                                            <div class="form-group content">
                                                <label for="exampleInputEmail3">Intro Content English (Right) </label>
                                                {{-- <input type="hidden" name="data[{{$page->id}}][content_two]" value="{{ isset($page) ? $page->content_two : '' }}" />
                                <div class="summernote">
                                    {!! isset($page) ? $page->content_two : '' !!}
                                </div> --}}
                                                <textarea name="data[{{ $page->id }}][content_two]" id="editor">{!! isset($page) ? $page->content_two : '' !!}</textarea>
                                            </div>

                                            @if (
                                                $page->slug == 'tab-1' ||
                                                    $page->slug == 'tab-2' ||
                                                    $page->slug == 'tab-3' ||
                                                    $page->slug == 'tab-4' ||
                                                    $page->slug == 'popup')
                                                <h2 class="card-title"><b>{{ $page->slug }} Visibility</b></h2>

                                                <div class="form-group">
                                                    <select class="form-control"
                                                        name="data[{{ $page->id }}][is_hidden]">
                                                        <option value="1" {{ $page->is_hidden ? 'selected' : '' }}>
                                                            Hidden</option>
                                                        <option value="0" {{ !$page->is_hidden ? 'selected' : '' }}>
                                                            Visible</option>
                                                    </select>
                                                </div>
                                            @endif

                                            @if (
                                                $page->slug == 'intro' ||
                                                    $page->slug == 'tab-1' ||
                                                    $page->slug == 'tab-2' ||
                                                    $page->slug == 'tab-3' ||
                                                    $page->slug == 'tab-4')
                                                <h2 class="card-title"><b>Background Color:</b></h2>
                                                <input type="color" name="data[{{ $page->id }}][background]"
                                                    value="{{ isset($page) ? $page->background : '' }}">

                                                <br>
                                                <br>
                                                <br>
                                            @endif

                                            @if (
                                                $page->slug == 'tab-1' ||
                                                    $page->slug == 'tab-2' ||
                                                    $page->slug == 'tab-3' ||
                                                    $page->slug == 'tab-4' ||
                                                    $page->slug == 'svg-logo')
                                                @if (count($page->images))
                                                    <strong>Images</strong>
                                                    <br />
                                                    <br />
                                                    <div class="row">
                                                        @foreach ($page->images as $image)
                                                            <div class="col-md-3">
                                                                <img src="{{ asset('public/' . $image->image) }}"
                                                                    width="100%">
                                                                <a
                                                                    href="{{ url('admin/research/contents/delete-image/' . $image->id) }}">Remove</a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <br />
                                                @endif
                                                <br>
                                                <h2 class="card-title"><b>Upload image (1000x700):</b></h2>
                                                <input type="file" class="form-control"
                                                    name="data[{{ $page->id }}][gallery][]"
                                                    placeholder="Upload Image" multiple>
                                                <br> <br>
                                            @endif
                                            @if ($page->slug == 'popup')
                                                @if (count($page->images))
                                                    <strong>Images</strong>
                                                    <br />
                                                    <br />
                                                    <div class="row">
                                                        @foreach ($page->images as $image)
                                                            <div class="col-md-3">
                                                                <img src="{{ asset('public/' . $image->image) }}"
                                                                    width="100%">
                                                                <a
                                                                    href="{{ url('admin/research/contents/delete-image/' . $image->id) }}">Remove</a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <br />
                                                    <br />
                                                    <br />
                                                @endif
                                                <h2 class="card-title"><b>Upload background image :</b></h2>
                                                <input type="file" class="form-control"
                                                    name="data[{{ $page->id }}][norm][]" placeholder="Upload Image"
                                                    multiple>
                                            @endif



                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>{{ $page->slug }} content </b></h2>
                                            <div class="form-group">
                                                <label for="exampleInputNamea1">Title</label>
                                                <input type="text" class="form-control" id="exampleInputNamea1"
                                                    placeholder="Title" name="data[{{ $page->id }}][title_ar]"
                                                    value="{{ isset($page) ? $page->title_ar : '' }}">
                                            </div>
                                            <div class="form-group content">
                                                <label for="exampleInputEmail3">Intro Content Arabic (Right)</label>
                                                {{-- <input type="hidden" name="data[{{$page->id}}][content_ar]" value="{{ isset($page) ? $page->content_ar : '' }}" />
                                <div class="summernote">
                                    {!! isset($page) ? $page->content_ar : '' !!}
                                </div> --}}
                                                <textarea name="data[{{ $page->id }}][content_ar]" id="editor">{!! isset($page) ? $page->content_ar : '' !!}</textarea>
                                            </div>
                                            <div class="form-group content">
                                                <label for="exampleInputEmail3">Intro Content Arabic (left)</label>
                                                {{-- <input type="hidden" name="data[{{$page->id}}][content_ar_two]" value="{{ isset($page) ? $page->content_ar_two : '' }}" />
                                <div class="summernote">
                                    {!! isset($page) ? $page->content_ar_two : '' !!}
                                </div> --}}
                                                <textarea name="data[{{ $page->id }}][content_ar_two]" id="editor">{!! isset($page) ? $page->content_ar_two : '' !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @if ($page->slug == 'repo-rows')
                            <div class="row">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>{{ $page->slug }}</b></h2>


                                            <div class="form-group">

                                                <p><b>items on row :</b></p>
                                                <input type="radio" id="4"
                                                    name="data[{{ $page->id }}][content]" value="4"
                                                    {{ $page->content == '4' ? 'checked' : '' }}>
                                                <label for="4">3 items on row</label><br>
                                                <input type="radio" id="3"
                                                    name="data[{{ $page->id }}][content]" value="3"
                                                    {{ $page->content == '3' ? 'checked' : '' }}>
                                                <label for="3">4 items on row</label><br>
                                                <input type="radio" id="2"
                                                    name="data[{{ $page->id }}][content]" value="2"
                                                    {{ $page->content == '2' ? 'checked' : '' }}>
                                                <label for="2">6 items on row</label><br>



                                            </div>



                                            {{-- <div class="form-group">
                                <p><b>Row Mobile :</b></p>
                                <input type="radio" id="4" name="data[{{$page->id}}][content_ar]" value="4"{{$page->content_ar == '4'? 'checked' : ''}}>
                            <label for="4">3</label><br>
                            <input type="radio" id="3" name="data[{{$page->id}}][content_ar]" value="3" {{$page->content_ar =='3'? 'checked' : ''}}>
                            <label for="3">4</label><br>
                            <input type="radio" id="2" name="data[{{$page->id}}][content_ar]" value="2" {{$page->content_ar =='2'? 'checked' : ''}}>
                            <label for="2">6</label><br>




                        </div>
                        --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (
                            $page->slug == 'pre-1960' ||
                                $page->slug == '1960-1980' ||
                                $page->slug == '1981-2000' ||
                                $page->slug == '2001-2020' ||
                                $page->slug == 'post-2020')
                            <div class="row">
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>{{ $page->slug }} content (English)</b></h2>


                                            <div class="form-group">
                                                <label for="exampleInputNamea1">Title</label>
                                                <input required type="text" class="form-control"
                                                    id="exampleInputNamea1" placeholder="Title"
                                                    name="data[{{ $page->id }}][title]"
                                                    value="{{ isset($page) ? $page->title : '' }}">
                                            </div>


                                            <div class="form-group content">
                                                <label for="exampleInputEmail3">Content</label>

                                                <textarea name="data[{{ $page->id }}][content]" id="editor">{!! isset($page) ? $page->content : '' !!}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <div class="checkbox-wrapper">
                                                    <input type="hidden" name="data[{{ $page->id }}][is_hidden]" value="0"> <!-- Add this hidden input -->
                                                    <input type="checkbox" class="form-check-input checkbox-style" id="data{{ $page->id }}isHiddenCheckbox"
                                                        name="data[{{ $page->id }}][is_hidden]" value="1"
                                                        {{ isset($page) && $page->is_hidden ? 'checked' : '' }}>
                                                    <label  class="checkbox-label" for="data{{ $page->id }}isHiddenCheckbox">Hide content</label>
                                                </div>
                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">

                                            <h2 class="card-title"><b>{{ $page->slug }} content (Arabic)</b></h2>


                                            <div class="form-group">
                                                <label for="exampleInputNamea1">Title</label>
                                                <input type="text" class="form-control" id="exampleInputNamea1"
                                                    placeholder="Title" name="data[{{ $page->id }}][title_ar]"
                                                    value="{{ isset($page) ? $page->title_ar : '' }}">
                                            </div>
                                            <div class="form-group content">
                                                <label for="exampleInputEmail3">Content</label>

                                                <textarea name="data[{{ $page->id }}][content_ar]" id="editor">{!! isset($page) ? $page->content_ar : '' !!}</textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($page->slug == 'popupcontent')
                            <div class="row">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>Research Popup Visual Format </b></h2>

                                            <div class="form-group">

                                                <p>Type</p>
                                                <input type="radio" id="Image"
                                                    name="data[{{ $page->id }}][title]" value="image"
                                                    {{ $page->title == 'image' ? 'checked' : '' }}>
                                                <label for="image">Image</label><br>
                                                <input type="radio" id="video"
                                                    name="data[{{ $page->id }}][title]" value="video"
                                                    {{ $page->title == 'video' ? 'checked' : '' }}>
                                                <label for="video">Video</label><br>



                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    @foreach ($page->images as $image)
                                                        <div class="col-md-3">
                                                            <img src="{{ asset('public/' . $image->image) }}"
                                                                width="100%">
                                                            <a
                                                                href="{{ url('admin/research/contents/delete-image/' . $image->id) }}">Remove</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <h8 class="card-title"><b>Upload popup image:</b></h8>
                                                <input type="file" class="form-control"
                                                    name="data[{{ $page->id }}][norm][]" placeholder="Upload Image"
                                                    multiple>
                                            </div>
                                            <div class="form-group">

                                                <div class="form-group">
                                                    <h8 class="card-title"><b>Video url:</b></h8>
                                                    <input required type="text" class="form-control"
                                                        id="exampleInputNamea1"
                                                        placeholder="video url ex wwww.youtube.com/>ssfidbnbd23"
                                                        name="data[{{ $page->id }}][content]"
                                                        value="{{ isset($page) ? $page->content : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <h2 class="card-title"><b>Background Color:</b></h2>
                                                    <input type="color" name="data[{{ $page->id }}][background]"
                                                        value="{{ isset($page) ? $page->background : '' }}">
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($page->slug == 'show-arabic')
                            <div class="row">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>{{ $page->title }}</b></h2>
                                            <div class="form-group">
                                                <select class="form-control" name="data[{{ $page->id }}][content]">
                                                    <option value="1" {{ $page->content ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="0" {{ !$page->content ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($page->slug == 'map-page-title')
                            <div class="row">
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>Map</b></h2>
                                            <div class="form-group">
                                                <label for="exampleInputNamea1">Title</label>
                                                <input required type="text" class="form-control"
                                                    id="exampleInputNamea1" placeholder="Title"
                                                    name="data[{{ $page->id }}][title]"
                                                    value="{{ isset($page) ? $page->title : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>خريطة</b></h2>
                                            <div class="form-group">
                                                <label for="exampleInputNamea1">Title</label>
                                                <input required type="text" class="form-control"
                                                    id="exampleInputNamea1" placeholder="Title"
                                                    name="data[{{ $page->id }}][title_ar]"
                                                    value="{{ isset($page) ? $page->title_ar : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>Map Visable</b></h2>
                                            <div class="form-group">
                                                <select class="form-control" name="data[{{ $page->id }}][is_hidden]">
                                                    <option value="1" {{ $page->is_hidden ? 'selected' : '' }}>Hidden
                                                    </option>
                                                    <option value="0" {{ !$page->is_hidden ? 'selected' : '' }}>
                                                        Visible</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="card-body">
                                            <h2 class="card-title"><b>Map yollow box's</b></h2>
                                            <div class="form-group">
                                                <select class="form-control" name="data[{{ $page->id }}][background]">
                                                    <option value="0" {{ !$page->background ? 'selected' : '' }}>
                                                        Hidden
                                                    </option>
                                                    <option value="1" {{ $page->background ? 'selected' : '' }}>
                                                        Visible
                                                    </option>
                                                </select>
                                                
                                            </div>

                                        </div>
                                        <div class="card-body">
                                            <h2 class="card-title"><b>Map pop-up</b></h2>
                                            <div class="form-group">
                                                <select class="form-control" name="data[{{ $page->id }}][content_ar_two]">
                                                    <option value="0" {{ !$page->content_ar_two ? 'selected' : '' }}>
                                                        Hidden
                                                    </option>
                                                    <option value="1" {{ $page->content_ar_two ? 'selected' : '' }}>
                                                        Visible
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-6">

                                                <div class="card-body">
                                                    <h2 class="card-title"><b>English Map pop-up content </b></h2>
                                                    <div class="form-group">
                                                        <textarea name="data[{{ $page->id }}][content]" id="editor">{!! isset($page) ? $page->content : '' !!}</textarea>

                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-6">

                                                <div class="card-body">
                                                    <h2 class="card-title"><b>Arabic Map pop-up content</b></h2>
                                                    <div class="form-group">
                                                        <textarea name="data[{{ $page->id }}][content_ar]" id="editor">{!! isset($page) ? $page->content_ar : '' !!}</textarea>

                                                    </div>

                                                </div>

                                            </div>



                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($page->slug == 'svg-logo')
                            <div class="row">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="card-title"><b>Research Page SVG logo</b></h2>
                                            <div class="form-group">
                                                <h2 class="card-title"><b>Visibility</b></h2>
                                                <select class="form-control"
                                                    name="data[{{ $page->id }}][is_hidden]">
                                                    <option value="1" {{ $page->is_hidden ? 'selected' : '' }}>
                                                        Hidden
                                                    </option>
                                                    <option value="0" {{ !$page->is_hidden ? 'selected' : '' }}>
                                                        Visible</option>
                                                </select>
                                                <br>
                                                <br>
                                                <br>
                                                <div class="row">
                                                    @foreach ($page->images as $image)
                                                        <div class="col-md-3">
                                                            <img src="{{ asset('public/' . $image->image) }}"
                                                                width="100%">
                                                            <a
                                                                href="{{ url('admin/research/contents/delete-image/' . $image->id) }}">Remove</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <br />


                                                <br>
                                                <h2 class="card-title"><b>Upload SVG logo:</b></h2>
                                                <input type="file" class="form-control"
                                                    name="data[{{ $page->id }}][gif][]" placeholder="Upload Image"
                                                    multiple>
                                                <br> <br>



                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputNamea1">Hyperlink Svg</label>
                                                <input required type="text" class="form-control"
                                                    id="exampleInputNamea1" placeholder="Hyperlink"
                                                    name="data[{{ $page->id }}][content]"
                                                    value="{{ isset($page) ? $page->content : '' }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success mr-2">Submit</button>
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
        $('.summernote').summernote();
        $('#summernote').summernote();
    </script>
@endsection
