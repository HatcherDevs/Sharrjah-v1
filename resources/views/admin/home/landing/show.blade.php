@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Landing Page Media</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ URL('admin/home/create/landing/') }}">Add Element</a>
                            <br/><br/>
                            <h4 class="card-title">Posts</h4>
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <tr>
                                        <th onclick="sortTable(0)">Title</th>
                                        <th onclick="sortTable(1)">Title Arabic</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->title_ar }}</td>
                                            <td><a href="{{ URL('admin/home/landing/'.$item->id.'/edit') }}">Edit</a></td>
                                            <td><a href="{{ URL('admin/home/landing/'.$item->id.'/delete') }}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection