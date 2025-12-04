<div class="form-group">
    <label for="exampleInputNamea1">Parent Page</label>
    <select class="form-control" name="page_id">
        <option value="0">None</option>
        @if(isset($pages))
            @foreach($pages as $select_page)
                <?php $selected = ''; ?>

                @if(isset($page))
                    @if($page->parent)
                        @if($select_page->id == $page->parent->id)
                            <?php $selected = "selected=selected"; ?>
                        @endif
                    @endif
                @endif

                <option {{ $selected }} value="{{ $select_page->id }}">{{ $select_page->name }}</option>
            @endforeach
        @endif
    </select>
</div>