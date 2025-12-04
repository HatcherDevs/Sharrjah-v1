@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3>Homepage Contents</h3>
                    </div>
                </div>
            </div>
        </div>

            <form class="forms-sample" action="{{ url('admin/home/update') }}" method="post">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">Video Content</h1>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">English</label>
                                    <input type="hidden" name="headline-en"  value="{{ $data['headline-en']  }}">
                                    <div class="summernote">
                                        {!! $data['headline-en'] !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmaila3">Arabic</label>
                                    <input type="hidden" name="headline-ar"  value="{{ $data['headline-ar']  }}"/>
                                    <div class="summernote">
                                        {!! $data['headline-ar'] !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">Body Content</h1>
                                <div class="form-group no-fontsize">
                                    <label for="exampleInputEmail3">English</label>
                                    <input type="hidden" name="intro-en"  value="{{ $data['intro-en']  }}">
                                    <div class="summernote no-fontsize">
                                        {!! $data['intro-en']  !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h1 class="card-title">Font Size EN</h1>
                                            <div class="form-group">
                                                <input type="number" value="{{ $data['home-page-font-size-en']  }}" name="home-page-font-size-en">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h1 class="card-title">Line Height EN</h1>
                                            <div class="form-group">
                                                <input type="number" value="{{ $data['home-page-font-line-en']  }}" name="home-page-font-line-en">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-fontsize">
                                    <label for="exampleInputEmaila3">Arabic</label>
                                    <input type="hidden" name="intro-ar"  value="{{ $data['intro-ar']  }}"/>
                                    <div class="summernote">
                                        {!! $data['intro-ar']  !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h1 class="card-title">Font Size AR</h1>
                                            <div class="form-group">
                                                <input type="number" value="{{ $data['home-page-font-size-ar']  }}" name="home-page-font-size-ar">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h1 class="card-title">Line Height AR</h1>
                                            <div class="form-group">
                                                <input type="number" value="{{ $data['home-page-font-line-ar']  }}" name="home-page-font-line-ar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">Additional Content</h1>
                                <div class="form-group">
                                    <input type="hidden" name="additional"  value="{{ $data['additional']  }}">
                                    <div class="summernote">
                                        {!! $data['additional']  !!}
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