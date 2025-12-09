<footer role="footer" class="container">
    <div class="container">
        <div class="blk-border">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-one">
                        <ul>
                            <?php $pageService = app('App\Services\PageService'); ?>

                            <?php $__currentLoopData = $pageService->getPages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <?php if($page['page']->link == "pages/triennial-2019"): ?>
                                        <a href="https://2023.sharjaharchitecture.org/" class="mainlink"><span class="ar">ترينالي 2023</span><br>Triennial 2023</a>
                                    <?php else: ?>
                                        <a href="<?php echo e(url($page['page']->link)); ?>"><?php echo e($page['page']->name_ar); ?><br><span class="en"><?php echo e($page['page']->name); ?></span></a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="col-two">
                        <ul class="socials">
                            <li><a target="_blank" href="<?php echo e($pageService->getOption('facebook-link')); ?>" class="fb"></a></li>
                            <li><a target="_blank" href="<?php echo e($pageService->getOption('twitter-link')); ?>" class="tw"></a></li>
                            <li><a target="_blank" href="<?php echo e($pageService->getOption('instagram-link')); ?>" class="in"></a></li>
                            <li><a target="_blank" href="<?php echo e($pageService->getOption('vimeo-link')); ?>" class="vm"></a></li>
                        </ul>
                    </div>
                    <div class="col-three">
                        <a href="#" data-toggle="modal" data-target="#subscribeModal">
                            <span class="ar">سجل لاستلام بريدنا الإلكتروني</span> <br>
                            <span class="en">Subscribe to our Mailing List</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="copyright">
                <div class="row">
                    <div class="col-md-8 col-sm-12 en">
                        <a href="<?php echo e(url('pages/terms-and-conditions')); ?>">TERMS AND CONDITIONS</a> <a href="#">|</a>
                        <a href="<?php echo e(url('pages/website-credits')); ?>">WEBSITE CREDITS</a>
                        <?php echo e($pageService->getOption('copyright')); ?>

                    </div>
                    <div class="col-md-4 col-sm-12 text-right ar">
                        <?php echo e($pageService->getOption('copyright-right')); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
</footer>
<script src="<?php echo e(asset('public/js/popper.min.js')); ?>"></script><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/footer.blade.php ENDPATH**/ ?>