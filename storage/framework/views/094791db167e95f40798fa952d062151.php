<?php if(count($page->sliders)): ?>
    <div class="form-group" style="border-top:3px solid #ccc">
    <br/>
    <strong>Featured Images</strong>
    <br/><br/>

        <div class="row" id="current-images">
            <?php $__currentLoopData = $page->sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="file-upload">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if($slide->landscape): ?>
                                <img src="<?php echo e(asset('public'.$slide->landscape->url)); ?>" width="100%">
                                <br/>
                                <br/>
                            <?php endif; ?>
                            <?php if($slide->square): ?>
                                <img src="<?php echo e(asset('public'.$slide->square->url)); ?>" width="100%">
                            <?php endif; ?>
                            <input type="hidden" name="uploads[<?php echo e($slide->landscape->id); ?>][id]" value="<?php echo e($slide->landscape->id); ?>" width="100%">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image Caption EN:</label>
                                <input type="text" class="form-control" placeholder="Image Caption EN" name="upload-captions[<?php echo e($slide->landscape->id); ?>][EN]"  value="<?php echo e($slide->landscape->caption); ?>">
                            </div>
                            <div class="form-group">
                                <label>Image Caption AR:</label>
                                <input type="text" class="form-control" placeholder="Image Caption AR" name="upload-captions[<?php echo e($slide->landscape->id); ?>][AR]"  value="<?php echo e($slide->landscape->caption_ar); ?>">
                            </div>

                            <?php if($slide->square): ?>
                                <div class="form-group">
                                    <label>Replace Square:</label>
                                    <input type="file" class="form-control" name="uploads[<?php echo e($slide->square->id); ?>]" placeholder="Upload Image">
                                </div>
                            <?php else: ?>
                                <div class="form-group">
                                    <label>Add Square:</label>
                                    <input type="hidden" name="newUploads[slide_id]" value="<?php echo e($slide->id); ?>">
                                    <input type="file" class="form-control" name="newUploads[square]" placeholder="Upload Image">
                                </div>
                            <?php endif; ?>

                            <?php if($slide->landscape): ?>
                                <div class="form-group">
                                    <label>Replace Landscape:</label>
                                    <input type="file" class="form-control" name="uploads[<?php echo e($slide->landscape->id); ?>]" placeholder="Upload Image">
                                </div>
                            <?php else: ?>
                                <div class="form-group">
                                    <label>Add Landscape:</label>
                                    <input type="hidden" name="newUploads[slide_id]" value="<?php echo e($slide->id); ?>">
                                    <input type="file" class="form-control" name="newUploads[landscape]" placeholder="Upload Image">
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label>Remove Slide:<input type="checkbox" class="form-control" name="delete[<?php echo e($slide->id); ?>]" placeholder="Upload Image" value="<?php echo e($slide->id); ?>"></label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/partials/pages/featured-images-list.blade.php ENDPATH**/ ?>