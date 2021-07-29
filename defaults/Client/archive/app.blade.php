@foreach ($categoryHeader as $categoryHeader)
    <li><a href="{{$categoryHeader->name}}">{{$categoryHeader->name}}</a></li>
@endforeach
@foreach ($listMenu as $menu)
    @if (count(get_object_vars($menu->ListMenu)))
        <li><a href="{{$menu->ListMenu->Anchor}}">{{$menu->ListMenu->Title}}</a></li>
    @endif
@endforeach
