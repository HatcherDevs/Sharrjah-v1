<div class="form-group">
    <label for="exampleInputNamea1">Page status</label>
    <select class="form-control" name="active">
        <option {{ $page->active==1 ? 'selected="selected"' : '' }} value="1">Active</option>
        <option {{ $page->active==0 ? 'selected="selected"' : '' }} value="0">Hidden</option>
    </select>
</div>