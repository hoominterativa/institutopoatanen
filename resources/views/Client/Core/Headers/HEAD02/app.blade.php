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
            <li class="head02__navigation__item {{ $menu->dropdown ? 'quedinha' : '' }}">

                @if (!$menu->dropdown)
                    <a href="{{ $menu->anchor ? $menu->link : route($menu->link) }}"
                        target="{{ $menu->target_link ?? '_self' }}"
                        class=" {{ !$menu->anchor ? isActive($menu->link) : '' }}">
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
            <li class="head02__navigation__item  {{$linksCtaHeader->count() > 1 ? 'quedinha' : ''}}">
                @if ($linksCtaHeader->count() > 1)
                {{-- NEXT: AJEITAR CLASSES DO CTA  --}}
                    <button class="head02__navigation__item__cta quedinha__btn">
                        {{ $callToActionTitle->title_header ?? '' }}
                    </button>
                    <ul class="quedinha__content" >
                        @foreach ($linksCtaHeader as $linkCtaHeader)
                        <li>
                            <a href="{{ getUri($linkCtaHeader->link) }}" target="{{ $linkCtaHeader->link_target }}"
                                class="">{{ $linkCtaHeader->title }}</a>
                        </li>
                        @endforeach
                    </ul>
                @else
                    {{-- BACKEND: EXISTE MOTIVO PARA ALGUM MOTIVO UTILIZAR O FOR EACH?  --}}
                    {{-- {{$linksCtaHeader[0]}} --}}
                    {{-- @foreach ($linksCtaHeader as $linkCtaHeader) --}}
                    <a href="{{ getUri($linksCtaHeader[0]->link) }}" target="{{ $linksCtaHeader[0]->link_target }}"
                        class="head02__navigation__item__link">{{ $linksCtaHeader[0]->title }}</a>
                    {{-- @endforeach --}}
                @endif
            </li>

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
                {{-- vai ser alterado para um botão --}}
                <a href="#SIDE03" alt="{{ __('Abrir menu') }}" rel="nofollow" data-plugin="sidebar"
                    data-sb-position="right" class="d-flex align-items-center">
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
