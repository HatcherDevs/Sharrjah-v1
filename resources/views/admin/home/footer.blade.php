@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <form class="forms-sample" action="{{ url('admin/home/footer') }}" method="post">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Facebook-link</label>
                                    <input type="text" class="form-control" name="facebook-link"  value="{{ $data['facebook-link']  }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Twitter link</label>
                                    <input type="text" class="form-control" name="twitter-link"  value="{{ $data['vimeo-link']  }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Instagram link</label>
                                    <input type="text" class="form-control" name="instagram-link"  value="{{ $data['vimeo-link']  }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Vimeo link</label>
                                    <input type="text" class="form-control" name="vimeo-link"  value="{{ $data['vimeo-link']  }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Copyright Left</label>
                                    <input type="text" class="form-control" name="copyright"  value="{{ $data['copyright']  }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Copyright Right</label>
                                    <input type="text" class="form-control" name="copyright-right"  value="{{ $data['copyright-right']  }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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