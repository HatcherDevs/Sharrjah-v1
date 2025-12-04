@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Contributor</h3>
                        </div>
                    </div>
                </div>
            </div>
            <form class="forms-sample" action="{{ url('admin/update/contributors') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <input type="hidden" value="{{ $page->id  }}" name="id">

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.posts.content-en-form')
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Assign to:</label>
                                    <select class="form-control" name="contributor[letter]">
                                        @foreach($letters['en'] as $letter)
                                            @if($page->contributor->letter == $letter)
                                                <option selected="selected" value="{{$letter}}">{{$letter}}</option>
                                            @else
                                                <option value="{{$letter}}">{{$letter}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.posts.content-ar-form')
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Assign to:</label>
                                    <select class="form-control" name="contributor[letter_ar]">
                                        @foreach($letters['ar'] as $letter)
                                            @if($page->contributor->letter_ar == $letter)
                                                <option selected="selected" value="{{$letter}}">{{$letter}}</option>
                                            @else
                                                <option value="{{$letter}}">{{$letter}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.pages.featured-images-list')
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