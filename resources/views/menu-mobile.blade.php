<div class="mobile clearfix">
    <ul>
        @inject('pageService', 'App\Services\PageService')
        @php
            $mobileMenus = $pageService->getMobileMenus();
        @endphp

        @foreach ($mobileMenus as $menu)
            <li class="mobile-menu-col">
                <a href="{{ $menu->root_items->isNotEmpty() ? '#' : url($menu->href ?: '#') }}"
                    alt="{{ url($menu->href ?: '#') }}"
                    data-has-items="{{ $menu->root_items->isNotEmpty() ? '1' : '0' }}">
                    <span class="mobile-cat"><span
                            class="ar">{{ $menu->title_ar }}</span><br />{{ $menu->title_en }}</span>
                </a>

                @if ($menu->root_items->isNotEmpty())
                    <ul class="mobile-root-items">
                        @include('partials.menu-mobile-items', ['items' => $menu->root_items])
                    </ul>
                @endif
            </li>
        @endforeach

    </ul>
    <div class="menu-mobile-back"><a href="#" id="mobile-menu-back"><span class="ar">رجوع</span><br />BACK</a>
    </div>
</div>
<style>
    #menu .menu-holder {
        overflow-y: auto;
    }

    #menu .mobile .submenu-list {
        display: none;
    }

    #menu .mobile .mobile-cat {
        width: 100%;
        background-color: #fff;
        display: inline-block;
        line-height: 25px;
        border-top: 1px solid #000;
        margin-bottom: 10px;
    }

    #menu .mobile .mobile-root-items {
        display: none;
    }

    #menu .mobile .mobile-root-items.is-open {
        display: block;
    }

    #menu .mobile .mobile-menu-col.is-hidden {
        display: none;
    }

    #menu .mobile .submenu-list.is-open {
        display: block;
    }

    #menu .mobile .submenu-toggle {
        -webkit-appearance: none;
        appearance: none;
        border: 0;
        background: transparent;
        color: #000;
        font-size: 24px;
        line-height: 1;
        padding: 0 8px;
        cursor: pointer;
        outline: none;
        box-shadow: none;
        border-radius: 0;
    }

    #menu .mobile .submenu-toggle:focus,
    #menu .mobile .submenu-toggle:focus-visible,
    #menu .mobile .submenu-toggle:active {
        outline: none;
        box-shadow: none;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var mobileRoot = document.querySelector('#menu .mobile');
        var mobileCols = Array.prototype.slice.call(document.querySelectorAll(
        '#menu .mobile .mobile-menu-col'));
        var backLink = document.getElementById('mobile-menu-back');
        var backWrapper = backLink ? backLink.closest('.menu-mobile-back') : null;

        function showBack() {
            if (backWrapper) {
                backWrapper.style.display = 'block';
            }

            if (backLink) {
                backLink.style.display = 'inline-block';
            }
        }

        function hideBack() {
            if (backWrapper) {
                backWrapper.style.display = 'none';
            }

            if (backLink) {
                backLink.style.display = 'none';
            }
        }

        function resetMobileMenuState() {
            mobileCols.forEach(function(col) {
                col.classList.remove('is-hidden');
                col.style.display = '';
            });

            document.querySelectorAll('#menu .mobile .mobile-root-items').forEach(function(list) {
                list.classList.remove('is-open');
                list.style.display = '';
            });

            document.querySelectorAll('#menu .mobile .submenu-list').forEach(function(list) {
                list.classList.remove('is-open');
                list.style.display = '';
            });

            document.querySelectorAll('#menu .mobile .submenu-toggle').forEach(function(button) {
                button.textContent = '+';
                button.setAttribute('aria-expanded', 'false');
            });

            if (mobileRoot) {
                mobileRoot.classList.remove('is-drilled-down');
            }

            hideBack();
        }

        hideBack();

        document.querySelectorAll('#menu .mobile .mobile-menu-col > a[data-has-items="1"]').forEach(function(
            link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                var parentItem = link.closest('.mobile-menu-col');
                if (!parentItem) {
                    return;
                }

                var itemsList = parentItem.querySelector('.mobile-root-items');
                if (!itemsList) {
                    return;
                }

                mobileCols.forEach(function(col) {
                    col.classList.toggle('is-hidden', col !== parentItem);
                });

                document.querySelectorAll('#menu .mobile .mobile-root-items').forEach(function(
                    list) {
                    list.classList.remove('is-open');
                });

                itemsList.classList.add('is-open');
                itemsList.style.display = 'block';

                if (mobileRoot) {
                    mobileRoot.classList.add('is-drilled-down');
                }

                showBack();
            });
        });

        if (backLink) {
            backLink.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                if (typeof event.stopImmediatePropagation === 'function') {
                    event.stopImmediatePropagation();
                }
                resetMobileMenuState();
            });
        }

        document.querySelectorAll('#menu .mobile .submenu-toggle').forEach(function(button) {
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
</script>
