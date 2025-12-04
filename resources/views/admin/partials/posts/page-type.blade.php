<div class="form-group">
    <label>Type</label>
    <select class="form-control type_select" name="type">
        <option value="page">Page</option>
        <option value="url">Link to external page</option>
        <option value="file">Links to file</option>
        <option value="blank">No link</option>
    </select>
</div>

<div class="form-group type-box external_link">
    <div class="hidden link">
        <label>Page URL:</label>
        <input type="hidden" class="form-control" placeholder="External link" name="external_link" value="">
    </div>
</div>

<div class="form-group type-box external_file">
    <div class="hidden link">
        <label>Upload file:</label>
        <input type="text" class="form-control" placeholder="External link" name="external_file">
    </div>
</div>

<div class="form-group type-box external_link_blank">
    <div class="hidden link">
        <input type="hidden" class="form-control" placeholder="External link" name="external_link" value="#">
    </div>
</div>