<div class="form-group" style="border-top: 3px solid #ccc;padding-top: 20px;">
    <label for="exampleTextareaa1">Additional Content (Top)</label>
    <div class="form-group">
    <input type="hidden" name="additional_content_top" value="{{ isset($page) ? $page->additional_content_top : '' }}">
    <div class="summernote">
        @if(isset($page))
            {!! $page->additional_content_top !!}
        @endif
    </div>
    </div>
    <br/>
    <br/>
    <label for="exampleTextareaa1">Additional Content (Bottom)</label>
    <div class="form-group">
        <input type="hidden" name="additional_content_bottom" value="{{ isset($page) ? $page->additional_content_bottom : '' }}">
        <div class="summernote">
            @if(isset($page))
                {!! $page->additional_content_bottom !!}
            @endif
        </div>
    </div>
    <br/>
    <br/>
    @if($forms)
        <label for="exampleTextareaa1">Add a form:</label>
        <select name="form_id" class="form-control">
            <option value="0">None</option>
            @foreach($forms as $id=>$form)
                <?php
                    $selectedFormId = 0;
                    if(isset($page)){
                        if($page->forms()->count()){
                            $selectedFormId = $page->forms()->first()->form->id;
                        }
                    }
                ?>
                <option {{ $selectedFormId==$form->id ? 'selected="selected"' : '' }} value="{{ $form->id }}">{{ $form->title }}</option>
            @endforeach
        </select>
    @endif
</div>