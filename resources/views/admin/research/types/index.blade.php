@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Types</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Types</h4>
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <tr>
                                        <th onclick="sortTable(0)">Title</th>
                                        <th onclick="sortTable(1)">Title Arabic</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->title_ar }}</td>
                                            <td><a href="{{ URL('admin/research/types/edit/'.$item->id) }}">Edit</a>
                                                |
                                                <a href="{{ URL('admin/research/types/delete/'.$item->id) }}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
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