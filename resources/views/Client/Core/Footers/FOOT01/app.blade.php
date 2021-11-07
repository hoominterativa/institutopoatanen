<section id="footer-bar" class="container-fluid pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="logo-footer-bar col-12 col-lg-2">
                <img src="{{url('storage/'.$generalSetting->path_logo_footer_dark)}}" height="60" alt="">
            </div>
            {{-- end .logo-footer-bar --}}
            <div class="social-footer-bar col-12 col-lg-3 ps-5">
                <h3 class="title-footer-bar mb-3">SOCIAL MEDIA</h3>
                <nav class="social-footer-bar d-flex">
                    @foreach ($socials as $social)
                        <a href="{{$social->link}}" target="_blank" class="mdi {{$social->icon}} mx-2 font-24 text-primary" title="{{$social->title}}"></a>
                    @endforeach
                </nav>
            </div>
            {{-- end .social-footer-bar --}}
            <nav class="sitemap-footer-bar col-12 col-lg-4 pe-5">
                <div class="border-sitemap-footer-bar h-100">
                    <h3 class="title-footer-bar mb-3">SITEMAP</h3>
                    <ul class="list-inline row">
                        @foreach ($listMenu as $module => $menus)
                            @foreach ($menus as $model => $menu)
                                @if ($menu->ViewListMenu)
                                    <li class="col-12 col-lg-6 ps-2">
                                        <a href="{{$menu->config->anchor?$menu->config->linkMenu:route($menu->config->linkMenu)}}" class="nav-link px-2 py-0" {{$menu->IncludeCore[0]?'data-toggle="dropdow"':''}} {{!$menu->config->anchor?isActive($menu->config->linkMenu):''}} {{$menu->config->anchor?'data-toggle="jqueryanchor"':''}}>{{$menu->config->titleMenu}}</a>
                                    </li>
                                    <li class="col-12 col-lg-6 ps-2">
                                        <a href="{{$menu->config->anchor?$menu->config->linkMenu:route($menu->config->linkMenu)}}" class="nav-link px-2 py-0" {{$menu->IncludeCore[0]?'data-toggle="dropdow"':''}} {{!$menu->config->anchor?isActive($menu->config->linkMenu):''}} {{$menu->config->anchor?'data-toggle="jqueryanchor"':''}}>{{$menu->config->titleMenu}}</a>
                                    </li>
                                    <li class="col-12 col-lg-6 ps-2">
                                        <a href="{{$menu->config->anchor?$menu->config->linkMenu:route($menu->config->linkMenu)}}" class="nav-link px-2 py-0" {{$menu->IncludeCore[0]?'data-toggle="dropdow"':''}} {{!$menu->config->anchor?isActive($menu->config->linkMenu):''}} {{$menu->config->anchor?'data-toggle="jqueryanchor"':''}}>{{$menu->config->titleMenu}}</a>
                                    </li>
                                    <li class="col-12 col-lg-6 ps-2">
                                        <a href="{{$menu->config->anchor?$menu->config->linkMenu:route($menu->config->linkMenu)}}" class="nav-link px-2 py-0" {{$menu->IncludeCore[0]?'data-toggle="dropdow"':''}} {{!$menu->config->anchor?isActive($menu->config->linkMenu):''}} {{$menu->config->anchor?'data-toggle="jqueryanchor"':''}}>{{$menu->config->titleMenu}}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </nav>
            {{-- end .sitemap-footer-bar --}}
            <div class="contact-footer-bar col-12 col-lg-3">
                <h3 class="title-footer-bar mb-3">AJUDA</h3>
                <h4 class="phone">{{$generalSetting->phone}}</h4>
                <p>{{$generalSetting->address}}</p>
            </div>
            {{-- end .contact-footer-bar --}}
        </div>
    </div>
</section>
<div id="credits-footer-bar" class="w-100 py-3">
    <div class="container">
        <div class="d-flex">
            <p class="me-auto mb-0">© 2021 {{Config::get('app.name')}}. Todos os direitos reservados.</p>
            <a href="http://hoom.com.br" rel="nofollow" target="_blank" class="ms-auto"><img src="https://hoom.com.br/logo-lead-sites/hoom-logo-footer.svg" height="28" alt="Hoom interativa"></a>
        </div>
    </div>
</div>


