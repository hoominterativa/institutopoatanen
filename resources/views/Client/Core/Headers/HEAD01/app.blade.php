
<div id="HEAD01" class="container-fluid bg-theme py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div id="logotipo" class="logotipo">
                <a href="{{route('home')}}" alt="NOME SITE">
                    <img src="{{asset('storage/'.$generalSetting->path_logo_header_dark)}}" width="271" alt="NOME SITE" sizes="(max-width=320px) 250px" srcset="">
                </a>
            </div>
            {{-- END LOGOTIPO --}}
            <div class="navigation-header d-flex align-items-center">
                <div class="content-btn-cta me-4">
                    <a href="#" alt="" nofollow class="btn-cta py-1 px-3 animation-hover">Call to Action</a>
                </div>
                {{-- END .content-btn-cta --}}
                <nav class="d-flex align-items-center link-translate me-4">
                    <a href="#" class="btn-translate px-2" alt="{{__('Traduzir para Inglês')}}">EN</a>
                    <a href="#" class="btn-translate px-2 border-0" alt="{{__('Traduzir para Portugês')}}">PT</a>
                </nav>
                {{-- END .link-translate --}}
                <div class="menu-sidebar-header">
                    <div class="btn-menu-sidebar-header">
                        <a href="#sidebar-right" alt="Abrir menu" nofollow data-plugin="sidebar" data-sb-position="right" data-sb-width="100%" class="d-flex">
                            <span class="title me-2">Menu</span>
                            <div class="lines">
                                <i class="w-90 mb-1"></i>
                                <i class="w-100 mb-1"></i>
                                <i class="w-90 mb-0"></i>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- END .menu-sidebar-header --}}
            </div>
            {{-- END .navigation-header --}}
        </div>
    </div>
    {{-- END container --}}
</div>
{{-- END container-fluid --}}


@foreach ($listMenu as $module => $menus)
    @foreach ($menus as $model => $menu)
        @if ($menu->ViewListMenu)
            <li class="mb-0 px-2">
                <a href="{{$menu->config->anchor?$menu->config->linkMenu:route($menu->config->linkMenu)}}" class="nav-link px-2 {{!$menu->config->anchor?isActive($menu->config->linkMenu):''}}" {{$menu->IncludeCore[0]?'data-toggle="dropdow"':''}} {{$menu->config->anchor?'data-toggle="jqueryanchor"':''}}>{{$menu->config->titleMenu}}</a>
                @if ($menu->IncludeCore[0])
                    @php
                        $limit = isset($menu->IncludeCore[1])?$menu->IncludeCore[1]:999;
                        $include = isset($class->$module->$model->model)?$class->$module->$model->model::limit($limit)->get():[];
                    @endphp
                    <ul class="dropdown-menu">
                        @foreach ($include as $item)
                            <li><a href="{{route(Str::lower($model).'.show', [$model.$module => $item->id])}}">{{$item->title}}</a></li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endif
    @endforeach
@endforeach
