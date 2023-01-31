<nav class="foot02__nav foot02__nav--left col-6 col-lg-2">
    <span class="foot02__nav__header">Site Map</span>
    <a href="{{route('home')}}" class="foot02__nav__item transition">Home</a>
    @foreach ($listMenu as $module => $menu)
        @if (!$menu->listFooter)
            @if ($menu->dropdown)
                @foreach ($menu->dropdown as $item)
                    <a href="{{$item->route}}" class="foot02__nav__item transition {{isActive($item->route)?'foot02__nav__item--'.isActive($menu->link):''}}">{{$item->name}}</a>
                @endforeach
            @else
                <a href="{{$menu->anchor?$menu->link:route($menu->link)}}" class="foot02__nav__item transition {{!$menu->anchor?'foot02__nav__item--'.isActive($menu->link):''}}" {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}}>{{$menu->title}}</a>
            @endif
        @endif
    @endforeach
</nav>

<nav class="foot02__nav foot02__nav--center col-6 col-lg-2">
    @foreach ($listMenu as $module => $menu)
        @if ($menu->listFooter)
            <a href="{{route($menu->link)}}" class="foot02__nav__header">{{$menu->title}}</a>

            @if ($menu->dropdown)
                @foreach ($menu->dropdown as $item)
                    <a href="{{$item->route}}" class="foot02__nav__item transition {{isActive($item->route)?'foot02__nav__item--'.isActive($menu->link):''}}">{{$item->name}}</a>
                @endforeach
            @endif
        @endif
    @endforeach
</nav>
