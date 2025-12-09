<h4 class="card-title">Arabic</h4>
<div class="form-group">
    <label for="exampleInputNamea1">Title</label>
    <?php if(request()->is('*/web-pages/*/edit')): ?>
        <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Name" name="name_ar" required value="<?php echo e(isset($page) ? $page->name_ar : ''); ?>" disabled>
    <?php else: ?>
        <input type="text" class="form-control" id="exampleInputNamea1" placeholder="Name" name="name_ar" required value="<?php echo e(isset($page) ? $page->name_ar : ''); ?>" >
    <?php endif; ?>
</div>
<div class="form-group">
    <label for="exampleInputEmaila3">Content</label>
    <input type="hidden" name="content_ar" value="<?php echo e(isset($page) ? $page->content_ar : ''); ?>"/>
    <div class="summernote">
        <?php echo isset($page) ? $page->content_ar : ''; ?>

    </div>
</div><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/partials/pages/content-ar-form.blade.php ENDPATH**/ ?>