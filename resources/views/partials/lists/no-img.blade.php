<div class="container text-center">
<div class="row">
    <div class="body-section contents">
    <div class="row">
        <ul class="figure-list full {{ $page->page_type=="list-one-lang" ? 'full-items' : '' }}">
            @foreach($data as $child)
                <li class="al-right">
                    <div class="colm titles">
                        <div class="title clearfix" dir="rtl">
                            <strong>
                                <a href="{{ $child->linkAr }}"><span class="ar">{{ $child->title_ar }}</span></a>
                                <a href="{{ $child->link }}"><span class="en" dir="ltr">{{ $child->title }}</span></a>
                            </strong><br/>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    </div>
</div>
</div>