
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body"><h4 class="card-title">English</h4>
                <div class="form-group">
                    <label for="exampleInputName1">Title</label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="form[title]" required value="{{ isset($form) ? $form->title : '' }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Description</label>
                    <input type="hidden" name="form[description]" value="{{ isset($form) ? $form->description : '' }}"/>
                    <div class="summernote">
                        {!! isset($form) ? $form->description : '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body"><h4 class="card-title">Arabic</h4>
                <div class="form-group">
                    <label for="exampleInputNamea1">Title</label>
                    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Name" name="form[title_ar]" required value="{{ isset($form) ? $form->title_ar : '' }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmaila3">Description</label>
                    <input type="hidden" name="form[description_ar]" value="{{ isset($form) ? $form->description_ar : '' }}"/>
                    <div class="summernote">
                        {!!  isset($form) ? $form->description_ar : '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>