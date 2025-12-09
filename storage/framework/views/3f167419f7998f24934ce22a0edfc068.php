<div class="form-group">
    <label for="exampleInputNamea1">Page Template</label>
    <select class="form-control" name="page_type">
        <?php if(isset($templates)): ?>
            <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $selected = ''; ?>

                <?php if(isset($page)): ?>
                    <?php if($template->slug == $page->page_type): ?>
                        <?php $selected = "selected=selected"; ?>
                    <?php endif; ?>
                <?php endif; ?>

                <option <?php echo e($selected); ?> value="<?php echo e($template->slug); ?>"><?php echo e($template->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>
</div><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/partials/pages/template-page-form.blade.php ENDPATH**/ ?>