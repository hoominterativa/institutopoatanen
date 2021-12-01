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
