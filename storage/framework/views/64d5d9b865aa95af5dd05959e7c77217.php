<?php $__env->startSection('content'); ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3>Homepage Contents</h3>
                    </div>
                </div>
            </div>
        </div>

            <form class="forms-sample" action="<?php echo e(url('admin/home/update')); ?>" method="post">
                <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">Video Content</h1>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">English</label>
                                    <input type="hidden" name="headline-en"  value="<?php echo e($data['headline-en']); ?>">
                                    <div class="summernote">
                                        <?php echo $data['headline-en']; ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmaila3">Arabic</label>
                                    <input type="hidden" name="headline-ar"  value="<?php echo e($data['headline-ar']); ?>"/>
                                    <div class="summernote">
                                        <?php echo $data['headline-ar']; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">Body Content</h1>
                                <div class="form-group no-fontsize">
                                    <label for="exampleInputEmail3">English</label>
                                    <input type="hidden" name="intro-en"  value="<?php echo e($data['intro-en']); ?>">
                                    <div class="summernote no-fontsize">
                                        <?php echo $data['intro-en']; ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h1 class="card-title">Font Size EN</h1>
                                            <div class="form-group">
                                                <input type="number" value="<?php echo e($data['home-page-font-size-en']); ?>" name="home-page-font-size-en">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h1 class="card-title">Line Height EN</h1>
                                            <div class="form-group">
                                                <input type="number" value="<?php echo e($data['home-page-font-line-en']); ?>" name="home-page-font-line-en">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-fontsize">
                                    <label for="exampleInputEmaila3">Arabic</label>
                                    <input type="hidden" name="intro-ar"  value="<?php echo e($data['intro-ar']); ?>"/>
                                    <div class="summernote">
                                        <?php echo $data['intro-ar']; ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h1 class="card-title">Font Size AR</h1>
                                            <div class="form-group">
                                                <input type="number" value="<?php echo e($data['home-page-font-size-ar']); ?>" name="home-page-font-size-ar">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h1 class="card-title">Line Height AR</h1>
                                            <div class="form-group">
                                                <input type="number" value="<?php echo e($data['home-page-font-line-ar']); ?>" name="home-page-font-line-ar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">Additional Content</h1>
                                <div class="form-group">
                                    <input type="hidden" name="additional"  value="<?php echo e($data['additional']); ?>">
                                    <div class="summernote">
                                        <?php echo $data['additional']; ?>

                                    </div>
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
<?php echo $__env->make('admin.partials.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/home/home.blade.php ENDPATH**/ ?>