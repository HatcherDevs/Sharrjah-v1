@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Create Landing Page Media</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/home/landing/create') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Title</label>
                                    <input type="text" class="form-control" placeholder="Title" name="title">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Title Arabic</label>
                                    <input type="text" class="form-control" placeholder="Title" name="title_ar">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Image/Video</label>
                                    <input type="file" class="form-control" name="images[]" placeholder="Upload Image">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Background Color for Windows</label>
                                    <input type="text" class="form-control" name="background_windows" placeholder="#cccccc">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Background Color for MacOs</label>
                                    <input type="text" class="form-control" name="background_macos" placeholder="#cccccc">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Link</label>
                                    <input type="text" class="form-control" name="link" placeholder="http://sharjaharchitecture.org/">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextareaa1">Enable Black Logos</label>
                                    <select class="form-control" name="white_logos">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
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