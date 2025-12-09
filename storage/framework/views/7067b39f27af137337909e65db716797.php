<?php echo $__env->make('admin.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
<?php echo $__env->make('admin.partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- partial -->
    <?php echo $__env->yieldContent('content'); ?>
</div>

<?php echo $__env->make('admin.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/admin/partials/master.blade.php ENDPATH**/ ?>