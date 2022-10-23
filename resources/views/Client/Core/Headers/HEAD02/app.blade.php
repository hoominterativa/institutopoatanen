<div id="HEAD02" class="container-fluid">
    <div class="container">
        <div class="container-header d-flex align-items-center justify-content-between">
            <div id="logoHeader">
                <a href="{{route('home')}}">
                    <img src="{{asset('storage/'.$generalSetting->path_logo_header_light)}}" alt="" width="202px" sizes="(max-width: 700px) 165px">
                </a>
            </div>
            <nav class="container-navigation d-flex align-items-center">
                <ul class="menu-list list-inline mb-0">
                    <li class="list-inline-item menu-item dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="link transition">Home <i class="menu-arrow"></i></a>
                        <div class="sublink--menu text-end dropdown-menu" aria-labelledby="sublink--menu" >
                            <a href="#" class="sublink-item transition">Sublink 1</a>
                            <a href="#" class="sublink-item transition">Sublink 2</a>
                            <a href="#" class="sublink-item transition">Sublink 3</a>
                            <a href="#" class="sublink-item transition">Sublink 4</a>
                        </div>
                    </li>
                    <li class="list-inline-item menu-item dropdown">
                        <a href="#" class="link transition">Sobre</a>
                    </li>
                    <li class="list-inline-item menu-item dropdown">
                        <a href="#" class="link transition">Produtos</a>
                    </li>
                    <li class="list-inline-item menu-item dropdown">
                        <a href="#" class="link transition">Serviços</a>
                    </li>
                    <li class="list-inline-item menu-item dropdown">
                        <a href="#" class="link transition">Blogs</a>
                    </li>
                    <li class="list-inline-item menu-item dropdown">
                        <a href="#" class="link transition">Contatos</a>
                    </li>
                </ul>
                {{-- END .menu-list --}}

                @if ($linksCtaHeader)
                    <div class="container-cta">
                        @if ($linksCtaHeader->count() > 1)
                            <div class="dropdown">
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" class="btn-cta transition">{{$linksCtaHeader['title']??''}} <i class="menu-arrow"></i></a>
                                <div class="sublink--cta-right text-end dropdown-menu" aria-labelledby="sublink--cta-right" >
                                    @foreach ($linksCtaHeader as $title => $linkCtaHeader)
                                        @if ($title <> 'title')
                                            @if ($linkCtaHeader[1] == '_lightbox')
                                                <a href="{{$linkCtaHeader[0]}}" data-fancybox="" class="sublink-item transition mb-2">{{$title}}</a>
                                            @else
                                                <a href="{{$linkCtaHeader[0]}}" target="{{$linkCtaHeader[1]}}" class="sublink-item transition mb-2">{{$title}}</a>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            @foreach ($linksCtaHeader as $title => $linkCtaHeader)
                                @if ($title <> 'title')
                                    @if ($linkCtaHeader[1] == '_lightbox')
                                        <a href="{{$linkCtaHeader[0]}}" data-fancybox="" class="btn-cta transition">{{$title}}</a>
                                    @else
                                        <a href="{{$linkCtaHeader[0]}}" target="{{$linkCtaHeader[1]}}" class="btn-cta transition">{{$title}}</a>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endif
                {{-- END .btn-cta --}}
                @if ($socials->count())
                    <div class="social-network d-flex align-items-center mb-0">
                        @foreach ($socials as $social)
                            <a href="{{$social->link}}" class="social-link transition" title="{{$social->title}}"><i class="mdi {{$social->icon}}"></i></a>
                        @endforeach
                    </div>
                @endif

                <div class="d-flex align-items-center link-translate">
                    <a href="#" class="btn-translate px-2" alt="{{__('Traduzir para Inglês')}}">EN</a>
                    <a href="#" class="btn-translate px-2 border-0" alt="{{__('Traduzir para Portugês')}}">PT</a>
                </div>
                {{-- END .link-translate --}}
            </nav>
        </div>

    </div>
</div>

@foreach ($listMenu as $module => $menu)

    <div class="mb-2 {{$menu->dropdown?'dropdown':''}}">
        <a href="{{$menu->anchor?$menu->link:route($menu->link)}}"
            class="link-item transition {{!$menu->anchor?isActive($menu->link):''}}"
            {{$menu->dropdown?'data-bs-toggle=dropdown':''}}
            {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}}
            id="sublink--sidebar-right">{{$menu->title}}</a>

        @if ($menu->dropdown)
            <div class="sublink--sidebar-right text-end dropdown-menu" aria-labelledby="sublink--sidebar-right" >
                @foreach ($menu->dropdown as $item)
                    <a href="{{$item->route}}" class="sublink-item transition">{{$item->name}}</a>
                    <!-- if exist sublist -->
                    @foreach ($item->subList as $subItem)
                        <a href="{{$subItem->route}}" class="sublink-item transition">{{$subItem->name}}</a>
                    @endforeach
                @endforeach
            </div>
        @endif
    </div>
@endforeach
