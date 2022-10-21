<div id="HEAD02" class="container-fluid">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div id="logoHeader">
                <a href="{{route('home')}}">
                    <img src="{{asset('storage/'.$generalSetting->path_logo_header_light)}}" alt="" width="202px" sizes="(max-width: 700px) 165px">
                </a>
            </div>
            <nav class="container-navigation d-flex align-items-center">
                <ul class="menu-list list-inline mb-0">
                    <li class="list-inline-item"><a href="#">Home</a></li>
                    <li class="list-inline-item"><a href="#">Sobre</a></li>
                    <li class="list-inline-item"><a href="#">Produtos</a></li>
                    <li class="list-inline-item"><a href="#">Serviços</a></li>
                    <li class="list-inline-item"><a href="#">Blogs</a></li>
                    <li class="list-inline-item"><a href="#">Contatos</a></li>
                </ul>
                {{-- END .menu-list --}}

                <a href="#" class="btn-cta">CTA</a>
                {{-- END .btn-cta --}}

                <div class="social-network d-flex align-items-center mb-0">
                    @foreach ($socials as $social)
                        <a href="{{$social->link}}" class="social-link transition" title="{{$social->title}}"><i class="mdi {{$social->icon}}"></i></a>
                    @endforeach
                </div>

                <div class="d-flex align-items-center link-translate me-4">
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
