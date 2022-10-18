@foreach ($listMenu as $module => $menus)
    <div class="mb-2 {{$menu->dropdown?'dropdown':''}}">
        <a href="{{$menu->anchor?$menu->link:route($menu->link)}}"
            class="link-item transition {{!$menu->anchor?isActive($menu->link):''}}"
            {{$menu->dropdown?'data-bs-toggle=dropdown':''}}
            {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}}
            id="sublink--sidebar-right">{{$menu->title}}</a>

        @if ($menu->dropdown)
            <div class="sublink--sidebar-right text-end dropdown-menu" aria-labelledby="sublink--sidebar-right" >
                @foreach ($menu->subList as $item)
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
