@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit collection category</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ route('stores.category.update') }}" method="post"
                enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <input type="hidden" value="{{ $category->id }}" name="id">



                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">English</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title"
                                        name="name" value="{{ isset($category) ? $category->name : '' }}">
                                </div>





                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Arabic</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">Title</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title"
                                        name="name_ar" value="{{ isset($category) ? $category->name_ar : '' }}">
                                </div>




                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">order number</h4>
                                <div class="form-group">
                                    <label for="exampleInputNamea1">order number</label>
                                    <input type="text" class="form-control" id="exampleInputNamea1"
                                        placeholder="order_number" name="order_number"
                                        value="{{ isset($category) ? $category->order_number : '' }}">
                                </div>





                            </div>
                        </div>
                    </div>


                </div>




                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#add-file').on('click', function() {
            index = $('#file-uploads .file-upload').length + 1;

            el = '\n' +
                '            <div class="file-upload card-box">\n' +
                '                <div class="row">\n' +
                '                <button class="remove-box" type="button">X</button>\n' +
                '                    <div class="col-md-12">\n' +
                '                        <div class="form-group">\n' +
                '                            <label>Additional Image (1000x1000):</label>\n' +
                '                            <input required type="file" class="form-control" name="images[' +
                index + '][square]" placeholder="Upload Image">\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '                <div class="row">\n' +
                '                    <div class="col-md-6">\n' +
                '                        <div class="form-group">\n' +
                '                            <label>Image Caption EN:</label>\n' +
                '                            <input type="text" class="form-control" placeholder="Image Caption EN" name="captions[' +
                index + '][EN]">\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                    <div class="col-md-6">\n' +
                '                        <div class="form-group">\n' +
                '                            <label>Image Caption AR:</label>\n' +
                '                            <input type="text" class="form-control" placeholder="Image Caption AR" name="captions[' +
                index + '][AR]">\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '            </div>';

            $('#file-uploads').append(el);


            removeBoxBtEvent();
        });

        function removeBoxBtEvent() {
            $('.remove-box').on('click', function() {
                $(this).closest('.file-upload').remove();
            });
        }

        $(document).ready(function() {
            removeBoxBtEvent();
        });
    </script>
@endsection
