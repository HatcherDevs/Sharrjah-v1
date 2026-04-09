@extends('admin.partials.master')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Item: {{ $item->title_en }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.menus.item.update', ['menu' => $menu->id, 'item' => $item->id]) }}" method="post"
                class="forms-sample">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Parent Item (optional)</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">Top Level</option>
                                        @foreach ($parentOptions as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ old('parent_id', $item->parent_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->title_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Title EN</label>
                                    <input type="text" name="title_en" class="form-control"
                                        value="{{ old('title_en', $item->title_en) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Title AR</label>
                                    <input type="text" name="title_ar" class="form-control"
                                        value="{{ old('title_ar', $item->title_ar) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Href</label>
                                    <input type="text" name="href" class="form-control"
                                        value="{{ old('href', $item->href) }}">
                                </div>
                                <div class="form-group">
                                    <label>Order</label>
                                    <input type="number" min="0" name="order" class="form-control"
                                        value="{{ old('order', $item->order) }}">
                                </div>
                                <div class="form-group form-check">
                                    <input type="hidden" name="active" value="0">
                                    <input type="checkbox" id="edit-item-active" name="active" value="1"
                                        class="form-check-input" {{ old('active', $item->active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit-item-active">Active</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="hidden" name="has_sub_items" value="0">
                                    <input type="checkbox" id="edit-item-has-sub-items" name="has_sub_items" value="1"
                                        class="form-check-input"
                                        {{ old('has_sub_items', $item->has_sub_items) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit-item-has-sub-items">Has Sub Items</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success mr-2">Update</button>
                                <a href="{{ route('admin.menus.edit', ['menu' => $menu->id]) }}"
                                    class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
