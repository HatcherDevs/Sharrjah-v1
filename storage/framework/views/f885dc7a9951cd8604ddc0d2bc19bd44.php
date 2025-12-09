<div class="form-group">
    <label for="exampleInputNamea1">Page status</label>
    <select class="form-control" name="active">
        <option <?php echo e($page->active==1 ? 'selected="selected"' : ''); ?> value="1">Active</option>
        <option <?php echo e($page->active==0 ? 'selected="selected"' : ''); ?> value="0">Hidden</option>
    </select>
</div><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/partials/pages/status.blade.php ENDPATH**/ ?>