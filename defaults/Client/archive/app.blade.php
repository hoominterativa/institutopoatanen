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
                            <a href="{{route(Str::lower($model).'.show', [$model.$module => $item->id])}}" class="sublink-item transition">{{$item->title}}</a>
                        @endforeach
                    </div>
                @endif

            </div>
        @endif
    @endforeach
@endforeach
