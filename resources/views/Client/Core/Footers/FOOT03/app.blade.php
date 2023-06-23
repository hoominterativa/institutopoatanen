<div class="foot03 container-fluid px-0 position-relative" style="background-color:#EFEFEF;" >
    <a id ="btn-comeBack" class="btn-comeBack">
        <img src="{{asset('storage/uploads/tmp/seta.png')}}" alt="Seta">
    </a>
    <div class="container container--pd px-0">
        <div class="row row--pd align-items-center">
            <div class="foot03__top px-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-nv">
                        <div class="foot03__top__telefone px-0">
                            @if ($generalSetting->phone)
                                <a href="tel:{{$generalSetting->phone}}" rel="next">
                                    <img src="{{asset('storage/uploads/tmp/icon-gray.png')}}" alt="#">
                                    {{$generalSetting->phone}}
                                </a>
                            @endif
                        </div>
                        <div class="foot03__top__telefone px-0">
                            @if ($generalSetting->whatsapp)
                                <a href="https://api.whatsapp.com/send?phone=55{{Str::slug($generalSetting->whatsapp,'')}}" rel="next">
                                    <img src="{{asset('storage/uploads/tmp/icon-gray.png')}}" alt="#">
                                    {{$generalSetting->whatsapp}}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="foot03__top__logo">
                        <a href="{{route('home')}}" rel="next">
                            <img src="{{asset('storage/'.$generalSetting->path_logo_footer_light??$generalSetting->path_logo_footer_dark)}}" class="w-100 h-100" alt="{{env('APP_NAME')}}">
                        </a>
                    </div>

                    <div class="foot03__top__redeSocial d-flex justify-content-between align-items-center">
                        @foreach ($socials as $social)
                            <a href="{{$social->link}}" class="social-link transition" title="{{$social->title}}">
                                <img src="{{asset('storage/'.$social->path_image_icon)}}" width="28.5px" alt="{{$social->title}}">
                                {{$social->title}}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="teste" class="foot03__bottom d-flex px-0">
                <div class=" d-flex justify-content-between  col footer-divider row mx-auto px-">
                    <div class="foot03__bottom__boxLeft col-sm-6 px-0 d-flex">
                        <nav class="foot03__bottom__boxLeft__nav col px-0 mx-0">
                            <h4 class="foot03__bottom__boxLeft__nav__title">Início</h4>
                            <ul class="px-0 mb-0">
                                <li><a href="{{route('home')}}" class="{{isActive('home')}}" rel="next">Home</a></li>
                                @foreach ($listMenu as $module => $menu)
                                    <li><a href="{{$menu->anchor?$menu->link:route($menu->link)}}" class="{{!$menu->anchor?isActive($menu->link):''}}" rel="next" {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}}>{{$menu->title}}</a></li>
                                @endforeach
                            </ul>
                        </nav>

                        @foreach ($listModelFooter as $menuFooter)
                            <nav class="foot03__bottom__boxLeft__nav col px-0 mx-0">
                                <h4 class="foot03__bottom__boxLeft__nav__title"><a href="{{route($menuFooter->link)}}">{{$menuFooter->title}}</a></h4>
                                <ul class="px-0 mb-0">
                                    @if ($menuFooter->dropdown)
                                        @foreach ($menuFooter->dropdown as $item)
                                            <li><a href="{{$item->route}}" class="{{isActive($item->route)}}" rel="next">{{$item->name}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </nav>
                        @endforeach

                    </div>
                    <div class="foot03__bottom__boxRight col-sm-4  d-flex px-0 mx-0">
                        <nav class="foot03__bottom__boxRight__nav col px-0">
                            <h4 class="foot03__bottom__boxRight__nav__title">Unidades</h4>
                            <ul class="px-0 mb-0">
                                <li>
                                    <a href="#" rel="next" class="d-flex align-items-center">
                                        <div class="icone">
                                            <img src="{{asset('storage/uploads/tmp/icon-gray.png')}}" alt="">
                                        </div>
                                        <div class="description">
                                            <h4 class="title">Unidade</h4>
                                            <span>Localização</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <nav class="foot03__bottom__boxRight__nav col-auto   px-0">
                            <h4 class="foot03__bottom__boxRight__nav__title">Funcionamento</h4>
                            <ul class="mb-0">
                                <li>
                                    <a href="#" rel="next" class="d-flex align-items-center">
                                        <div class="icone">
                                            <img src="{{asset('storage/uploads/tmp/icon-gray.png')}}" alt="">
                                        </div>
                                        <div class="description">
                                            <h4 class="title">Unidade</h4>
                                            <span>Localização</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="foot03__credits d-flex justify-content-between align-items-center px-0">
        <div class="container px-0">
            <div class="row row--mobile">
                <div class="d-flex justify-content-between w-100 px-0 foot03__credits__content">
                    <nav class="foot03__credits__nav d-flex align-items-center">
                        <ul class="d-flex align-items-center justify-content-between px-0 mb-0">
                            @if ($linksCtaFooter->count())
                                @foreach ($linksCtaFooter as $linkCtaHeader)
                                    <li><a href="{{$linkCtaHeader->link}}" target="{{$linkCtaHeader->link_target}}" rel="next">{{$linkCtaHeader->title}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </nav>
                    <div class="foot03__credits__logo">
                        <a href="#" rel="next">
                            <img src="{{asset('storage/uploads/tmp/logo_dark.png')}}" class="w-100 h-100" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
