<nav id="HEAD02" class="head02">

    <a href="{{ route('home') }}" class="head02__logo">
        <img src="{{ asset('storage/' . $generalSetting->path_logo_header_light) }}" alt="Logo do site"
            class="head02__logo__img">
    </a>


    <ul class="head02__navigation">
        <li class="head02__navigation__item">
            <a href="{{ route('home') }}" class="head02__navigation__item__link">Home</a>
        </li>

        @foreach ($listMenu as $module => $menu)
            <li class=" {{ $menu->dropdown ? 'quedinha' : '' }}">

                @if (!$menu->dropdown)
                    <a href="{{ $menu->anchor ? $menu->link : route($menu->link) }}"
                        target="{{ $menu->target_link ?? '_self' }}" {{-- {{ $menu->dropdown ? 'data-bs-toggle=dropdown' : '' }} --}} {{-- {{ $menu->anchor ? 'data-bs-toggle=jqueryanchor' : '' }} --}}
                        class=" {{ !$menu->anchor ? isActive($menu->link) : '' }}">
                        {{ $menu->title }}
                    </a>
                @else
                    <button class=" head02__navigation__item__link quedinha__btn ">Botao do dropdown</button>
                @endif
                @if ($menu->dropdown)
                    <div class="sublink--menu text-end dropdown-menu" aria-labelledby="sublink--menu">
                        @foreach ($menu->dropdown as $item)
                            @if ($item->subList)
                                <div class="mb-2 dropdown">
                                    <a href="{{ $item->route }}" data-bs-toggle="dropdown"
                                        class="sublink-item transition">{{ $item->name }} <i
                                            class="menu-arrow"></i></a>
                                    <div class="dropdown-menu">
                                        @foreach ($item->subList as $subItem)
                                            <a href="{{ $subItem->route }}"
                                                class="sublink-item transition">{{ $subItem->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $item->route }}" target="{{ $item->target }}"
                                    class="sublink-item transition">{{ $item->name }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </li>
        @endforeach

        @if ($linksCtaHeader->count() && $callToActionTitle->active_header ?? false)
            <div class="container-cta">
                <div class="dropdown">


                    @if ($linksCtaHeader->count() > 1)
                        <a href="javascript:void(0)" data-bs-toggle="dropdown" class="btn-cta transition">
                            {{ $callToActionTitle->title_header ?? '' }}
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="sublink--cta-right text-end dropdown-menu" aria-labelledby="sublink--cta-right">
                            @foreach ($linksCtaHeader as $linkCtaHeader)
                                <a href="{{ getUri($linkCtaHeader->link) }}"
                                    target="{{ $linkCtaHeader->link_target }}"
                                    class="sublink-item transition mb-2">{{ $linkCtaHeader->title }}</a>
                            @endforeach
                        </div>
                    @else
                        @foreach ($linksCtaHeader as $linkCtaHeader)
                            <a href="{{ getUri($linkCtaHeader->link) }}" target="{{ $linkCtaHeader->link_target }}"
                                class="btn-cta transition">{{ $linkCtaHeader->title }}</a>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif


        @if ($socials->count())
            <li class="">
                @foreach ($socials as $social)
                    <a href="{{ $social->link }}" class="social-link transition" title="{{ $social->title }}">
                        <img src="{{ asset('storage/' . $social->path_image_icon) }}" alt="{{ $social->title }}">
                    </a>
                @endforeach
            </li>
        @endif


        {{-- <li class="d-flex align-items-center link-translate">
                    <a href="#" class="btn-translate px-2" alt="{{__('Traduzir para Inglês')}}">EN</a>
                    <a href="#" class="btn-translate px-2 border-0" alt="{{__('Traduzir para Portugês')}}">PT</a>
                </li> --}}


        <div class="menu-sidebar-header">
            <div class="btn-menu-sidebar-header">
                <a href="#SIDE03" alt="{{ __('Abrir menu') }}" nofollow data-plugin="sidebar" data-sb-position="right"
                    class="d-flex align-items-center">
                    <div class="lines">
                        <i class="w-100 mb-2 mx-auto transition"></i>
                        <i class="w-100 mb-2 mx-auto transition"></i>
                        <i class="w-100 mb-0 mx-auto transition"></i>
                    </div>
                </a>
            </div>
        </div>

    </ul>


</nav>
