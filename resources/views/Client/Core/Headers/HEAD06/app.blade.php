
<header class="head06">
    <div class="head06__content">
        <nav class="head06__content__left">
            <div class="navbar navbar-expand-lg">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                        {{-- Se desejar alterar a origem do elemento e a quantidade de itens em um array, você pode realizar essa operação utilizando a função array_slice.
                                Nessa função, o primeiro parâmetro representa o índice de início do elemento desejado, enquanto o segundo parâmetro indica a extensão (ou quantidade) de itens que você deseja extrair. --}}
                        @foreach (array_slice($listMenu, 0, 4) as $module => $menu)
                            <li class="nav-item dropdown" {{$menu->dropdown ? 'dropdown' : ''}}>
                                <a href="{{$menu->anchor?$menu->link:route($menu->link)}}" target="{{$menu->target_link ?? '_self'}}" {{$menu->dropdown?'data-bs-toggle=dropdown' : ''}} {{$menu->anchor ? 'data-bs-toggle=jqueryanchor' : ''}}
                                    class=" nav-link {{!$menu->anchor ? isActive($menu->link) : ''}}">
                                    {{$menu->title}}
                                    @if ($menu->dropdown)
                                        <i class="menu-arrow"></i>
                                    @endif
                                </a>
                                @if ($menu->dropdown)
                                    <ul class="dropdown-menu">
                                        @foreach ($menu->dropdown as $item)
                                            @if ($item->subList)
                                                <li class="dropdown-submenu">
                                                    <a href="{{$item->route}}" data-bs-toggle="dropdown" class="dropdown-item">{{$item->name}} <i class="menu-arrow"></i></a>
                                                    <ul class="dropdown-menu">
                                                        @foreach ($item->subList as $subItem)
                                                            <li>
                                                                <a href="{{$subItem->route}}" class="dropdown-item">{{$subItem->name}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li><a class="dropdown-item" href="{{$item->route}}">{{$item->name}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                        {{-- END nav-item dropdown --}}
                    </ul>
                </div>
            </div>
        </nav>
        <div class="head06__content__logo">
            <a href="{{route('home')}}">
                <img src="{{asset('storage/'.$generalSetting->path_logo_header_light)}}" alt="" width="202">
            </a>
        </div>
        <div class="head06__content__right">
            <div class="head06__content__right__menu">
                <nav class="navbar navbar-expand-lg">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                        <ul class="navbar-nav">
                            {{-- Se desejar alterar a origem do elemento e a quantidade de itens em um array, você pode realizar essa operação utilizando a função array_slice.
                                Nessa função, o primeiro parâmetro representa o índice de início do elemento desejado, enquanto o segundo parâmetro indica a extensão (ou quantidade) de itens que você deseja extrair. --}}
                            @foreach (array_slice($listMenu, 4, 4) as $module => $menu)
                            <li class="nav-item dropdown" {{$menu->dropdown ? 'dropdown' : ''}}>
                                <a href="{{$menu->anchor?$menu->link:route($menu->link)}}" target="{{$menu->target_link ?? '_self'}}" {{$menu->dropdown?'data-bs-toggle=dropdown' : ''}} {{$menu->anchor ? 'data-bs-toggle=jqueryanchor' : ''}}
                                    class=" nav-link {{!$menu->anchor ? isActive($menu->link) : ''}}">
                                    {{$menu->title}}
                                    @if ($menu->dropdown)
                                        <i class="menu-arrow"></i>
                                    @endif
                                </a>
                                @if ($menu->dropdown)
                                    <ul class="dropdown-menu">
                                        @foreach ($menu->dropdown as $item)
                                            @if ($item->subList)
                                                <li class="dropdown-submenu">
                                                    <a href="{{$item->route}}" data-bs-toggle="dropdown" class="dropdown-item">{{$item->name}} <i class="menu-arrow"></i></a>
                                                    <ul class="dropdown-menu">
                                                        @foreach ($item->subList as $subItem)
                                                            <li>
                                                                <a href="{{$subItem->route}}" class="dropdown-item">{{$subItem->name}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li><a class="dropdown-item" href="{{$item->route}}">{{$item->name}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="head06__content__right__encompass-cta">
                @if ($linksCtaHeader->count() && $callToActionTitle->active_header??false)
                    <div class="head06__content__right__encompass-cta__cta">
                        <div class="head06__content__right__encompass-cta__cta__dropdown dropdown">
                            @if ($linksCtaHeader->count()>1)
                                <button class="dropdown-toggle head06__content__right__encompass-cta__cta__dropdown__dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{$callToActionTitle->title_header ?? ''}}
                                    <i class="menu-arrow"></i>
                                </button>
                                <ul class="dropdown-menu head06__content__right__encompass-cta__cta__dropdown__dropdown-menu">
                                    @foreach ($linksCtaHeader as $linkCtaHeader)
                                        <li><a class="dropdown-item" href="{{getUri($linkCtaHeader->link)}}" target="{{$linkCtaHeader->link_target}}">{{$linkCtaHeader->title}}</a></li>
                                    @endforeach
                                </ul>
                            @else
                                @foreach ($linksCtaHeader as $linkCtaHeader)
                                    <div class="head06__content__right__encompass-cta__cta">
                                        <a href="{{getUri($linkCtaHeader->link)}}" target="{{$linkCtaHeader->link_target}}" class="head06__content__right__encompass-cta__cta__button">
                                            {{$linkCtaHeader->title}}
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
                {{-- END Dropdown --}}
            </div>
            {{-- END .btn-cta --}}
            @if ($socials->count())
                <div class="head06__content__right__rede">
                    @foreach ($socials as $social)
                        <a href="{{$social->link}}" target="_blank" title="{{$social->title}}">
                            <img src="{{asset('storage/'.$social->path_image_icon)}}" alt="{{$social->title}}">
                        </a>
                    @endforeach
                </div>
            @endif
            {{-- head06__content__right__rede --}}
            <div class="head06__content__right__btn-sidebar">
                <a href="#SIDE03" alt="{{__('Abrir menu')}}" nofollow data-plugin="sidebar" data-sb-position="right" class="d-flex align-items-center">
                    <div class="head06__content__right__btn-sidebar__lines">
                        <i class="w-100 mb-2 mx-auto transition"></i>
                        <i class="w-100 mb-2 mx-auto transition"></i>
                        <i class="w-100 mb-0 mx-auto transition"></i>
                    </div>
                </a>
            </div>
            {{-- END menu-sidebar-header --}}
        </div>
    </div>
</header>
{{-- END .btn-cta --}}
