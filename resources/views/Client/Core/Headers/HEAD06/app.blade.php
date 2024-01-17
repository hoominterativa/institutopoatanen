
<header class="head06">
    <div class="head06__content">
        <nav class="head06__content__left">
            <div class="navbar navbar-expand-lg">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sobre <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Sobre 1</a></li>
                                <li><a class="dropdown-item" href="#">Sobre 2</a></li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">Sobre 3 <i class="menu-arrow"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Sobre 3.1</a></li>
                                        <li><a class="dropdown-item" href="#">Sobre 3.2</a></li>
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item" href="#">Sobre 4<i class="menu-arrow"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Sobre 4.1</a></li>
                                                <li><a class="dropdown-item" href="#">Sobre 4.2</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        {{-- END nav-item dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Produtos <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Produtos 1</a></li>
                                <li><a class="dropdown-item" href="#">Produtos 2</a></li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">Produtos 3 <i class="menu-arrow"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Produtos 3.1</a></li>
                                        <li><a class="dropdown-item" href="#">Produtos 3.2</a></li>
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item" href="#">Produtos 4<i class="menu-arrow"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Produtos 4.1</a></li>
                                                <li><a class="dropdown-item" href="#">Produtos 4.2</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        {{-- END nav-item dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Serviços <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Serviços 1</a></li>
                                <li><a class="dropdown-item" href="#">Serviços 2</a></li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">Serviços 3 <i class="menu-arrow"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Serviços 3.1</a></li>
                                        <li><a class="dropdown-item" href="#">Serviços 3.2</a></li>
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item" href="#">Serviços 4<i class="menu-arrow"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Serviços 4.1</a></li>
                                                <li><a class="dropdown-item" href="#">Serviços 4.2</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
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
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Blog <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/blog">Blog 1</a></li>
                                    <li><a class="dropdown-item" href="#/blog">Blog 2</a></li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="/blog">Blog 3 <i class="menu-arrow"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Blog 3.1</a></li>
                                            <li><a class="dropdown-item" href="#">Blog 3.2</a></li>
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-item" href="#">Blog 4<i class="menu-arrow"></i></a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Blog 4.1</a></li>
                                                    <li><a class="dropdown-item" href="#">Blog 4.2</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            {{-- END nav-item dropdown --}}
                            <li class="nav-item"><a class="nav-link" href="#">Contato</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            
            
            <div class="head06__content__right__encompass-cta">
                {{-- <div class="head06__content__right__encompass-cta__cta">
                    <a href="" class="head06__content__right__encompass-cta__cta__button">
                        CTA
                    </a>
                </div> --}}
                {{-- END Button --}}
                <div class="head06__content__right__encompass-cta__cta">
                    <div class="head06__content__right__encompass-cta__cta__dropdown dropdown">
                        <button class="dropdown-toggle head06__content__right__encompass-cta__cta__dropdown__dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        CTA
                        </button>
                        <ul class="dropdown-menu head06__content__right__encompass-cta__cta__dropdown__dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                {{-- END Dropdown --}}
            </div>

            {{-- END .btn-cta --}}
                <div class="head06__content__right__rede">
                    @for($i = 0; $i <= 2; $i++)
                        <a href="#" title="Rede Social">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="ícone rede social">
                        </a>
                    @endfor
                </div>
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
