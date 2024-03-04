<nav id="SIDE02" class="side02 burger__target">
    <div class="side02__header">
        <button class="side02__header__button-close burguer">
            <svg class="side02__header__button-close__icon" width="13" height="15" viewBox="0 0 13 15" fill="none">
                <path d="M-3.71547e-07 7.5L12.75 0.138784L12.75 14.8612L-3.71547e-07 7.5Z" fill="#D9D9D9" />
            </svg>
        </button>


        {{-- <nav class="side02__header__languages">
            <a href="#" class="side02__header__languages__item">PT</a>
            <a href="#" class="side02__header__languages__item">EN</a>
        </nav> --}}
    </div>


    <img src="{{ asset('storage/' . $generalSetting->path_logo_header_light) }}" loading="lazy" class="side02__logo"
        alt="{{ env('APP_NAME') }}">


    <ul class="side02__navigation sideLinks">
        <li class="side02__navigation__item">
            <a href="{{ route('home') }}" class="side02__navigation__item__link">
                HOME
            </a>
        </li>

        @foreach ($listMenu as $module => $menu)
            <li class="side02__navigation__item {{ $menu->dropdown ? 'quedinha' : '' }}">

                @if (!$menu->dropdown)
                    <a href="{{ $menu->anchor ? route('home') . $menu->link : route($menu->link) }}"
                        target="{{ $menu->target_link ?? '_self' }}"
                        class="side02__navigation__item__link {{ !$menu->anchor ? isActive($menu->link) : '' }}">
                        {{ $menu->title }}
                    </a>
                @else
                    <button class=" side02__navigation__item__btn quedinha__btn">{{ $menu->title }}</button>
                @endif

                @if ($menu->dropdown)
                    <ul class="side02__navigation__item__content quedinha__content">
                        @foreach ($menu->dropdown as $item)
                            @if ($item->subList)
                                <li class="side02__navigation__item__content__item quedinha">
                                    <button href="{{ $item->route }}"
                                        class="side02__navigation__item__link quedinha__btn">{{ $item->name }}</button>

                                    <ul
                                        class="side02__navigation__item__content--sub-menu quedinha__content quedinha__content--sub-menu">
                                        @foreach ($item->subList as $subItem)
                                            <li class="side02__navigation__item">
                                                <a href="{{ $subItem->route }}"
                                                    class="side02__navigation__item__link">{{ $subItem->name }}</a>

                                            </li>
                                        @endforeach
                                        <li class="side02__navigation__item">
                                            <a href="{{ $item->route }}" class="side02__navigation__item__link">Ver
                                                todos</a>
                                        </li>
                                    </ul>

                                </li>
                            @else
                                <a href="{{ $item->route }}" target="{{ $item->target }}"
                                    class="side02__navigation__item__link">{{ $item->name }}</a>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>


    @if ($linksCtaHeader->count() > 0 && $callToActionTitle->active_header)
        <li class="side02__navigation__item  {{ $linksCtaHeader->count() > 1 ? 'quedinha' : '' }}">
            @if ($linksCtaHeader->count() > 1)

                <button class="side02__navigation__item__cta quedinha__btn">
                    {{ $callToActionTitle->title_header ?? '' }}
                </button>
                <ul class="side02__navigation__item__cta__content quedinha__content">
                    @foreach ($linksCtaHeader as $linkCtaHeader)
                        <li>
                            <a href="{{ getUri($linkCtaHeader->link) }}" target="{{ $linkCtaHeader->link_target }}"
                                class="side02__navigation__item__cta__content__item">{{ $linkCtaHeader->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                {{-- BACKEND: Inserir required no link - Verificar o script que reescreve o código do link, pois só está inserindo uma barra e não está inserindo o https:// --}}
                <a href="{{ getUri($linksCtaHeader[0]->link) }}" target="{{ $linksCtaHeader[0]->link_target }}"
                    class="side02__navigation__item__cta">{{ $linksCtaHeader[0]->title }}</a>

            @endif
        </li>

    @endif

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


</nav>
