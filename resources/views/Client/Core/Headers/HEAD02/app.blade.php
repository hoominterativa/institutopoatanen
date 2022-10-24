<div id="HEAD02" class="container-fluid">
    <div class="container">
        <div class="container-header d-flex align-items-center justify-content-between">
            <div id="logoHeader">
                <a href="{{route('home')}}">
                    <img src="{{asset('storage/'.$generalSetting->path_logo_header_light)}}" alt="" width="202">
                </a>
            </div>
            {{-- END #logoHeader --}}
            <div class="container-navigation d-flex align-items-center">
                <nav>
                    <ul class="menu-list list-inline mb-0">
                        <li class="list-inline-item menu-item dropdown">
                            <a href="#" class="link transition">Home</a>
                        </li>
                        @foreach ($listMenu as $module => $menu)
                            <li class="list-inline-item menu-item {{$menu->dropdown?'dropdown':''}}">
                                <a href="{{$menu->anchor?$menu->link:route($menu->link)}}" {{$menu->dropdown?'data-bs-toggle=dropdown':''}} {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}} class="link transition {{!$menu->anchor?isActive($menu->link):''}}">
                                    {{$menu->title}}
                                    @if ($menu->dropdown)
                                        <i class="menu-arrow"></i>
                                    @endif
                                </a>
                                @if ($menu->dropdown)
                                    <div class="sublink--menu text-end dropdown-menu" aria-labelledby="sublink--menu" >
                                        @foreach ($menu->dropdown as $item)
                                            @if ($item->subList)
                                                <div class="mb-2 {{$menu->dropdown?'dropdown':''}}">
                                                    <a href="{{$item->route}}" data-bs-toggle="dropdown" class="sublink-item transition">{{$item->name}} <i class="menu-arrow"></i></a>
                                                    <div class="dropdown-menu">
                                                        @foreach ($item->subList as $subItem)
                                                            <a href="{{$subItem->route}}" class="sublink-item transition">{{$subItem->name}}</a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <a href="{{$item->route}}" class="sublink-item transition">{{$item->name}}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>
                {{-- END .menu-list --}}
                @if ($linksCtaHeader->count())
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
                    <nav class="social-network d-flex align-items-center mb-0">
                        @foreach ($socials as $social)
                            <a href="{{$social->link}}" class="social-link transition" title="{{$social->title}}"><i class="mdi {{$social->icon}}"></i></a>
                        @endforeach
                    </nav>
                @endif
                {{-- END .social-network --}}

                <nav class="d-flex align-items-center link-translate">
                    <a href="#" class="btn-translate px-2" alt="{{__('Traduzir para Inglês')}}">EN</a>
                    <a href="#" class="btn-translate px-2 border-0" alt="{{__('Traduzir para Portugês')}}">PT</a>
                </nav>
                {{-- END .link-translate --}}

                <div class="menu-sidebar-header">
                    <div class="btn-menu-sidebar-header">
                        <a href="#menu02--sidebar-right" alt="{{__('Abrir menu')}}" nofollow data-plugin="sidebar" data-sb-position="right" class="d-flex align-items-center">
                            <div class="lines">
                                <i class="w-100 mb-2 mx-auto transition"></i>
                                <i class="w-100 mb-2 mx-auto transition"></i>
                                <i class="w-100 mb-0 mx-auto transition"></i>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- END menu-sidebar-header --}}
            </div>

        </div>
        {{-- END .container-header --}}
    </div>
    {{-- END .container --}}
</div>
{{-- END #HEAD02 --}}
