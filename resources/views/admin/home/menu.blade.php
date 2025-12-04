@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <form class="forms-sample" action="{{ url('admin/home/menu') }}" method="post">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Main Menu 1</label>
                                    <select class="form-control" name="main-menu-1">
                                        @foreach($pages as $page)
                                            @if($data['main-menu-1'] == $page->id)
                                                <option selected="selected" value="{{$page->id}}">{{$page->name}}</option>
                                            @else
                                                <option value="{{$page->id}}">{{$page->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Main Menu 2</label>
                                    <select class="form-control" name="main-menu-2">
                                        @foreach($pages as $page)
                                            @if($data['main-menu-2'] == $page->id)
                                                <option selected="selected" value="{{$page->id}}">{{$page->name}}</option>
                                            @else
                                                <option value="{{$page->id}}">{{$page->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Main Menu 3</label>
                                    <select class="form-control" name="main-menu-3">
                                        @foreach($pages as $page)
                                            @if($data['main-menu-3'] == $page->id)
                                                <option selected="selected" value="{{$page->id}}">{{$page->name}}</option>
                                            @else
                                                <option value="{{$page->id}}">{{$page->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Main Menu 4</label>
                                    <select class="form-control" name="main-menu-4">
                                        @foreach($pages as $page)
                                            @if($data['main-menu-4'] == $page->id)
                                                <option selected="selected" value="{{$page->id}}">{{$page->name}}</option>
                                            @else
                                                <option value="{{$page->id}}">{{$page->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Main Menu 5</label>
                                    <select class="form-control" name="main-menu-5">
                                        @foreach($pages as $page)
                                            @if($data['main-menu-5'] == $page->id)
                                                <option selected="selected" value="{{$page->id}}">{{$page->name}}</option>
                                            @else
                                                <option value="{{$page->id}}">{{$page->name}}</option>
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