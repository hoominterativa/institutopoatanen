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
                    @foreach ($listMenu as $menu)
                        <div class="mb-2 {{$menu->dropdown?'dropdown':''}}">
                            <a href="{{$menu->anchor?$menu->link:route($menu->link)}}"
                                class="link-item transition {{!$menu->anchor?isActive($menu->link):''}}"
                                {{$menu->dropdown?'data-bs-toggle=dropdown':''}}
                                {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}}
                                id="sublink--sidebar-right">{{$menu->title}}</a>

                            @if ($menu->dropdown)
                                <div class="sublink--sidebar-right text-end dropdown-menu" aria-labelledby="sublink--sidebar-right" >
                                    @foreach ($menu->dropdown as $item)
                                        <div class="mb-2">
                                            <a href="{{$item->route}}" target="{{$item->target}}" class="sublink-item transition">{{$item->name}}</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
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
