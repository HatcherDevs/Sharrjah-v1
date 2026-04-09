@extends('admin.partials.master')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Create {{ $pageTitle ?? 'Desktop Menus' }} Column</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ $storeRoute ?? route('admin.menus.store') }}" method="post" class="forms-sample">
                @csrf
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Title EN</label>
                                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Title AR</label>
                                    <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Href</label>
                                    <input type="text" name="href" class="form-control"
                                        value="{{ old('href', '#') }}">
                                </div>
                                <div class="form-group">
                                    <label>Order</label>
                                    <input type="number" min="0" name="order" class="form-control"
                                        value="{{ old('order', 0) }}">
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" name="active" value="1" class="form-check-input" checked>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success mr-2">Save</button>
                                <a href="{{ $indexRoute ?? route('admin.menus.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
