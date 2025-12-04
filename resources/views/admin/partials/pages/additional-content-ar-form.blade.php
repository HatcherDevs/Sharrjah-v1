<div class="form-group" style="border-top: 3px solid #ccc;padding-top: 20px;">

 
    <p><b>Show Arabic Additional Content :</b></p>
    <input type="radio" id="1" name="additional_content_ar_active" value="1"{{$page->additional_content_ar_active == '1'? 'checked' : ''}}>
    <label for="1">show</label><br>
    <input type="radio" id="0" name="additional_content_ar_active" value="0"{{$page->additional_content_ar_active =='0'? 'checked' : ''}}>
    <label for="0">hide</label><br>
   
 
 
    <br>
 

    <label for="exampleTextareaa1">Arabic Additional Content (Top)</label>
    <div class="form-group">
    <input type="hidden" name="additional_content_ar_top" value="{{ isset($page) ? $page->additional_content_ar_top : '' }}">
    <div class="summernote">
        @if(isset($page))
            {!! $page->additional_content_ar_top !!}
        @endif
    </div>
    </div>
    <br/>
    <br/>
    <label for="exampleTextareaa1">Arabic Additional Content (Bottom)</label>
    <div class="form-group">
        <input type="hidden" name="additional_content_ar_bottom" value="{{ isset($page) ? $page->additional_content_ar_bottom : '' }}">
        <div class="summernote">
            @if(isset($page))
                {!! $page->additional_content_ar_bottom !!}
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