<h4 class="card-title">Arabic</h4>
<div class="form-group">
    <label for="exampleInputNamea1">Title</label>
    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title_ar"
        value="{{ isset($page) ? $page->title_ar : '' }}">
</div>
<div class="form-group">
    <label>Description</label>
    <input type="text" class="form-control" placeholder="External link" name="description_ar"
        value="{{ isset($page) ? $page->description_ar : '' }}">
</div>

<div class="form-group">
    <label>Type</label>
    <?php
    $types = [['value' => 'page', 'name' => 'Page'], ['value' => 'url', 'name' => 'Link to external page'], ['value' => 'file', 'name' => 'Links to file'], ['value' => 'blank', 'name' => 'No link']];
    
    if (isset($pageType['ar']) && isset($pageType['ar']['type']) && isset($pageType['ar']['value']) && $pageType['ar']['type'] == 'url' && $pageType['ar']['value']->url == '#') {
        $pageType['ar']['type'] = 'blank';
    }
    ?>

    <select class="form-control type_select" name="external[ar][type]" data-lang="en">
        @foreach ($types as $type)
            <option value="{{ $type['value'] }}"
                {{ isset($pageType['ar']['type']) && $pageType['ar']['type'] == $type['value'] ? 'selected=selected' : '' }}>
                {{ $type['name'] }}</option>
        @endforeach
    </select>
</div>
<div class="form-group type-box url"
    style="{{ isset($pageType['ar']['type']) && $pageType['ar']['type'] == 'url' && isset($pageType['ar']['value']) && $pageType['ar']['value']->url != '#' ? 'display:block' : '' }}">
    <div class="hidden link">
        <label>Page URL:</label>
        <input type="text" class="form-control" placeholder="External link" name="external[ar][value]"
            value="{{ isset($pageType['ar']['type']) && $pageType['ar']['type'] == 'url' && isset($pageType['ar']['value']) ? $pageType['ar']['value']->url : '' }}">
    </div>
</div>


<div class="form-group type-box file"
    style="{{ isset($pageType['ar']['type']) && $pageType['ar']['type'] == 'file' ? 'display:block' : '' }}">
    <div class="hidden link">
        <label>
            Upload file:
            @if (isset($pageType['ar']['type']) && $pageType['ar']['type'] == 'file')
                <a
                    href="{{ url('public/' . $pageType['ar']['value']->path . '/' . $pageType['ar']['value']->file_name) }} ">{{ $pageType['ar']['value']->original_name }}</a>
            @endif
        </label>
        <input type="file" class="form-control" placeholder="External link" name="external_file_ar">
    </div>
</div>

<div class="form-group content">
    <label for="exampleInputEmail3">Content</label>
    <input type="hidden" name="content_ar" value="{{ isset($page) ? $page->content_ar : '' }}" />
    <div class="summernote">
        {!! isset($page) ? $page->content_ar : '' !!}
    </div>
</div>
