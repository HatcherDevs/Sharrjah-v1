@foreach ($items as $item)
    <li>
        <a href="{{ url($item->href ?: '#') }}">
            <span class="ar">{{ $item->title_ar }}</span><br />{{ $item->title_en }}
        </a>

        @if ($item->children->isNotEmpty())
            <button type="button" class="submenu-toggle" aria-expanded="false" aria-label="Toggle submenu">+</button>
        @endif

        @if ($item->children->isNotEmpty())
            <ul class="sub english-nav submenu-list">
                @include('partials.menu-desktop-items', ['items' => $item->children])
            </ul>
        @endif
    </li>
@endforeach
