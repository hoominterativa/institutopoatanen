<div id="SIDE02" class="side02 transition burger__target">
    <div class="side02__scroll">
        <div class="side02__header row">
            <div class="side02__header__button-close col-6 text-start ">
                <button class="burguer">
                    <svg class="side02__header__button-close__icon" width="13" height="15" viewBox="0 0 13 15"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M-3.71547e-07 7.5L12.75 0.138784L12.75 14.8612L-3.71547e-07 7.5Z" fill="#D9D9D9" />
                    </svg>
                </button>
            </div>
            {{-- END .side02__header__button-close --}}
            {{-- <nav class="side02__header__languages d-flex align-items-center justify-content-end col-6">
                <a href="#" class="side02__header__languages__item">PT</a>
                <a href="#" class="side02__header__languages__item">EN</a>
            </nav> --}}
        </div>
        {{-- END .side02__header --}}

        <img src="{{ asset('storage/' . $generalSetting->path_logo_header_light) }}" class="side02__logo" width="202"
            alt="{{ env('APP_NAME') }}">

        <nav class="side02__navigation">
            <ul class="side02__navigation__wrapper sideLinks">
                <li class="side02__navigation__item">
                    <a href="{{ route('home') }}" class="side02__navigation__item__link transition">
                        {{-- <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" width="25" class="me-3"
                            alt="">  --}}
                        Home
                    </a>
                </li>
                @foreach ($listMenu as $module => $menu)
                    <li class="side02__navigation__item {{ $menu->dropdown ? 'dropdown' : '' }}">
                        <a href="{{ $menu->anchor ? $menu->link : route($menu->link) }}"
                            target="{{ $menu->target_link ?? '_self' }}"
                            {{ $menu->dropdown ? 'data-bs-toggle=dropdown' : '' }} {{-- {{ $menu->anchor ? 'data-bs-toggle=jqueryanchor' : '' }} --}}
                            class="side02__navigation__item__link transition {{ !$menu->anchor ? isActive($menu->link) : '' }}">
                            {{-- <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" width="25"
                                class="me-3" alt="">  --}}
                            {{ $menu->title }}
                            @if ($menu->dropdown)
                                <i class="menu-arrow"></i>
                            @endif
                        </a>
                        @if ($menu->dropdown)
                            <div class="side02__navigation__dropdown dropdown-menu">
                                @foreach ($menu->dropdown as $item)
                                    <a href="{{ $item->route }}" target="{{ $item->target }}"
                                        class="side02__navigation__sublink transition">
                                        {{ $item->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            {{-- END .side02__navigation__wrapper --}}
        </nav>
        {{-- END .side02__navigation --}}

        @if ($linksCtaHeader->count() && $callToActionTitle->active_header ?? false)
            <div class="side02__container-cta">
                @if ($linksCtaHeader->count() > 1)
                    <div class="side02__container-cta__dropdown dropdown">
                        <a href="javascript:void(0)" data-bs-toggle="dropdown"
                            class="side02__container-cta__btn-cta transition">{{ $callToActionTitle->title_header ?? '' }}
                            <i class="menu-arrow"></i></a>
                        <div class="side02__container-cta__sublink dropdown-menu"
                            aria-labelledby="side02__container-cta__sublink">
                            @foreach ($linksCtaHeader as $linkCtaHeader)
                                <a href="{{ getUri($linkCtaHeader->link) }}"
                                    target="{{ $linkCtaHeader->link_target }}"
                                    class="side02__container-cta__sublink__item transition">{{ $linkCtaHeader->title }}</a>
                            @endforeach
                        </div>
                    </div>
                @else
                    @foreach ($linksCtaHeader as $linkCtaHeader)
                        <a href="{{ getUri($linkCtaHeader->link) }}" target="{{ $linkCtaHeader->link_target }}"
                            class="side02__container-cta__sublink__item transition">{{ $linkCtaHeader->title }}</a>
                    @endforeach
                @endif
            </div>
        @endif
        {{-- END .btn-cta --}}

        @if ($socials->count())
            <nav class="side02__social d-flex align-items-center justify-content-center">
                @foreach ($socials as $social)
                    <a href="{{ $social->link }}" class="social-link transition" title="{{ $social->title }}">
                        <img src="{{ asset('storage/' . $social->path_image_icon) }}" width="28.5px"
                            alt="{{ $social->title }}">
                    </a>
                @endforeach
            </nav>
        @endif

        @if ($linksCtaFooter->count())
            <div class="side02__footer d-flex align-items-center justify-content-center">
                @foreach ($linksCtaFooter as $linkCtaHeader)
                    <li><a href="{{ $linkCtaHeader->link }}" target="{{ $linkCtaHeader->link_target }}"
                            rel="next">{{ $linkCtaHeader->title }}</a></li>
                @endforeach
            </div>
        @endif
    </div>

</div>
