<!-- INICIO HEADER NAVIGATION -->
<nav class="head05__navigation">
    <div class="container">
        <div class="head05__navigation__info__left">
            @for ($i = 0; $i < 2; $i++)
            <a class="head05__navigation__info__left__cta" href="mailto:{{ $generalSetting->email }}" target="_blank">
                CTA
                <img class="img" src="{{asset('images/icon.png')}}" alt="Imagem email">
                {{$generalSetting->email }}
            </a>
            @endfor

            @if ($generalSetting->email)
            <a class="head05__navigation__info__left__cta" href="mailto:{{ $generalSetting->email }}" target="_blank">
                <img class="img" src="{{asset('images/icon.png')}}" alt="Imagem email">
                {{$generalSetting->email }}
            </a>
            @endif
            @if ($generalSetting->phone)
            <a class="head05__navigation__info__left__cta" href="{{ $generalSetting->phone }}" target="_blank">
                <img class="img" src="{{asset('images/icon.png')}}" alt="Imagem Contato">
                {{$generalSetting->phone }}
            </a>
            @endif
            @if ($generalSetting->whatsapp)
            <a class="head05__navigation__info__left__cta" href="https://api.whatsapp.com/send?phone=55{{ Str::slug($generalSetting->whatsapp, '') }}" target="_blank">
                <img class="img" src="{{asset('images/icon.png')}}" alt="Imagem whatsapp">
                {{$generalSetting->whatsapp }}
            </a>
            @endif
        </div>
        @if ($socials -> count())
        <div class="head05__navigation__info__right">
            <ul class="head05__navigation__info__right__social">
                <h3 class="head05__navigation__info__right__social__titulo">Redes Sociais:</h3>
                @foreach ($socials as $social)
                <li class="head05__navigation__info__right__social__icon">
                    <a class="head05__navigation__info__right__social__cta" href="{{$social -> link}}"></a>
                    <img class="head05__navigation__info__right__social__img" src="{{asset('storage/'.$social -> path_image_icon)}}" alt="{{$social -> title}}">
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</nav>
<!-- FIM HEADER05-NAVIGATION -->


<div id="HEAD05" class="head05 container-fluid">

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
                            <a href="{{route('home')}}" class="link transition"><img class="img" src="{{asset('images/home.png')}}" alt="Imagem Home"></a>
                        </li>
                        @foreach ($listMenu as $module => $menu)
                            <li class="list-inline-item menu-item {{$menu->dropdown?'dropdown':''}}">
                                <a href="{{$menu->anchor?$menu->link:route($menu->link)}}" target="{{$menu->target_link??'_self'}}" {{$menu->dropdown?'data-bs-toggle=dropdown':''}} {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}} class="link transition {{!$menu->anchor?isActive($menu->link):''}}">
                                    {{$menu->title}}
                                    @if ($menu->dropdown)
                                    <i class="menu-arrow"></i>
                                    @endif
                                </a>
                                @if ($menu->dropdown)
                                    <div class="sublink--menu text-end dropdown-menu" aria-labelledby="sublink--menu">
                                        @foreach ($menu->dropdown as $item)
                                            @if ($item->subList)
                                                <div class="mb-2 dropdown">
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
                @if ($linksCtaHeader->count() && $callToActionTitle->active_header??false)
                <div class="container-cta">
                    <div class="dropdown">
                        @if ($linksCtaHeader->count()>1)
                        <a href="javascript:void(0)" data-bs-toggle="dropdown" class="btn-cta transition">
                            {{$callToActionTitle->title_header??''}}
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="sublink--cta-right text-end dropdown-menu" aria-labelledby="sublink--cta-right">
                            @foreach ($linksCtaHeader as $linkCtaHeader)
                            <a href="{{getUri($linkCtaHeader->link)}}" target="{{$linkCtaHeader->link_target}}" class="sublink-item transition mb-2">{{$linkCtaHeader->title}}</a>
                            @endforeach
                        </div>
                        @else
                        @foreach ($linksCtaHeader as $linkCtaHeader)
                        <a href="{{getUri($linkCtaHeader->link)}}" target="{{$linkCtaHeader->link_target}}" class="btn-cta transition">{{$linkCtaHeader->title}}</a>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endif
                {{-- END .btn-cta --}}

                @if ($socials->count())
                <nav class="social-network d-flex align-items-center mb-0">
                    @foreach ($socials as $social)
                    <a href="{{$social->link}}" class="social-link transition" title="{{$social->title}}">
                        <img src="{{asset('storage/'.$social->path_image_icon)}}" width="28.5px" alt="{{$social->title}}">
                    </a>
                    @endforeach
                </nav>
                @endif
                {{-- END .social-network --}}

                <nav class="d-flex align-items-center link-translate idioma">
                    <a href="#" class="btn-translate px-2" alt="{{__('Traduzir para Inglês')}}">EN</a>
                    <a href="#" class="btn-translate px-2 border-0" alt="{{__('Traduzir para Portugês')}}">PT</a>
                </nav>
                {{-- END .link-translate --}}

                <div class="menu-sidebar-header">
                    <div class="btn-menu-sidebar-header">
                        <a href="#SIDE03" alt="{{__('Abrir menu')}}" nofollow data-plugin="sidebar" data-sb-position="right" class="d-flex align-items-center">
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
{{-- END #HEAD05 --}}
