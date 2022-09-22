<div id="menu01--sidebar-right" class="main--sidebar-right container-fluid px-5 hidden">
    <div class="row justify-content-end align-items-center h-100">
        <div class="col-12 col-lg-8 h-100">
            <img src="{{asset('images/logo-menu-sidebar.svg')}}" class="h-100 w-100 object-fit-contain" alt="{{__('Name Image')}}">
        </div>
        <div class="col-12 col-lg-4 d-flex flex-direction-column align-items-center justify-content-end">
            <div class="content--sidebar-right scroll-y">
                <div class="header--sidebar-right row align-items-center justify-content-end mb-4 ms-auto">
                    <div class="traslate col-12 col-lg-8">
                        <a href="#" class="btn-translate transition px-2" alt="{{__('Traduzir para Inglês')}}">EN</a>
                        <a href="#" class="btn-translate transition px-2 border-0" alt="{{__('Traduzir para Portugês')}}">PT</a>
                    </div>
                    <button type="button" class="button---close--sidebar-right col-12 col-lg-4 text-end transition">X</button>
                </div>
                <nav class="list-link--sidebar-right">
                    <div class="mb-2">
                        <a href="{{route('home')}}" class="link-item transition">Início</a>
                    </div>
                    @foreach ($listMenu as $module => $menus)
                        @foreach ($menus as $model => $menu)
                            @if ($menu->ViewListMenu)
                                <div class="mb-2 {{$menu->IncludeCore[0]?'dropdown':''}}">
                                    <a href="{{$menu->config->anchor?$menu->config->linkMenu:route($menu->config->linkMenu)}}"
                                        class="link-item transition {{!$menu->config->anchor?isActive($menu->config->linkMenu):''}}"
                                        {{$menu->IncludeCore[0]?'data-bs-toggle=dropdown':''}}
                                        {{$menu->config->anchor?'data-bs-toggle=jqueryanchor':''}}
                                        id="sublink--sidebar-right">{{$menu->config->titleMenu}}</a>

                                    @if ($menu->IncludeCore[0])
                                        <div class="sublink--sidebar-right text-end dropdown-menu" aria-labelledby="sublink--sidebar-right" >
                                            @foreach ($menu->subItems as $item)
                                                <div class="mb-2">
                                                    <a href="{{route(Str::lower($model).'.show', [$model.$module => $item->id])}}" class="sublink-item transition">{{$item->title}}</a>
                                                </div>
                                            @endforeach
                                            <div class="mb-2">
                                                <a href="#" class="sublink-item transition">Criação</a>
                                            </div>
                                            <div class="mb-2">
                                                <a href="#" class="sublink-item transition">Marketing</a>
                                            </div>
                                            <div class="mb-2">
                                                <a href="#" class="sublink-item transition">Sistemas</a>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </nav>
                <div class="social-network d-flex">
                    @foreach ($socials as $social)
                        <a href="{{$social->link}}" class="social-link transition" title="{{$social->title}}"><i class="mdi {{$social->icon}}"></i></a>
                    @endforeach
                </div>
                <div class="cta--sidebar-right ms-auto d-table mt-5">
                    <a href="#" class="btn-cta py-1 px-3 transition">Solicitar um Orçamento</a>
                </div>
            </div>
        </div>
    </div>
</div>
