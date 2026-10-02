@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Landing Page Media</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/home/landing/update') }}" method="post"
                enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Title</label>
                                    <input type="text" class="form-control" placeholder="Title" name="title"
                                        value="{{ $data->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Title Arabic</label>
                                    <input type="text" class="form-control" placeholder="Title" name="title_ar"
                                        value="{{ $data->title_ar }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Replace Image/Video<br /><br />
                                        @if ($data->uploads()->first())
                                            {{ $data->uploads()->first()->original_name }}
                                        @else
                                            <em style="color: #999;">No file uploaded yet</em>
                                        @endif
                                    </label>
                                    <input type="file" class="form-control" name="images[]" placeholder="Upload Image">
                                </div>
                                <div class="form-group">
                                    <label for="display_on">Display Background On</label>
                                    <select class="form-control" id="display_on" name="display_on">
                                        <option value="both"
                                            {{ ($data->display_on ?? 'both') == 'both' ? 'selected' : '' }}>Mobile and
                                            Desktop</option>
                                        <option value="mobile" {{ $data->display_on == 'mobile' ? 'selected' : '' }}>Mobile
                                            only</option>
                                        <option value="desktop" {{ $data->display_on == 'desktop' ? 'selected' : '' }}>
                                            Desktop only</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Background Color for Windows</label>
                                    <input type="text" class="form-control" name="background_windows"
                                        placeholder="#000000" value="{{ $data->background_windows }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Background Color for MacOs</label>
                                    <input type="text" class="form-control" name="background_macos" placeholder="#000000"
                                        value="{{ $data->background_macos }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Link</label>
                                    <input type="text" class="form-control" name="link"
                                        placeholder="http://sharjaharchitecture.org/" value="{{ $data->link }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Enable Black Logos</label>
                                    <select class="form-control" name="white_logos">
                                        <option {{ $data->white_logos == 0 ? 'selected' : '' }} value="0">No</option>
                                        <option {{ $data->white_logos == 1 ? 'selected' : '' }} value="1">Yes</option>
                                    </select>
                                </div>
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
