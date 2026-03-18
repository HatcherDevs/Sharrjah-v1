<div class="v-content nav-section desk">
    <div class="">
        <ul class="nav">
            @inject('pageService', 'App\Services\PageService')

            @foreach ($pageService->getPages() as $page)
                @if ($page['page']->slug != 'triennial-2019')
                    <li>

                        <a href="{{ url($page['page']->link) }}" class="mainlink"><span
                                class="ar">{{ $page['page']->name_ar }}</span><br />{{ $page['page']->name }}</a>
                        @if (isset($page['children']) && count($page['children']))
                            <ul class="sub english-nav">
                        @endif

                        @foreach ($page['children'] ?? [] as $child)
                            @if ($child->slug != 'open-call-exhibition-designer')
                    <li><a href="{{ url($child->link) }}"><span
                                class="ar">{{ $child->name_ar }}</span><br />{{ $child->name }}</a></li>
                @endif

                @if ($child->slug == 'sat-talks-architecture')
                    <?php $research = $pageService->getPageBySlug('research'); ?>
                    @if ($research->active == 1)
                        <li><a href="{{ url('pages/research') }}"><span class="ar">برنامج أبحاث
                                    الترينالي</span><br />SAT Research Initiative</a></li>
                    @else
                        <li><a href="{{ url('research') }}"><span class="ar">برنامج أبحاث الترينالي</span><br />SAT
                                Research Initiative</a></li>
                    @endif
                @endif


                @if ($child->slug == 'team-1')
                    <?php
                    $opportunities = $pageService->getPageById(50);
                    $opportunitiesPage = $pageService->getPostById(477);
                    $opportunitiesSlug = $opportunities->slug;
                    ?>

                    @if ($opportunities->active == 1)
                        <li>
                            <a href="{{ url('pages/about/' . $opportunitiesSlug) }}">
                                <span class="ar">فرص العمل</span><br />Opportunities
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach

            @if (isset($page['children']) && count($page['children']))
        </ul>
        @endif
        </li>
        @endif

        {{--				@if ($page['page']->slug == 'programs') --}}
        {{--					<li> --}}
        {{--						<a href="{{ url('/research') }}" class="mainlink"><span class="ar">أبحاث</span><br/>Research</a> --}}
        {{--					</li> --}}
        {{--				@endif --}}
        @endforeach



        <li>
            <a target="_blank" href="#" class="mainlink"><span class="ar">إصدار ترينالي</span><br />Triennial
                Edition</a>

            <ul>
                <li class="nav-item"> <a href="https://2023.sharjaharchitecture.org/{{-- url('/pages/triennial-2023') --}}"
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
