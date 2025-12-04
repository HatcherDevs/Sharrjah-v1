<h4 class="card-title">English</h4>
<div class="form-group">
    <label for="exampleInputName1">Title</label>
    @if (request()->is('*/web-pages/*/edit'))
        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name" required value="{{ isset($page) ? $page->name : '' }}" disabled>
    @else
        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name" required value="{{ isset($page) ? $page->name : '' }}" >
    @endif
</div>
<div class="form-group">
    <label for="exampleInputEmail3">Content</label>
    <input type="hidden" name="content" value="{{ isset($page) ? $page->content : '' }}"/>
    <div class="summernote">
        {!! isset($page) ? $page->content : '' !!}
    </div>
</div>