<div class="v-content nav-section desk">
    <div>
        <ul class="nav">
            @inject('pageService', 'App\Services\PageService')

            @php
                $desktopMenus = $pageService->getDesktopMenus();
            @endphp

            @if ($desktopMenus->isNotEmpty())
                @foreach ($desktopMenus as $menu)
                    <li>
                        <a href="{{ url($menu->href ?: '#') }}" class="mainlink">
                            <span class="ar">{{ $menu->title_ar }}</span><br />{{ $menu->title_en }}
                        </a>

                        @if ($menu->root_items->isNotEmpty())
                            <ul class="sub english-nav">
                                @include('partials.menu-desktop-items', ['items' => $menu->root_items])
                            </ul>
                        @endif
                    </li>
                @endforeach

            @endif

        </ul>
    </div>
</div>

<style>
    #menu .menu-holder {
        overflow-y: auto;
    }

    #menu .nav-section.desk .english-nav li {
        float: none;
        width: 100%;
    }

    #menu .nav-section.desk .english-nav .english-nav {
        position: static;
        top: auto;
        opacity: 1;
        z-index: 2;
        margin-top: 8px;
        padding-left: 12px;
    }

    #menu .nav-section.desk .submenu-list {
        display: none;
    }

    #menu .nav-section.desk .submenu-list.is-open {
        display: block;
    }

    #menu .submenu-toggle {
        -webkit-appearance: none;
        appearance: none;
        border: 0;
        background: transparent;
        color: #000;
        font-size: 24px;
        line-height: 1;
        padding: 0 8px;
        cursor: pointer;
        vertical-align: middle;
        outline: none;
        box-shadow: none;
        border-radius: 0;
    }

    #menu .submenu-toggle:focus,
    #menu .submenu-toggle:focus-visible,
    #menu .submenu-toggle:active {
        outline: none;
        box-shadow: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#menu .submenu-toggle').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                var listItem = button.closest('li');
                if (!listItem) {
                    return;
                }

                var submenu = null;
                Array.prototype.forEach.call(listItem.children, function(child) {
                    if (!submenu && child.tagName === 'UL' && child.classList.contains(
                            'submenu-list')) {
                        submenu = child;
                    }
                });

                if (!submenu) {
                    return;
                }

                var isOpen = submenu.classList.toggle('is-open');
                button.textContent = isOpen ? '-' : '+';
                button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        });
    });

    function toggleIcon() {
        var iconElement = document.getElementById('icon');

        if (!iconElement) {
            return;
        }

        if (iconElement.classList.contains('fa-plus')) {
            iconElement.classList.remove('fa-plus');
            iconElement.classList.add('fa-minus');
            return;
        }

        iconElement.classList.remove('fa-minus');
        iconElement.classList.add('fa-plus');
    }
</script>

<script src="https://kit.fontawesome.com/7b5e9f3ec6.js" crossorigin="anonymous"></script>
