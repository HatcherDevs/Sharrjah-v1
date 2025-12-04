<div class="form-group">
    <label for="exampleInputNamea1">Page Template</label>
    <select class="form-control" name="page_type">
        @if(isset($templates))
            @foreach($templates as $template)
                <?php $selected = ''; ?>

                @if(isset($page))
                    @if($template->slug == $page->page_type)
                        <?php $selected = "selected=selected"; ?>
                    @endif
                @endif

                <option {{ $selected }} value="{{ $template->slug }}">{{ $template->name }}</option>
            @endforeach
        @endif
    </select>
</div>