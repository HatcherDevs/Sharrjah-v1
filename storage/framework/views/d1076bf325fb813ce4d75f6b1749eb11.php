<div class="form-group" style="border-top: 3px solid #ccc;padding-top: 20px;">

 
    <p><b>Show Arabic Additional Content :</b></p>
    <input type="radio" id="1" name="additional_content_ar_active" value="1"<?php echo e($page->additional_content_ar_active == '1'? 'checked' : ''); ?>>
    <label for="1">show</label><br>
    <input type="radio" id="0" name="additional_content_ar_active" value="0"<?php echo e($page->additional_content_ar_active =='0'? 'checked' : ''); ?>>
    <label for="0">hide</label><br>
   
 
 
    <br>
 

    <label for="exampleTextareaa1">Arabic Additional Content (Top)</label>
    <div class="form-group">
    <input type="hidden" name="additional_content_ar_top" value="<?php echo e(isset($page) ? $page->additional_content_ar_top : ''); ?>">
    <div class="summernote">
        <?php if(isset($page)): ?>
            <?php echo $page->additional_content_ar_top; ?>

        <?php endif; ?>
    </div>
    </div>
    <br/>
    <br/>
    <label for="exampleTextareaa1">Arabic Additional Content (Bottom)</label>
    <div class="form-group">
        <input type="hidden" name="additional_content_ar_bottom" value="<?php echo e(isset($page) ? $page->additional_content_ar_bottom : ''); ?>">
        <div class="summernote">
            <?php if(isset($page)): ?>
                <?php echo $page->additional_content_ar_bottom; ?>

            <?php endif; ?>
        </div>
    </div>
    <br/>
    <br/>
    <?php if($forms): ?>
        <label for="exampleTextareaa1">Add a form:</label>
        <select name="form_id" class="form-control">
            <option value="0">None</option>
            <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $selectedFormId = 0;
                    if(isset($page)){
                        if($page->forms()->count()){
                            $selectedFormId = $page->forms()->first()->form->id;
                        }
                    }
                ?>
                <option <?php echo e($selectedFormId==$form->id ? 'selected="selected"' : ''); ?> value="<?php echo e($form->id); ?>"><?php echo e($form->title); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php endif; ?>
</div><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/partials/pages/additional-content-ar-form.blade.php ENDPATH**/ ?>