<div class="form-group">
    <label for="exampleInputNamea1">Related Pages</label>
    <select class="form-control" name="page_type">
        @if(isset($pagesList))
            @foreach($pagesList as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        @endif
    </select>
</div>