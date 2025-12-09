<div class="mobile clearfix">
    <ul>
        <?php $pageService = app('App\Services\PageService'); ?>
        <?php $__currentLoopData = $pageService->getPages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($page['page']->slug != 'triennial-2019'): ?>
                <li>
                    <a href="#" alt="<?php echo e(url($page['page']->link)); ?>">
                        <span class="cat"><span
                                class="ar"><?php echo e($page['page']->name_ar); ?></span><br /><?php echo e($page['page']->name); ?></span>
                    </a>
                    <ul>
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
                                    <li><a href="<?php echo e(url('research')); ?>"><span class="ar">برنامج أبحاث
                                                الترينالي</span><br />SAT Research Initiative</a></li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if($child->slug == 'team-1'): ?>
                                            <?php 
                                                        $opportunities =  $pageService->getPageById(50);

                                                        $opportunitiesPage = $pageService->getPostById(477); 
                                                        $opportunitiesSlug =  $opportunities->slug;
                                                        
                                            ?>
                                        
                                            <?php if($opportunities->active == 1): ?>  
                                                <li>
                                                    <a href="<?php echo e(url('pages/about/' . $opportunitiesSlug)); ?>">
                                                        <span class="ar">فرص العمل</span><br />Opportunities
                                                    </a>
                                                </li>

                                                

                                            <?php endif; ?>
                                        <?php endif; ?>
                            <?php if($child->slug == 'open-call-exhibition-designer'): ?>
                                <?php $research = $pageService->getPageBySlug('opportunitiesi'); ?>
                                
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
                
                
                
                
                
                
                
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <li>
            <a target="_blank" href="#" alt="#" sstyle="pointer-events: none;">
                <span class="cat"><span class="ar">إصدار ترينالي</span><br />Triennial Edition </span>
            </a>
            <ul>
                <li class="nav-item"> <a target="_blank" href="https://2019.sharjaharchitecture.org/"
                        class="mainlink"><span class="ar">ترينالي
                            2019</span><br />Triennial 2019 </a>
                </li>
                <li class="nav-item"> <a href="https://2023.sharjaharchitecture.org/" class="mainlink"><span
                            class="ar">ترينالي 2023</span><br />Triennial 2023</a>
                </li>

            </ul>

        </li>
    </ul>
    <div class="menu-mobile-back"><a href="#" id="mobile-menu-back"><span class="ar">رجوع</span><br />BACK</a>
    </div>
</div>
<style>
    #menu .menu-holder{
        overflow-y: auto;
    }
</style>
<script>
    function toggleIcon() {
        var iconElement = document.getElementById("iconMobile");
        var collapseExample = document.getElementById("collapseExampleMobile");

        console.log(collapseExample);
        if (iconElement.classList.contains("fa-plus")) {
            iconElement.classList.remove("fa-plus");
            iconElement.classList.add("fa-minus");
            collapseExample.classList.add("d-block");
        } else {
            iconElement.classList.remove("fa-minus");
            collapseExample.classList.remove("d-block");
            iconElement.classList.add("fa-plus");
        }
    }
</script><?php /**PATH H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\public_html\resources\views/menu-mobile.blade.php ENDPATH**/ ?>