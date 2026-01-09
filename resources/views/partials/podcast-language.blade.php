<div class="row">
    <div class="col-md-12 text-right m-0">
        @if (isset($_GET['lang']) && $_GET['lang'] == 'ar')
            <a class="lang-switch" href="{{ url('pages/' . $page->parent->slug . '/' . $page->slug) }}">Switch to English</a>
        @else
            <a class="lang-switch" href="{{ url('pages/' . $page->parent->slug . '/' . $page->slug) }}?lang=ar">التبديل إلى
                اللغة العربية</a>
        @endif
    </div>
</div>
