<nav id="HEAD02" class="head02">

    <a href="{{ route('home') }}" class="head02__logo">
        <img src="{{ asset('storage/' . $generalSetting->path_logo_header_light) }}" alt="Logo do site" loading="lazy"
            class="head02__logo__img">
    </a>


    <ul class="head02__navigation">
        <li class="head02__navigation__item">
            <a href="{{ route('home') }}" class="head02__navigation__item__link">Home</a>
        </li>

        @foreach ($listMenu as $module => $menu)
            <li class="head02__navigation__item {{ $menu->dropdown ? 'quedinha' : '' }}">

                @if (!$menu->dropdown)
                    <a href="{{ $menu->anchor ? route('home') . $menu->link : route($menu->link) }}"
                        target="{{ $menu->target_link ?? '_self' }}"
                        class="head02__navigation__item__link {{ !$menu->anchor ? isActive($menu->link) : '' }}">
                        {{ $menu->title }}
                    </a>
                @else
                    <button class=" head02__navigation__item__btn quedinha__btn">{{ $menu->title }}</button>
                @endif

                @if ($menu->dropdown)
                    <ul class="head02__navigation__item__content quedinha__content">
                        @foreach ($menu->dropdown as $item)
                            @if ($item->subList)
                                <li class="head02__navigation__item__content__item quedinha">
                                    <button href="{{ $item->route }}"
                                        class="head02__navigation__item__link quedinha__btn">{{ $item->name }}</button>

                                    <ul class="quedinha__content quedinha__content--sub-menu">
                                        @foreach ($item->subList as $subItem)
                                            <li class="head02__navigation__item">
                                                <a href="{{ $subItem->route }}"
                                                    class="head02__navigation__item__link">{{ $subItem->name }}</a>

                                            </li>
                                        @endforeach
                                        <li class="head02__navigation__item">
                                            <a href="{{ $item->route }}" class="head02__navigation__item__link">Ver
                                                todos</a>
                                        </li>
                                    </ul>

                                </li>
                            @else
                                <a href="{{ $item->route }}" target="{{ $item->target }}"
                                    class="head02__navigation__item__link">{{ $item->name }}</a>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach

        @if ($linksCtaHeader->count() > 0 && $callToActionTitle->active_header)
            <li class="head02__navigation__item  {{ $linksCtaHeader->count() > 1 ? 'quedinha' : '' }}">
                @if ($linksCtaHeader->count() > 1)

                    <button class="head02__navigation__item__cta quedinha__btn">
                        {{ $callToActionTitle->title_header ?? '' }}
                    </button>
                    <ul class="head02__navigation__item__cta__content quedinha__content">
                        @foreach ($linksCtaHeader as $linkCtaHeader)
                            <li>
                                <a href="{{ getUri($linkCtaHeader->link) }}"
                                    target="{{ $linkCtaHeader->link_target }}"
                                    class="head02__navigation__item__cta__content__item">{{ $linkCtaHeader->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{-- BACKEND: Inserir required no link --}}
                    <a href="{{ getUri($linksCtaHeader[0]->link) }}" target="{{ $linksCtaHeader[0]->link_target }}"
                        class="head02__navigation__item__cta">{{ $linksCtaHeader[0]->title }}</a>

                @endif
            </li>

        @endif


        @if ($socials->count())
            <li class="head02__navigation__item--socials">
                @foreach ($socials as $social)
                    <a href="{{ $social->link }}" class="head02__navigation__item--socials__item"
                        title="{{ $social->title }}">
                        <img loading="lazy" src="{{ asset('storage/' . $social->path_image_icon) }}"
                            alt="{{ $social->title }}" class="head02__navigation__item--socials__item__icon">
                    </a>
                @endforeach
            </li>
        @endif

        {{-- IDIOMAS --}}
        {{-- <li class="head02__navigation__item--languages">
            <a href="#" class="head02__navigation__item--languages__item"
                alt="{{ __('Traduzir para Inglês') }}">EN</a>

            <a href="#" class="head02__navigation__item--languages__item"
                alt="{{ __('Traduzir para Portugês') }}">PT</a>
        </li> --}}

        <li class="head02__navigation__item--menu-mobile">
            <button class="head02__navigation__item--menu-mobile__item burguer">
                {{-- Menu --}}
                <div class="head02__navigation__item--menu-mobile__item__icon burguer__icon dots">
                </div>
            </button>
        </li>

    </ul>


</nav>
