<section id="top-bar" class="container-fluid">
    <div class="row align-items-center">
        <div class="logo-top-bar py-3 col-12 col-lg-3 d-flex align-items-center justify-content-center">
            <a href="{{route('home')}}">
                <img src="{{url('storage/'.$generalSetting->path_logo_header_dark)}}" height="60" alt="">
            </a>
        </div>
        <nav class="menu-top-bar col-12 col-lg-7 d-flex align-items-center justify-content-end">
            <ul class="list-inline d-flex h-100 align-items-end mb-0">
                @foreach ($listMenu as $module => $menus)
                    @foreach ($menus as $model => $menu)
                        @php
                            $limit = isset($menu->IncludeCore[1])?$menu->IncludeCore[1]:999;
                            $include = isset($class->$module->$model->model)?$class->$module->$model->model::limit($limit)->get():[];
                        @endphp
                        @if ($menu->ViewListMenu)
                            <li class="mb-0">
                                <a href="{{$menu->config->anchor?$menu->config->linkMenu:route($menu->config->linkMenu)}}" class="nav-link px-2" {{$menu->IncludeCore[0]?'data-toggle="dropdow"':''}} {{!$menu->config->anchor?isActive($menu->config->linkMenu):''}} {{$menu->config->anchor?'data-toggle="jqueryanchor"':''}}>{{$menu->config->titleMenu}}</a>
                                @if ($menu->IncludeCore[0])
                                    <ul class="dropdown-menu">
                                        @foreach ($include as $item)
                                            <li><a href="{{route(Str::lower($model).'.show', [Str::lower($model) => $item->id])}}">{{$item->title}}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
        </nav>
        <nav class="social-top-bar col-12 col-lg-2 d-flex align-items-center justify-content-center">
            @foreach ($socials as $social)
                <a href="{{$social->link}}" target="_blank" class="mdi {{$social->icon}} mx-2 font-24 text-primary" title="{{$social->title}}"></a>
            @endforeach
        </nav>
    </div>

</section>



