@foreach ($listMenu as $module => $menus)
    <div class="mb-2 {{$menu->dropdown?'dropdown':''}}">
        <a href="{{$menu->anchor?$menu->link:route($menu->link)}}"
            class="link-item transition {{!$menu->anchor?isActive($menu->link):''}}"
            {{$menu->dropdown?'data-bs-toggle=dropdown':''}}
            {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}}
            id="sublink--sidebar-right">{{$menu->title}}</a>

        @if ($menu->dropdown)
            <div class="sublink--sidebar-right text-end dropdown-menu" aria-labelledby="sublink--sidebar-right" >
                @foreach ($menu->dropdown as $item)
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
