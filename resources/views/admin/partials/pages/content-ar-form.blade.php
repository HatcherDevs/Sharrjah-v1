<h4 class="card-title">Arabic</h4>
<div class="form-group">
    <label for="exampleInputNamea1">Title</label>
    @if (request()->is('*/web-pages/*/edit'))
        <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Name" name="name_ar" required value="{{ isset($page) ? $page->name_ar : '' }}" disabled>
    @else
        <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Name" name="name_ar" required value="{{ isset($page) ? $page->name_ar : '' }}" >
    @endif
</div>
<div class="form-group">
    <label for="exampleInputEmaila3">Content</label>
    <input type="hidden" name="content_ar" value="{{ isset($page) ? $page->content_ar : '' }}"/>
    <div class="summernote">
        {!!  isset($page) ? $page->content_ar : '' !!}
    </div>
</div>