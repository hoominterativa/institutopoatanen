<header class="head06">
    <menu class="head06__content">
        <ul class="head06__content__left">
            @for($i = 0; $i <= 3; $i++)
                <li>Euuu</li>
            @endfor
        </ul>
        <div class="head06__content__logo">
            <a href="{{route('home')}}">
                <img src="{{asset('storage/'.$generalSetting->path_logo_header_light)}}" alt="" width="202">
            </a>
        </div>
        <ul class="head06__content__right">
            @for($i = 0; $i <= 2; $i++)
                <li>Euuu</li>
            @endfor
            <li class="list-inline-item menu-item dropdown">
                <a href="#" target="_self" data-bs-toggle='dropdown' data-bs-toggle=jqueryanchor class="link transition">
                    <i class="menu-arrow"></i>
                </a>
                <div class="sublink--menu text-end dropdown-menu" aria-labelledby="sublink--menu" >
                    <div class="mb-2 dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="sublink-item transition">CTA <i class="menu-arrow"></i></a>
                        <div class="dropdown-menu">
                                <a href="#" class="sublink-item transition">Sub-item</a>
                        </div>
                    </div>
                    <a href="#" class="sublink-item transition">CTA</a>
                </div>
            </li>
            <li class="head06__content__right__cta">
                <a href="#" class="link-full"></a>
                CTA
            </li>
            <li class="head06__content__right__rede">
                <a href="#">
                    <img src="" alt="">
                </a>
                <a href="#">
                    <img src="" alt="">
                </a>
                <a href="#">
                    <img src="" alt="">
                </a>
            </li>
        </ul>
    </menu>
</header>
{{-- END .btn-cta --}}
