@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Add Press Kit</h3>
                        </div>
                    </div>
                </div>
            </div>
            <form class="forms-sample" action="{{ url('admin/presskits') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                @include('admin.presskits.form')
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('public/admin/js/file-upload-presskit.js') }}"></script>
@endsection