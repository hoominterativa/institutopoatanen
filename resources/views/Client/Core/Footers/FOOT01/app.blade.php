{{-- @foreach ($categoryHeader as $categoryHeader)
    <a href="{{$categoryHeader->name}}">{{$categoryHeader->name}}</a>
@endforeach --}}
@foreach ($listMenu as $menus)
    @foreach ($menus as $menu)
        @if ($menu->ViewListMenu)
            <li>
                <a
                    @if (!$menu->config->achor)
                        {{isActive($menu->config->linkMenu)}}
                    @endif
                    href="{{$menu->config->achor?$menu->config->linkMenu:route($menu->config->linkMenu)}}"
                    {{$menu->config->achor?'data-toogle="jqueryAchor"':''}}
                    class="nav-link px-2 text-white">{{$menu->config->titleMenu}}</a>
            </li>
        @endif
    @endforeach
@endforeach
