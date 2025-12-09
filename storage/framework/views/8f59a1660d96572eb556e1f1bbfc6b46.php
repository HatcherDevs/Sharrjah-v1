<div class="v-content nav-section desk">
    <div class="">
        <ul class="nav">
            <?php $pageService = app('App\Services\PageService'); ?>

            <?php $__currentLoopData = $pageService->getPages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page['page']->slug != 'triennial-2019'): ?>
                    <li>

                        <a href="<?php echo e(url($page['page']->link)); ?>" class="mainlink"><span
                                class="ar"><?php echo e($page['page']->name_ar); ?></span><br /><?php echo e($page['page']->name); ?></a>
                        <?php if($page['children'] && count($page['children'])): ?>
                            <ul class="sub english-nav">
                        <?php endif; ?>

                        <?php $__currentLoopData = $page['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($child->slug != 'open-call-exhibition-designer'): ?>
                    <li><a href="<?php echo e(url($child->link)); ?>"><span
                                class="ar"><?php echo e($child->name_ar); ?></span><br /><?php echo e($child->name); ?></a></li>
                <?php endif; ?>

                <?php if($child->slug == 'sat-talks-architecture'): ?>
                    <?php $research = $pageService->getPageBySlug('research'); ?>
                    <?php if($research->active == 1): ?>
                        <li><a href="<?php echo e(url('pages/research')); ?>"><span class="ar">برنامج أبحاث
                                    الترينالي</span><br />SAT Research Initiative</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo e(url('research')); ?>"><span class="ar">برنامج أبحاث الترينالي</span><br />SAT
                                Research Initiative</a></li>
                    <?php endif; ?>
                <?php endif; ?>


                <?php if($child->slug == 'team-1'): ?>
                    <?php
                    $opportunities = $pageService->getPageById(50);
                    $opportunitiesPage = $pageService->getPostById(477);
                    $opportunitiesSlug = $opportunities->slug;
                    
                    ?>

                    <?php if($opportunities->active == 1): ?>
                        <li>
                            <a href="<?php echo e(url('pages/about/' . $opportunitiesSlug)); ?>">
                                <span class="ar">فرص العمل</span><br />Opportunities
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($page['children'] && count($page['children'])): ?>
        </ul>
        <?php endif; ?>
        </li>
        <?php endif; ?>

        
        
        
        
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



        <li>
            <a target="_blank" href="#" class="mainlink"><span class="ar">إصدار ترينالي</span><br />Triennial
                Edition</a>

            <ul>
                <li class="nav-item"> <a href="https://2023.sharjaharchitecture.org/"
                        class="mainlink"><span class="ar">ترينالي 2023</span><br />Triennial 2023</a>
                </li>

                <li class="nav-item"> <a target="_blank" href="https://2019.sharjaharchitecture.org/"
                        class="mainlink"><span class="ar">ترينالي
                            2019</span><br />Triennial 2019 </a>
                </li>

            </ul>
        </li>

        </ul>
    </div>
</div>
<style>
    #menu .menu-holder {
        overflow-y: auto;
    }
</style>
<script>
    function toggleIcon() {
        var iconElement = document.getElementById("icon");

        if (iconElement.classList.contains("fa-plus")) {
            // إذا كان الرمز الحالي "fa-plus"، قم بتبديله إلى "fa-minus"
            iconElement.classList.remove("fa-plus");
            iconElement.classList.add("fa-minus");
        } else {
            // إذا كان الرمز الحالي "fa-minus"، قم بتبديله إلى "fa-plus"
            iconElement.classList.remove("fa-minus");
            iconElement.classList.add("fa-plus");
        }
    }
</script>
<script src="https://kit.fontawesome.com/7b5e9f3ec6.js" crossorigin="anonymous"></script>
<?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/menu-desktop.blade.php ENDPATH**/ ?>