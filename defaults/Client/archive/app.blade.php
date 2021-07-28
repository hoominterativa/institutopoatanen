@foreach ($categoryHeader as $categoryHeader)
    <a href="{{$categoryHeader->name}}" class="ancora">{{$categoryHeader->name}}</a>
@endforeach
@foreach ($listMenu as $menu)
    <a href="{{$menu->Anchor}}" class="ancora">{{$menu->Title}}</a>
@endforeach
