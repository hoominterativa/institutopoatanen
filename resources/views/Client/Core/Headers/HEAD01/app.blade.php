<section id="top-bar" class="container-fluid">
    <div class="row align-items-center">
        <div class="logo-top-bar py-3 col-12 col-lg-3 d-flex align-items-center justify-content-center">
            <a href="{{route('home')}}">
                <img src="{{url('storage/'.$generalSetting->path_logo_header_dark)}}" height="60" alt="">
            </a>
        </div>
        <nav class="menu-top-bar col-12 col-lg-7 d-flex align-items-center justify-content-end">
            <ul class="list-inline d-flex h-100 align-items-end mb-0">
                <li class="mb-0 px-2">
                    <a href="{{route('home')}}" class="nav-link px-2 {{isActive('home')}}" >Home</a>
                </li>
                @foreach ($listMenu as $menu)
                    <li class="mb-0 px-2">
                        <a href="{{$menu->anchor?$menu->link:route($menu->link)}}" class="nav-link px-2 {{!$menu->anchor?isActive($menu->link):''}}" {{$menu->dropdown?'data-toggle="dropdow"':''}} {{$menu->anchor?'data-toggle="jqueryanchor"':''}}>{{$menu->title}}</a>
                        @if ($menu->dropdown)
                            <ul class="dropdown-menu">
                                @foreach ($menu->dropdown as $dropdown)
                                    <li>
                                        <a href="{{route($dropdown->route, $dropdown->model)}}" {{count($dropdown->subList)?'data-toggle="dropdow"':''}}>{{$dropdown->name}}</a>
                                        @if ($dropdown->subList)
                                            <ul class="dropdown-menu">
                                                @foreach ($dropdown->subList as $subdropdown)
                                                    <li>
                                                        <a href="{{route($subdropdown->route, $subdropdown->model)}}">{{$subdropdown->name}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        <nav class="social-top-bar col-12 col-lg-2 d-flex align-items-center justify-content-center">
            @foreach ($socials as $social)
                <a href="{{$social->link}}" target="_blank" class="mdi {{$social->icon}} mx-2 font-24 text-primary" title="{{$social->title}}"></a>
            @endforeach
        </nav>
    </div>

</section>



