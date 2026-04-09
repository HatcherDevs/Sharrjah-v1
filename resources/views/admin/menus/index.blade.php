@extends('admin.partials.master')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h3>{{ $pageTitle ?? 'Desktop Menus' }}</h3>
                            <div class="d-flex align-items-center" style="gap: 8px;">
                                <a href="{{ $exportRoute ?? route('admin.menus.export') }}" class="btn btn-outline-primary">
                                    Export JSON
                                </a>
                                <a href="{{ $createRoute ?? route('admin.menus.create') }}" class="btn btn-success">Create
                                    Menu
                                    Column</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->has('import_file'))
                <div class="alert alert-danger">{{ $errors->first('import_file') }}</div>
            @endif

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Import Menus (JSON)</h5>
                            <form action="{{ $importRoute ?? route('admin.menus.import') }}" method="POST"
                                enctype="multipart/form-data" class="row">
                                @csrf
                                <div class="col-md-6 mb-2">
                                    <input type="file" name="import_file" accept="application/json,.json"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-2 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="replace_existing"
                                            value="1" id="replace_existing">
                                        <label class="form-check-label" for="replace_existing">
                                            Replace existing menus
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2 text-right">
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Title EN</th>
                                            <th>Title AR</th>
                                            <th>Href</th>
                                            <th>Order</th>
                                            <th>Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-menus">
                                        @forelse ($menus as $menu)
                                            <tr data-id="{{ $menu->id }}">
                                                <td class="handle" style="cursor: move;">☰ {{ $menu->id }}</td>
                                                <td>{{ $menu->name }}</td>
                                                <td>{{ $menu->title_en }}</td>
                                                <td>{{ $menu->title_ar }}</td>
                                                <td>{{ $menu->href }}</td>
                                                <td>{{ $menu->order }}</td>
                                                <td>{{ $menu->active ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <a href="{{ route($editRouteName ?? 'admin.menus.edit', ['menu' => $menu->id]) }}"
                                                        class="btn btn-sm btn-info">Edit</a>
                                                    <a href="{{ route($deleteRouteName ?? 'admin.menus.delete', ['menu' => $menu->id]) }}"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this menu column?')">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">No menu columns found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('sortable-menus');
            var reorderUrl = "{{ url('/admin/menus/order') }}";

            if (el) {
                Sortable.create(el, {
                    handle: '.handle',
                    animation: 150,
                    onEnd: function() {
                        let order = [];
                        el.querySelectorAll('tr').forEach(function(row) {
                            order.push(row.getAttribute('data-id'));
                        });

                        fetch(reorderUrl, {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    order: order
                                })
                            }).then(response => {
                                if (response.redirected) {
                                    throw new Error('Request redirected to ' + response.url);
                                }

                                if (!response.ok) {
                                    throw new Error('HTTP ' + response.status);
                                }

                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    console.log('Order updated');
                                } else {
                                    alert('Order update failed!');
                                }
                            }).catch(error => {
                                console.error('Error:', error);
                                alert('Something went wrong saving the order.');
                            });
                    }
                });
            }
        });
    </script>
@endsection
