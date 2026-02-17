<div class="form-group">
    <label for="exampleInputNamea1">Page status</label>
    <select class="form-control" name="active">
        <option {{ isset($page) && $page && $page->active == 1 ? 'selected="selected"' : '' }} value="1">Active
        </option>
        <option {{ isset($page) && $page && $page->active == 0 ? 'selected="selected"' : '' }} value="0">Hidden
        </option>
    </select>
</div>
