@extends('pages.master')

@section('content')
    <div class="innerpage">
        <div class="container text-center">
            <div class="body-section contents with-img-header">
                <div class="row" dir="">
                    <div class="col-md-12 ">
                        @if($data)
                            @include('partials.form')
                        @else
                            <h1 class="alert-danger alert">Article not found.</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

