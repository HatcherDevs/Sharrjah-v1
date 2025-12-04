@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Buildings</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    @foreach($data as $row)
                                        @if(count($row->buildings)>0)
                                            <tr>
                                                <td colspan="3"><h5>{{$row->title}}</h5></td>
                                            </tr>
                                            @foreach($row->buildings as $item)
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp; {{ $item->title }}</td>
                                                    <td>{{ $item->title_ar }}</td>
                                                    <td><a href="{{ URL('admin/research/buildings/edit/'.$item->id) }}">Edit</a>
                                                        |
                                                        <a href="{{ URL('admin/research/buildings/delete/'.$item->id) }}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
                                                </tr>
                                            @endforeach
                                        @endif
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