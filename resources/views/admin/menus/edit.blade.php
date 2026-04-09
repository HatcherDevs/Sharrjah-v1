@extends('admin.partials.master')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h3>Edit {{ $pageTitle ?? 'Desktop Menus' }} Column</h3>
                            <a href="{{ route('admin.menus.item.create', ['menu' => $menu->id]) }}"
                                class="btn btn-success">Add Menu Item</a>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route($updateRouteName ?? 'admin.menus.update', ['menu' => $menu->id]) }}" method="post"
                class="forms-sample">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $menu->name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Title EN</label>
                                    <input type="text" name="title_en" class="form-control"
                                        value="{{ old('title_en', $menu->title_en) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Title AR</label>
                                    <input type="text" name="title_ar" class="form-control"
                                        value="{{ old('title_ar', $menu->title_ar) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Href</label>
                                    <input type="text" name="href" class="form-control"
                                        value="{{ old('href', $menu->href) }}">
                                </div>
                                <div class="form-group">
                                    <label>Order</label>
                                    <input type="number" min="0" name="order" class="form-control"
                                        value="{{ old('order', $menu->order) }}">
                                </div>
                                <div class="form-group form-check">
                                    <input type="hidden" name="active" value="0">
                                    <input type="checkbox" id="menu-active" name="active" value="1"
                                        class="form-check-input" {{ old('active', $menu->active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="menu-active">Active</label>
                                </div>
                                <button type="submit" class="btn btn-success">Update Column</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4>Bulk Add Items</h4>
                            <p class="text-muted mb-3">
                                Add one item per line with this format:
                                <strong>Title EN | Title AR | Href(optional) | Order(optional)</strong>
                            </p>

                            <form action="{{ route('admin.menus.item.bulk-store', ['menu' => $menu->id]) }}"
                                method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Parent Item (optional, applied to all lines)</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">Top Level</option>
                                        @foreach ($parentOptions as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ (string) old('parent_id') === (string) $parent->id ? 'selected' : '' }}>
                                                {{ $parent->title_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Default Order (used when line has no order)</label>
                                    <input type="number" min="0" name="default_order" class="form-control"
                                        value="{{ old('default_order', 0) }}">
                                </div>

                                <div class="form-group form-check">
                                    <input type="hidden" name="active" value="0">
                                    <input type="checkbox" class="form-check-input" id="bulk-active" name="active"
                                        value="1" {{ old('active', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bulk-active">Active for all</label>
                                </div>

                                <div class="form-group form-check">
                                    <input type="hidden" name="has_sub_items" value="0">
                                    <input type="checkbox" class="form-check-input" id="bulk-has-sub-items"
                                        name="has_sub_items" value="1" {{ old('has_sub_items') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bulk-has-sub-items">Has Sub Items for all</label>
                                </div>

                                <div class="form-group">
                                    <label>Items Lines</label>
                                    <textarea name="bulk_lines" rows="7" class="form-control"
                                        placeholder="Mission | الرسالة | /pages/about/mission | 1&#10;Team | الفريق | /pages/about/team | 2">{{ old('bulk_lines') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Bulk Add Items</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4>Items</h4>
                            <p class="text-muted mb-3">
                                To create a sub item: click <strong>Add Sub Item</strong> beside any existing row, or use
                                <strong>Add Menu Item</strong> and choose a parent manually.
                            </p>
                            <form action="{{ route('admin.menus.item.bulk-delete', ['menu' => $menu->id]) }}"
                                method="post" onsubmit="return confirm('Delete selected items?');">
                                @csrf

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete Selected</button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">
                                                    <input type="checkbox" id="select-all-items">
                                                </th>
                                                <th>Title EN</th>
                                                <th>Title AR</th>
                                                <th>Href</th>
                                                <th>Parent</th>
                                                <th>Has Sub Items</th>
                                                <th>Active</th>
                                                <th>Order</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sortable-items">
                                            @forelse ($parentOptions as $item)
                                                <tr data-id="{{ $item->id }}">
                                                    <td>
                                                        <input type="checkbox" class="bulk-item-checkbox"
                                                            name="item_ids[]" value="{{ $item->id }}">
                                                    </td>
                                                    <td class="handle" style="cursor: move;">☰ {{ $item->title_en }}</td>
                                                    <td>{{ $item->title_ar }}</td>
                                                    <td>{{ $item->href }}</td>
                                                    <td>{{ optional($item->parent)->title_en ?: '-' }}</td>
                                                    <td>{{ $item->has_sub_items ? 'Yes' : 'No' }}</td>
                                                    <td>{{ $item->active ? 'Yes' : 'No' }}</td>
                                                    <td>{{ $item->order }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.menus.item.edit', ['menu' => $menu->id, 'item' => $item->id]) }}"
                                                            class="btn btn-sm btn-info">Edit</a>
                                                        <a href="{{ route('admin.menus.item.create', ['menu' => $menu->id, 'parent_id' => $item->id]) }}"
                                                            class="btn btn-sm btn-secondary">Add Sub Item</a>
                                                        <a href="{{ route('admin.menus.item.delete', ['menu' => $menu->id, 'item' => $item->id]) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this item?')">Delete</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9">No items found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </form>
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
            var el = document.getElementById('sortable-items');
            var reorderUrl = "{{ url('/admin/menus/' . $menu->id . '/items/order') }}";
            var selectAll = document.getElementById('select-all-items');

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
                                    console.log('Item order updated');
                                } else {
                                    alert('Order update failed!');
                                }
                            }).catch(error => {
                                console.error('Error:', error);
                                alert('Something went wrong saving the item order.');
                            });
                    }
                });
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    document.querySelectorAll('.bulk-item-checkbox').forEach(function(checkbox) {
                        checkbox.checked = selectAll.checked;
                    });
                });
            }
        });
    </script>
@endsection
