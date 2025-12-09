<h4 class="card-title">English</h4>
<div class="form-group">
    <label for="exampleInputName1">Title</label>
    <?php if(request()->is('*/web-pages/*/edit')): ?>
        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name" required value="<?php echo e(isset($page) ? $page->name : ''); ?>" disabled>
    <?php else: ?>
        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name" required value="<?php echo e(isset($page) ? $page->name : ''); ?>" >
    <?php endif; ?>
</div>
<div class="form-group">
    <label for="exampleInputEmail3">Content</label>
    <input type="hidden" name="content" value="<?php echo e(isset($page) ? $page->content : ''); ?>"/>
    <div class="summernote">
        <?php echo isset($page) ? $page->content : ''; ?>

    </div>
</div><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/partials/pages/content-en-form.blade.php ENDPATH**/ ?>