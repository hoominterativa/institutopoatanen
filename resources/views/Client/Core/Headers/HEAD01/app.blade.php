<div id="topo">
    <ul class="main-menu">
        <li><a href="#">Menu 1</a></li>
        <li><a href="#">Menu 2</a></li>
        <li><a href="#">Menu 3</a></li>
        <li><a href="#">Menu 4</a></li>
        <li><a href="#">Menu 5</a></li>
    </ul>
</div>





@foreach ($categoryHeader as $categoryHeader)
    <a href="{{$categoryHeader->name}}" class="ancora">{{$categoryHeader->name}}</a>
@endforeach
@foreach ($listMenu as $menu)
    <a href="{{$menu->Anchor}}" class="ancora">{{$menu->Title}}</a>
@endforeach
