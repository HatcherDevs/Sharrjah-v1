@foreach ($items as $item)
    <li>
        <a href="{{ $item->children->isNotEmpty() ? '#' : url($item->href ?: '#') }}" alt="{{ url($item->href ?: '#') }}">
            <span class="mobile-cat">
                <span class="ar">{{ $item->title_ar }}</span><br />{{ $item->title_en }}
            </span>
        </a>

        @if ($item->children->isNotEmpty())
            <button type="button" class="submenu-toggle" aria-expanded="false" aria-label="Toggle submenu">+</button>
            <ul class="submenu-list">
                @include('partials.menu-mobile-items', ['items' => $item->children])
            </ul>
        @endif
    </li>
@endforeach
