<nav id="SIDE02" class="side02 burger__target">
    <div class="side02__header">
        <button title="botão fechar" class="side02__header__button-close burguer">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L21 21" stroke="#404040"/>
                <path d="M21 1L0.999999 21" stroke="#404040"/>
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
            <a title="HOME" href="{{ route('home') }}" class="side02__navigation__item__link">
                HOME
            </a>
        </li>

        @foreach ($listMenu as $module => $menu)
            <li class="side02__navigation__item {{ $menu->dropdown ? 'quedinha' : '' }}">

                @if (!$menu->dropdown)
                    <a title="{{ $menu->title }}"
                        href="{{ $menu->anchor ? route('home') . $menu->link : $menu->link }}"
                        target="{{ $menu->target_link ?? '_self' }}"
                        class="side02__navigation__item__link {{ !$menu->anchor ? isActive($menu->link) : 'rollAnimate' }}">
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
                                            <a title="Ver todos" href="{{ $item->route }}"
                                                class="side02__navigation__item__link">Ver
                                                todos</a>
                                        </li>
                                    </ul>

                                </li>
                            @else
                                <a title="{{ $item->name }}" href="{{ $item->route }}"
                                    target="{{ $item->target }}"
                                    class="side02__navigation__item__link">{{ $item->name }}</a>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>


    @if ($linksCtaHeader->count() > 0 && $callToActionTitle->active_header)
        <div class="side02__navigation__item  {{ $linksCtaHeader->count() > 1 ? 'quedinha' : '' }}">
            @if ($linksCtaHeader->count() > 1)

                <button class="side02__cta quedinha__btn">
                    {{ $callToActionTitle->title_header ?? '' }}
                </button>
                <ul class="side02__cta__content quedinha__content">
                    @foreach ($linksCtaHeader as $linkCtaHeader)
                        <li>
                            <a title="{{ $linkCtaHeader->title }}" href="{{ getUri($linkCtaHeader->link) }}"
                                target="{{ $linkCtaHeader->link_target }}"
                                class="side02__cta__content__item">{{ $linkCtaHeader->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                {{-- BACKEND: Inserir required no link - Verificar o script que reescreve o código do link, pois só está inserindo uma barra e não está inserindo o https:// --}}
                <a title="{{ $linksCtaHeader[0]->title }}" href="{{ getUri($linksCtaHeader[0]->link) }}"
                    target="{{ $linksCtaHeader[0]->link_target }}"
                    class="side02__cta">{{ $linksCtaHeader[0]->title }}</a>

            @endif
        </div>

    @endif

    @if ($socials->count())
        <div class="side02__socials">
            @foreach ($socials as $social)
                <a href="{{ $social->link }}" class="side02__socials__item" title="{{ $social->title }}">
                    <img class="side02__socials__item__icon" src="{{ asset('storage/' . $social->path_image_icon) }}"
                        loading="lazy" alt="{{ $social->title }}">
                </a>
            @endforeach
        </div>
    @endif

    @if ($linksCtaFooter->count())
        <div class="side02__footer">
            @foreach ($linksCtaFooter as $linkCtaHeader)
                <a  title="{{ $linkCtaHeader->title }}" class="side02__footer__item" title="{{ $linkCtaHeader->title }}" href="{{ $linkCtaHeader->link }}"
                    target="{{ $linkCtaHeader->link_target }}" rel="next">{{ $linkCtaHeader->title }}</a>
            @endforeach
        </div>
    @endif


</nav>
