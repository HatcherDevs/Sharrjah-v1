<div class="form-group">
    <label for="exampleInputNamea1">Parent Page</label>
    <select class="form-control" name="page_id">
        <option value="0">None</option>
        <?php if(isset($pages)): ?>
            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $select_page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $selected = ''; ?>

                <?php if(isset($page)): ?>
                    <?php if($page->parent): ?>
                        <?php if($select_page->id == $page->parent->id): ?>
                            <?php $selected = "selected=selected"; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>

                <option <?php echo e($selected); ?> value="<?php echo e($select_page->id); ?>"><?php echo e($select_page->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>
</div><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/partials/pages/parent-page-form.blade.php ENDPATH**/ ?>