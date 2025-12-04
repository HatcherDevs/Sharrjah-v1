<footer role="footer" class="container">
    <div class="container">
        <div class="blk-border">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-one">
                        <ul>
                            @inject('pageService', 'App\Services\PageService')

                            @foreach($pageService->getPages() as $page)
                                <li>
                                    @if($page['page']->link == "pages/triennial-2019")
                                        <a href="https://2023.sharjaharchitecture.org/" class="mainlink"><span class="ar">ترينالي 2023</span><br>Triennial 2023</a>
                                    @else
                                        <a href="{{ url($page['page']->link) }}">{{ $page['page']->name_ar }}<br><span class="en">{{ $page['page']->name }}</span></a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-two">
                        <ul class="socials">
                            <li><a target="_blank" href="{{ $pageService->getOption('facebook-link') }}" class="fb"></a></li>
                            <li><a target="_blank" href="{{ $pageService->getOption('twitter-link') }}" class="tw"></a></li>
                            <li><a target="_blank" href="{{ $pageService->getOption('instagram-link') }}" class="in"></a></li>
                            <li><a target="_blank" href="{{ $pageService->getOption('vimeo-link') }}" class="vm"></a></li>
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
                        <a href="{{ url('pages/terms-and-conditions') }}">TERMS AND CONDITIONS</a> <a href="#">|</a>
                        <a href="{{ url('pages/website-credits') }}">WEBSITE CREDITS</a>
                        {{ $pageService->getOption('copyright') }}
                    </div>
                    <div class="col-md-4 col-sm-12 text-right ar">
                        {{ $pageService->getOption('copyright-right') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</footer>
<script src="{{ asset('public/js/popper.min.js') }}"></script>