<div class="mobile clearfix">
    <ul>
        @inject('pageService', 'App\Services\PageService')
        @foreach ($pageService->getPages() as $page)
            @if ($page['page']->slug != 'triennial-2019')
                <li>
                    <a href="#" alt="{{ url($page['page']->link) }}">
                        <span class="cat"><span
                                class="ar">{{ $page['page']->name_ar }}</span><br />{{ $page['page']->name }}</span>
                    </a>
                    <ul>
                        @foreach ($page['children'] as $child)
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
                                    <li><a href="{{ url('research') }}"><span class="ar">برنامج أبحاث
                                                الترينالي</span><br />SAT Research Initiative</a></li>
                                @endif
                            @endif

                            @if ($child->slug == 'team-1')
                                            <?php 
                                                        $opportunities =  $pageService->getPageById(50);

                                                        $opportunitiesPage = $pageService->getPostById(477); 
                                                        $opportunitiesSlug =  $opportunities->slug;
                                                        
                                            ?>
                                        
                                            @if ($opportunities->active == 1)  {{-- Only show if active is NOT 1 --}}
                                                <li>
                                                    <a href="{{ url('pages/about/' . $opportunitiesSlug) }}">
                                                        <span class="ar">فرص العمل</span><br />Opportunities
                                                    </a>
                                                </li>

                                                

                                            @endif
                                        @endif
                            @if ($child->slug == 'open-call-exhibition-designer')
                                <?php $research = $pageService->getPageBySlug('opportunitiesi'); ?>
                                {{-- @if ($opportunitiesi->active == 1)
                                    <li>
                                        <p>
                                            <a id="toggleButton" onclick="toggleIcon()" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <span class="ar">فرص العمل</span><br />Opportunities
                                                <i id="icon" class="fa-solid fa-plus" style="padding: 10px;transform: translate(20px,-15px);"></i>
                                            </a>
                                        </p>
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body">
                                              <a href="" class="d-block">Link #1</a>
                                              <a href="" class="d-block">Link #2</a>
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                            <p>
                                                <a id="toggleButtonMobile" onclick="toggleIcon()" data-toggle="collapse" href="#collapseExampleMobile" role="button" aria-expanded="false" aria-controls="collapseExampleMobile">
                                                    <span class="ar">فرص العمل</span><br />Opportunities
                                                    <i id="iconMobile" class="fa-solid fa-plus" style="padding: 10px;transform: translate(20px,-15px);"></i>
                                                </a>
                                            </p>
                                            <div class="collapse" id="collapseExampleMobile">
                                                <div class="card card-body">
                                                    <a href="/pages/social-media-coordinator" class="d-block"><span
                                                        class="ar">منسق
                                                        وسائل التواصل الاجتماعي</span><br />Social Media Coordinator
                                                </a>
                                                <a href="/pages/store-coordinator" class="d-block"><span class="ar">منسق
                                                        المتجر</span><br />Store Coordinator</a>
                                                </div>
                                            </div>
                                    </li>
                                @endif --}}
                            @endif
                        @endforeach
                    </ul>
                </li>
                {{--		@if ($page['page']->slug == 'programs') --}}
                {{--			<li> --}}
                {{--				<a href="#" alt="{{ url('/research') }}"> --}}
                {{--					<span class="cat"><span class="ar">أبحاث</span><br/>Research</span> --}}
                {{--				</a> --}}
                {{--			</li> --}}
                {{--		@endif --}}
            @endif
        @endforeach
        <li>
            <a target="_blank" href="#" alt="#" sstyle="pointer-events: none;">
                <span class="cat"><span class="ar">إصدار ترينالي</span><br />Triennial Edition </span>
            </a>
            <ul>
                <li class="nav-item"> <a target="_blank" href="https://2019.sharjaharchitecture.org/"
                        class="mainlink"><span class="ar">ترينالي
                            2019</span><br />Triennial 2019 </a>
                </li>
                <li class="nav-item"> <a href="https://2023.sharjaharchitecture.org/{{-- url('/pages/triennial-2023') --}}" class="mainlink"><span
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
</script>