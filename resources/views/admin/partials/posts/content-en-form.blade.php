<h4 class="card-title">English</h4>
<div class="form-group">
    <label for="exampleInputNamea1">Title</label>
    <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Title" name="title" value="{{ isset($page) ? $page->title : '' }}">
</div>
<div class="form-group">
    <label>Description</label>
    <input type="text" class="form-control" placeholder="External link" name="description" value="{{ isset($page) ? $page->description : '' }}">
</div>

<div class="form-group">
    <label>Type</label>
    <?php
    $types = [
        ['value'=>'page','name'=>'Page'],
        ['value'=>'url','name'=>'Link to external page'],
        ['value'=>'file','name'=>'Links to file'],
        ['value'=>'blank','name'=>'No link']
    ];

    if($pageType['en']['type'] == "url" && $pageType['en']['value']->url == "#")
        $pageType['en']['type'] = "blank";
    ?>

    <select class="form-control type_select" name="external[en][type]" data-lang="en">
        @foreach($types as $type)
            <option value="{{ $type['value'] }}" {{ $pageType['en']['type'] == $type['value'] ? 'selected=selected' : ""  }}>{{ $type['name'] }}</option>
        @endforeach
    </select>
</div>
<div class="form-group type-box url" style="{{ ($pageType['en']['type'] == 'url' && $pageType['en']['value']->url != '#') ? 'display:block' : ''}}">
    <div class="hidden link">
        <label>Page URL:</label>
        <input type="text" class="form-control" placeholder="External link" name="external[en][value]" value="{{ $pageType['en']['type']  == 'url' ? $pageType['en']['value']->url : ""  }}">
    </div>
</div>

<div class="form-group type-box file" style="{{ $pageType['en']['type']  == 'file' ? 'display:block' : ''}}">
    <div class="hidden link">
        <label>
            Upload file: <br/><br/>
            @if($pageType['en']['type'] == 'file')
                <a href="{{ url('public/'.$pageType['en']['value']->path.'/'.$pageType['en']['value']->file_name) }} ">{{ $pageType['en']['value']->original_name }}</a>
            @endif
        </label>

        <input type="file" class="form-control" placeholder="External link" name="external_file_en">
    </div>
</div>

<div class="form-group content">
    <label for="exampleInputEmail3">Content</label>
    <input type="hidden" name="content" value="{{ isset($page) ? $page->content : '' }}"/>
    <div class="summernote">
        {!! isset($page) ? $page->content : '' !!}
    </div>
</div>