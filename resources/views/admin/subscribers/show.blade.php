@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Subscribers</h3>
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
                                    <tr>
                                        <th onclick="sortTable(0)">Email</th>
                                        <th onclick="sortTable(1)">First Name</th>
                                        <th onclick="sortTable(2)">Last Name</th>
                                        <th>City</th>
                                        <th>Affiliation</th>
                                        <th>Date</th>
                                    </tr>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item->EMAIL }}</td>
                                            <td>{{ $item->FNAME }}</td>
                                            <td>{{ $item->LNAME }}</td>
                                            <td>{{ $item->MMERGE5 }}</td>
                                            <td>{{ $item->MMERGE6 }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y H:m') }}</td>
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