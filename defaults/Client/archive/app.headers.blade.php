<nav>
    <ul class="menu-list list-inline mb-0">
        <li class="list-inline-item menu-item dropdown">
            <a href="{{route('home')}}" class="link transition">Home</a>
        </li>
        @foreach ($listMenu as $module => $menu)
            @if ($menu->viewer == 'list')
                <li class="list-inline-item menu-item {{$menu->dropdown?'dropdown':''}}">
                    @if ($menu->dropdown)
                        @foreach ($menu->dropdown as $item)
                            @if ($item->subList)
                                <a href="{{$item->route}}" data-bs-toggle="dropdown" class="link transition">{{$item->name}} <i class="menu-arrow"></i></a>
                                <div class="dropdown-menu">
                                    @foreach ($item->subList as $subItem)
                                        <a href="{{$subItem->route}}" class="sublink-item transition">{{$subItem->name}}</a>
                                    @endforeach
                                </div>
                            @else
                                <a href="{{$item->route}}" class="link transition {{!$menu->anchor?isActive($menu->link):''}}">{{$item->name}}</a>
                            @endif
                        @endforeach
                    @endif
                </li>
            @else
                <li class="list-inline-item menu-item {{$menu->dropdown?'dropdown':''}}">
                    <a href="{{$menu->anchor?$menu->link:route($menu->link)}}" {{$menu->dropdown?'data-bs-toggle=dropdown':''}} {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}} class="link transition {{!$menu->anchor?isActive($menu->link):''}}">
                        {{$menu->title}}
                        @if ($menu->dropdown)
                            <i class="menu-arrow"></i>
                        @endif
                    </a>
                    @if ($menu->dropdown)
                        <div class="sublink--menu text-end dropdown-menu" aria-labelledby="sublink--menu" >
                            @foreach ($menu->dropdown as $item)
                                @if ($item->subList)
                                    <div class="mb-2 {{$menu->dropdown?'dropdown':''}}">
                                        <a href="{{$item->route}}" data-bs-toggle="dropdown" class="sublink-item transition">{{$item->name}} <i class="menu-arrow"></i></a>
                                        <div class="dropdown-menu">
                                            @foreach ($item->subList as $subItem)
                                                <a href="{{$subItem->route}}" class="sublink-item transition">{{$subItem->name}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="{{$item->route}}" class="sublink-item transition">{{$item->name}}</a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</nav>

@if (isset($linksCtaHeader))
    @if ($linksCtaHeader->count() > 1)
        <div class="dropdown">
            <a href="javascript:void(0)" data-bs-toggle="dropdown" class="btn-cta">{{$linksCtaHeader['title']??''}} <i class="menu-arrow"></i></a>
            <div class="sublink--sidebar-right text-end dropdown-menu" aria-labelledby="sublink--sidebar-right" >
                @foreach ($linksCtaHeader as $title => $linkCtaHeader)
                    @if ($title <> 'title')
                        @if ($linkCtaHeader[1] == '_lightbox')
                            <a href="{{$linkCtaHeader[0]}}" data-fancybox="" class="sublink-item transition mb-2">{{$title}}</a>
                        @else
                            <a href="{{$linkCtaHeader[0]}}" target="{{$linkCtaHeader[1]}}" class="sublink-item transition mb-2">{{$title}}</a>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    @else
        @foreach ($linksCtaHeader as $title => $linkCtaHeader)
            @if ($title <> 'title')
                @if ($linkCtaHeader[1] == '_lightbox')
                    <a href="{{$linkCtaHeader[0]}}" data-fancybox="" class="sublink-item transition mb-2">{{$title}}</a>
                @else
                    <a href="{{$linkCtaHeader[0]}}" target="{{$linkCtaHeader[1]}}" class="sublink-item transition mb-2">{{$title}}</a>
                @endif
            @endif
        @endforeach
    @endif
@endif
{{-- END .btn-cta --}}
