@foreach ($listMenu as $module => $menus)
    @foreach ($menus as $model => $menu)
        @php
            $limit = isset($menu->IncludeCore[1])?$menu->IncludeCore[1]:1;
            $include = $class->$module->$model->model::limit($limit)->get();
        @endphp
        @if ($menu->ViewListMenu)
            <li>
                <a href="{{$menu->config->achor?$menu->config->linkMenu:route($menu->config->linkMenu)}}" class="nav-link px-2 text-white" {{$menu->IncludeCore[0]?'data-toggle="dropdow"':''}} {{!$menu->config->achor?isActive($menu->config->linkMenu):''}} {{$menu->config->achor?'data-toggle="jqueryAchor"':''}}>{{$menu->config->titleMenu}}</a>
                @if ($menu->IncludeCore[0])
                    <ul class="dropdown-menu">
                        @foreach ($include as $item)
                            <li>{{$item->title}}</li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endif
    @endforeach
@endforeach
