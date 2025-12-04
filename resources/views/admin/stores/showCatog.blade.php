@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Design Store: Re-store Collection</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Events</h4>
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <tr>
                                        <th onclick="sortTable(0)">Title</th>
                                        <th onclick="sortTable(1)">Title Arabic</th>
                                        <th onclick="sortTable(1)">order</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($categories as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->name_ar }}</td>
                                            <td>{{ $item->order_number }}</td>
                                            <td><a href="{{ route('stores.category.edit', ['id' => $item->id]) }}">Edit</a>
                                                |

                                                <a href="{{ route('stores.category.delete', ['id' => $item->id]) }}"
                                                    onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
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
