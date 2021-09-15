@foreach ($listMenu as $module => $menus)
    @foreach ($menus as $model => $menu)
        @php
            $limit = isset($menu->IncludeCore[1])?$menu->IncludeCore[1]:999;
            $include = $class->$module->$model->model::limit($limit)->get();
        @endphp
        @if ($menu->ViewListMenu)
                <li>
                    <a href="{{$menu->config->anchor?$menu->config->linkMenu:route($menu->config->linkMenu)}}" class="nav-link px-2 text-white" {{$menu->IncludeCore[0]?'data-toggle="dropdow"':''}} {{!$menu->config->anchor?isActive($menu->config->linkMenu):''}} {{$menu->config->anchor?'data-toggle="jqueryanchor"':''}}>{{$menu->config->titleMenu}}</a>
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
