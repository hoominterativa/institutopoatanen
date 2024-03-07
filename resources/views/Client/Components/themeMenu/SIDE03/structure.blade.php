<nav id="SIDE03" class="side03 burger__target">

    <button class="side03__button-close burguer">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L21 21" stroke="#404040"/>
            <path d="M21 1L0.999999 21" stroke="#404040"/>
            </svg>
    </button>

    <div class="side03__image">
        <img class="side03__image__img" src="{{ asset('storage/uploads/tmp/png-slide.png') }}" alt="Logo"
            loading="lazy" />
    </div>

    <div class="side03__navigation">

        <img src="{{ asset('storage/' . $generalSetting->path_logo_header_light) }}" class="side03__navigation__logo"
            alt="{{ env('APP_NAME') }}" loading='lazy'>


        <div class="side03__navigation__item">
            <a title="HOME" href="{{ route('home') }}" class="side03__navigation__item__link transition">HOME
            </a>
        </div>

        @foreach ($listMenu as $module => $menu)
            <div class="side03__navigation__item {{ $menu->dropdown ? 'quedinha' : '' }}">

                @if (!$menu->dropdown)
                    <a title="{{ $menu->title }}"
                        href="{{ $menu->anchor ? route('home') . $menu->link : route($menu->link) }}"
                        target="{{ $menu->target_link ?? '_self' }}"
                        class="side03__navigation__item__link {{ !$menu->anchor ? isActive($menu->link) : '' }}">
                        {{ $menu->title }}
                    </a>
                @else
                    <button class="side03__navigation__item__btn quedinha__btn">{{ $menu->title }}</button>
                @endif

                @if ($menu->dropdown)
                    <ul class="side03__navigation__item__content quedinha__content">
                        @foreach ($menu->dropdown as $item)
                            @if ($item->subList)
                                <li class="side03__navigation__item__content__item quedinha">
                                    <button href="{{ $item->route }}"
                                        class="side03__navigation__item__link quedinha__btn">{{ $item->name }}</button>

                                    <ul
                                        class="side03__navigation__item__content--sub-menu quedinha__content quedinha__content--sub-menu">
                                        @foreach ($item->subList as $subItem)
                                            <li class="side03__navigation__item__content--sub-menu__item">
                                                <a href="{{ $subItem->route }}" title="{{ $subItem->name }}"
                                                    class="side03__navigation__item__content--sub-menu__item__link">{{ $subItem->name }}</a>

                                            </li>
                                        @endforeach
                                        <li class="side03__navigation__item__content--sub-menu__item">
                                            <a title="Ver todos" href="{{ $item->route }}"
                                                class="side03__navigation__item__content--sub-menu__item__link">Ver
                                                todos</a>
                                        </li>
                                    </ul>

                                </li>
                            @else
                                <a title="{{ $item->name }}" href="{{ $item->route }}"
                                    target="{{ $item->target }}"
                                    class="side03__navigation__item__link">{{ $item->name }}</a>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach

        @if ($linksCtaHeader->count() > 0 && $callToActionTitle->active_header)
            <div class="side02__navigation__item  {{ $linksCtaHeader->count() > 1 ? 'quedinha' : '' }}">
                @if ($linksCtaHeader->count() > 1)

                    <button class="side03__navigation__cta quedinha__btn">
                        {{ $callToActionTitle->title_header ?? '' }}
                    </button>
                    <ul class="side03__navigation__cta__content quedinha__content">
                        @foreach ($linksCtaHeader as $linkCtaHeader)
                            <li>
                                <a title="{{ $linkCtaHeader->title }}" href="{{ getUri($linkCtaHeader->link) }}"
                                    target="{{ $linkCtaHeader->link_target }}"
                                    class="side03__navigation__cta__content__item">{{ $linkCtaHeader->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{-- BACKEND: Inserir required no link - Verificar o script que reescreve o código do link, pois só está inserindo uma barra e não está inserindo o https:// --}}
                    <a title="{{ $linksCtaHeader[0]->title }}" href="{{ getUri($linksCtaHeader[0]->link) }}"
                        target="{{ $linksCtaHeader[0]->link_target }}"
                        class="side03__navigation__cta">{{ $linksCtaHeader[0]->title }}</a>

                @endif
            </div>

        @endif


        @if ($socials->count())
            <div class="side03__navigation__socials">
                @foreach ($socials as $social)
                    <a href="{{ $social->link }}" class="side03__navigation__socials__item"
                        title="{{ $social->title }}">
                        <img class="side03__navigation__socials__item__icon"
                            src="{{ asset('storage/' . $social->path_image_icon) }}" loading="lazy"
                            alt="{{ $social->title }}">
                    </a>
                @endforeach
            </div>
        @endif

        @if ($linksCtaFooter->count())
            <div class="side03__navigation__footer">
                @foreach ($linksCtaFooter as $linkCtaHeader)
                    <a title="{{ $linkCtaHeader->title }}" class="side03__navigation__footer__item"
                        title="{{ $linkCtaHeader->title }}" href="{{ $linkCtaHeader->link }}"
                        target="{{ $linkCtaHeader->link_target }}" rel="next">{{ $linkCtaHeader->title }}</a>
                @endforeach
            </div>
        @endif

    </div>


</nav>
