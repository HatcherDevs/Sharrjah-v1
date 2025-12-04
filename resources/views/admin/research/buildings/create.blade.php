@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Add Research Building</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/research/buildings') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><h4 class="card-title">English</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Title</label>
                                    <input required type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title" value="{{ isset($page) ? $page->title : '' }}">
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
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Lat</label>
                                    <input required type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="lat" value="{{ isset($page) ? $page->title : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Long</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="lng" value="{{ isset($page) ? $page->title_ar : '' }}">
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
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="file-upload card-box">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>(1000x700):</label>
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
                                    <strong>Year</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" name="year">
                                                <option value="pre-1960">Pre-1960</option>
                                                <option value="1960-1980">1960-1980</option>
                                                <option value="1981-2000">1981-2000</option>
                                                <option value="2001-2020">2001-2020</option>
                                                <option value="post-2020">Post-2020</option>
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
                                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
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
