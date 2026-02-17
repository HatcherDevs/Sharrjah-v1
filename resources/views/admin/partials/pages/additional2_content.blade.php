<div id="additional2_content">


    @php
        $additional2_content_en = isset($page) ? json_decode($page->additional2_content_en) : null;
        $additional2_content_ar = isset($page) ? json_decode($page->additional2_content_ar) : null;
        $currentImgs = isset($page) ? json_decode($page->additional2_content_img) : null;
    @endphp

    @if ($additional2_content_en)
        @foreach ($additional2_content_en as $i => $value)
            <div id="additional2_content_empty" class="row">
                <div class="col-12">
                    <button class="del_box btn btn-danger position-absolute" type="button"
                        style="z-index: 100;right: 10px;">X</button>

                    <div class="card" style="border-top: 3px solid #ccc;padding-top: 20px;">
                        <div class="card-body ">
                            <div class="position-relative bg-dark d-inline" width="150px">

                                @if ($currentImgs[$i] != null)
                                    <img id="imo{{ $i }}" src="{{ url('public/' . $currentImgs[$i]) }}"
                                        width="150px">
                                    <button value="imo{{ $i }}" id="re-disabled{{ $i }}"
                                        class="del_img btn btn-danger position-absolute" type="button"
                                        style="z-index: 100;right: 0px;">X</button>
                                @endif
                            </div>

                            <input name="additional2_content_img[]" id="imo{{ $i }}"
                                value="{{ $currentImgs[$i] }}" type="hidden" class="form-control">
                            <input name="additional2_content_img[]" id="re-disabled{{ $i }}"
                                @if ($currentImgs[$i] != null) disabled @endif type="file" class="form-control">
                        </div>
                    </div>
                </div>
                <!--- Start additional2_content EN ---->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">

                                <label for="exampleTextareaa1">Additional Content (EN)</label>
                                <div class="form-group">
                                    <input type="hidden" name="additional2_content_en[]"
                                        value="{{ $additional2_content_en[$i] }}">
                                    <div class="summernote">
                                        {!! $additional2_content_en[$i] !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--- End additional2_content EN ---->

                <!--- Start additional2_content AR---->
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">

                                <label for="exampleTextareaa1">Additional Content (AR)</label>
                                <div class="form-group">
                                    <input type="hidden" name="additional2_content_ar[]"
                                        value="{{ $additional2_content_ar[$i] }}">
                                    <div class="summernote">
                                        {!! $additional2_content_ar[$i] !!}
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!--- End additional2_content AR---->
            </div>
        @endforeach
    @endif




    <!--- Start Additional Empty Content ---->


    <!--- End Additional Empty Content ---->
    <div id="xyz" class="w-100">
        <div class="card" style="border-top: 3px solid #ccc;">
            <div class="card-body">
                <button type="button" class="addAdditionalContent btn btn-primary">Add Additional Content</button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    (function($) {
        $.fn.pim = function() {
            $(this).on('click', '>', function(event) {
                var i = document.querySelectorAll('#additional2_content_empty').length;
                var $target = $(event.target);

                if ($target.hasClass('addAdditionalContent')) {
                    $(`#xyz`).before(`<div id="additional2_content_empty" class="row">
                        <div class="col-12">
                            <button class="del_box btn btn-danger position-absolute" type="button" style="z-index: 100;right: 10px;">X</button>

                            <div class="card" style="border-top: 3px solid #ccc;padding-top: 20px;">
                                <div class="card-body">
                                    <input name="additional2_content_img[]" type="file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!--- Start additional2_content EN ---->
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">

                                        <label for="exampleTextareaa1">Additional Content (EN)</label>
                                        <div class="form-group">
                                            <textarea class="summernote" type="text" name="additional2_content_en[]" >
                                            </textarea>                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--- End additional2_content EN ---->

                        <!--- Start additional2_content AR---->
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">

                                        <label for="exampleTextareaa1">Additional Content (AR)</label>
                                        <div class="form-group">
                                            <textarea class="summernote" type="text" name="additional2_content_ar[]" >
                                            </textarea>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--- End additional2_content AR---->
                    </div>`);

                }
            });

        }
    })(jQuery);
    $("#additional2_content").pim();
    (function() {
        document.addEventListener('click', function(event) {
            var $target = $(event.target);
            if ($target.hasClass('del_box')) {
                $target.parents('#additional2_content_empty').html('')
            }
        })
    })();


    document.addEventListener('click', function(event) {
        if (Array.from(event.target.classList).includes('del_img')) {
            document.querySelectorAll(`#${event.target.value}`).forEach(element => {
                element.remove()
                event.target.remove()
                document.querySelector(`#${event.target.id}`).removeAttribute("disabled")
            });
        }
        // parents('#additional2_content_empty').html('')
    })
</script>
