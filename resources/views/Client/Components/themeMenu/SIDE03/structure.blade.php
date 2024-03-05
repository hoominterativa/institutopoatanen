<nav id="SIDE03" class="side03 burger__target">

    <button class="side03__button-close burguer">
        <svg class="side03__button-close__icon" width="13" height="15" viewBox="0 0 13 15" fill="none">
            <path d="M-3.71547e-07 7.5L12.75 0.138784L12.75 14.8612L-3.71547e-07 7.5Z" fill="#D9D9D9"></path>
        </svg>
    </button>

    <div class="side03__image">
        <img class="side03__image__img" src="{{ asset('storage/uploads/tmp/png-slide.png') }}" alt="Logo"
            loading="lazy" />
    </div>

    <ul class="side03__navigation">

        <img src="{{ asset('storage/' . $generalSetting->path_logo_header_light) }}" class="side03__navigation__logo"
            alt="{{ env('APP_NAME') }}" loading='lazy'>


        <li class="side03__navigation__item">
            <a href="{{ route('home') }}" class="side03__navigation__item__link transition"> HOME
            </a>
        </li>

        @foreach ($listMenu as $module => $menu)
            <li class="side03__navigation__item {{ $menu->dropdown ? 'quedinha' : '' }}">

                @if (!$menu->dropdown)
                    <a title="{{ $menu->title }}"
                        href="{{ $menu->anchor ? route('home') . $menu->link : route($menu->link) }}"
                        target="{{ $menu->target_link ?? '_self' }}"
                        class="side03__navigation__item__link {{ !$menu->anchor ? isActive($menu->link) : '' }}">
                        {{ $menu->title }}
                    </a>
                @else
                    <button class=" side03__navigation__item__btn quedinha__btn">{{ $menu->title }}</button>
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
                                            <li class="side03__navigation__item">
                                                <a href="{{ $subItem->route }}"
                                                    class="side03__navigation__item__link">{{ $subItem->name }}</a>

                                            </li>
                                        @endforeach
                                        <li class="side03__navigation__item">
                                            <a title="Ver todos" href="{{ $item->route }}"
                                                class="side03__navigation__item__link">Ver
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
            </li>
        @endforeach




        @if ($linksCtaHeader->count())
            <div class="dropdown side03__dropdown mx-auto">
                @if ($linksCtaHeader->count() > 1)
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ $callToActionTitle->title_header ?? '' }} <i class="menu-arrow"></i>
                    </button>
                    <ul class="dropdown-menu side03__dropdown__menu">
                        @foreach ($linksCtaHeader as $linkCtaHeader)
                            <li><a class="dropdown-item" href="{{ $linkCtaHeader->link }}"
                                    target="{{ $linkCtaHeader->link_target }}">{{ $linkCtaHeader->title }}</a></li>
                        @endforeach
                    </ul>
                @else
                    @foreach ($linksCtaHeader as $title => $linkCtaHeader)
                        <li><a class="dropdown-item" href="{{ $linkCtaHeader->link }}"
                                target="{{ $linkCtaHeader->link_target }}">{{ $linkCtaHeader->title }}</a></li>
                    @endforeach
                @endif
            </div>
        @endif


        @if ($socials->count())
            <nav class="side03__network d-flex align-items-center justify-content-center">
                @foreach ($socials as $social)
                    <a href="{{ $social->link }}" target="_blank" class="social-link transition"
                        title="{{ $social->title }}">
                        <img src="{{ asset('storage/' . $social->path_image_icon) }}" width="28.5px"
                            alt="{{ $social->title }}">
                    </a>
                @endforeach
            </nav>
        @endif

        <nav class="side03__privacy">
            @if (isset($linksCtaFooter))
                <ul class="d-flex align-items-center justify-content-center">
                    @foreach ($linksCtaFooter as $title => $linkCtaHeader)
                        <li><a href="{{ $linkCtaHeader->link }}"
                                target="{{ $linkCtaHeader->link_target }}">{{ $linkCtaHeader->title }}</a></li>
                    @endforeach
                </ul>
            @endif
        </nav>
    </ul>


</nav>
