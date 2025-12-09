<?php $__env->startSection('content'); ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Page</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="<?php echo e(url('admin/pages/update')); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                <input type="hidden" value="<?php echo e($page->id); ?>" name="id">
                <!-- <input type="hidden" value="<?php echo e($page->slug); ?>" name="slug"> -->
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <a target="_blank" href="<?php echo e(URL('pages/preview/'.$page->id)); ?>">Click here to preview page</a>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $__env->make('admin.partials.pages.content-en-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $__env->make('admin.partials.pages.content-ar-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php if( $page->id == 16 ): ?>
                                    <input type="hidden"  name="page_id" value="15">
                                <?php elseif($page->id == 17): ?>
                                    <input type="hidden"  name="page_id" value="15">
                                <?php else: ?>
                                    <?php echo $__env->make('admin.partials.pages.parent-page-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>
                                <?php echo $__env->make('admin.partials.pages.status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('admin.partials.pages.template-page-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $__env->make('admin.partials.pages.featured-images-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('admin.partials.pages.featured-image-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $__env->make('admin.partials.pages.additional-content-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $__env->make('admin.partials.pages.additional-content-ar-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>

             <?php if($page->slug == "venues-and-times"): ?>
             
             
                <?php echo $__env->make('admin.partials.pages.additional2_content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>    
                
             
             <?php endif; ?>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Publish date</label>
                                    <?php
                                    $date = \Carbon\Carbon::now()->format('m/d/y');

                                    if(isset($page))
                                        if($page->created_at)
                                            $date = $page->created_at->format('m/d/y');
                                    ?>
                                    <input type="text" class="form-control datetimepicker" readonly placeholder="" name="created_at" value="<?php echo e($date); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('public/admin/js/file-upload.js')); ?>"></script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/pages/edit.blade.php ENDPATH**/ ?>