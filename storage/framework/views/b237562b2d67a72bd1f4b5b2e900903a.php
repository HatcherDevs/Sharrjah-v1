<?php $__env->startSection('content'); ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Pages</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Pages</h4>
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th onclick="sortTable(1)">Name</th>
                                        <th onclick="sortTable(2)">Name Arabic</th>
                                        <th>Action</th>
                                        <th onclick="sortTable(2)">Date created</th>
                                        <th onclick="sortTable(2)">Last modified</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($page->name); ?></td>
                                            <td><?php echo e($page->name_ar); ?></td>
                                            <td><a href="<?php echo e(URL('admin/web-pages/'.$page->id.'/edit')); ?>">Edit</a>
                                                |
                                                <a target="_blank" href="<?php echo e(URL('pages/preview/'.$page->id)); ?>">Preview</a>
                                                |
                                                <a href="<?php echo e(URL('admin/pages/'.$page->id.'/delete')); ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
                                            <td><?php echo e($page->created_at); ?></td>
                                            <td><?php echo e($page->updated_at); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/pages/show.blade.php ENDPATH**/ ?>