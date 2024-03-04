<div id="SIDE03" class="side03 burger__target">
    <div class="side03__scroll row mx-auto">
        <div class="side03__left col-sm-6 h-100 col-sm-6 h-100 flex-column d-flex justify-content-end" style="background-image">
            <div class="side03__image mx-auto">
                <img src="{{asset('storage/uploads/tmp/png-slide.png')}}" alt="Logo" loading="lazy"/>
            </div>
        </div>
        {{-- END .side03__left --}}
        <div class="side03__right col-sm-6 h-100 flex-column position-relative d-flex justify-content-center">
            <a href="#" class="side03__button-close burguer">
                <svg class="side03__button-close__icon" width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M-3.71547e-07 7.5L12.75 0.138784L12.75 14.8612L-3.71547e-07 7.5Z" fill="#D9D9D9"></path>
                </svg>
            </a>
            <nav class="side03__navigation">

                <img src="{{asset('storage/'.$generalSetting->path_logo_header_dark)}}" class="side03__logo" width="203" alt="{{env('APP_NAME')}}">

                <ul class="side03__navigation__wrapper">
                    <li class="side03__navigation__item">
                        <a href="{{route('home')}}" class="side03__navigation__item__link transition">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="me-3" alt="" loading="lazy"> Home
                        </a>
                    </li>
                    @foreach ($listMenu as $module => $menu)
                        <li class="side03__navigation__item {{$menu->dropdown?'dropdown': ''}}">
                            @if (Route::current()->uri != 'home' && !$menu->anchor)
                                <a href="{{route($menu->link)}}" {{$menu->dropdown?'data-bs-toggle=dropdown':''}} {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}} target="{{$menu->target_link}}" class="side03__navigation__item__link transition {{!$menu->anchor?isActive($menu->link):''}}">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="me-3" alt="" loading="lazy"> {{$menu->title}}
                                    @if ($menu->dropdown)
                                        <i class="menu-arrow"></i>
                                    @endif
                                </a>
                            @elseif (Route::current()->uri != 'home')
                                <a href="{{$menu->anchor?$menu->link:route($menu->link)}}" {{$menu->dropdown?'data-bs-toggle=dropdown':''}} {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}} target="{{$menu->target_link}}" class="side03__navigation__item__link transition {{!$menu->anchor?isActive($menu->link):''}}">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="me-3" alt="" loading="lazy">{{$menu->title}}
                                    @if ($menu->dropdown)
                                        <i class="menu-arrow"></i>
                                    @endif
                                </a>
                            @else
                                <a href="{{$menu->anchor?$menu->link:route($menu->link)}}" {{$menu->dropdown?'data-bs-toggle=dropdown':''}} {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}} target="{{$menu->target_link}}" class="side03__navigation__item__link transition {{!$menu->anchor?isActive($menu->link):''}}">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="me-3" alt="" loading="lazy"> {{$menu->title}}
                                    @if ($menu->dropdown)
                                        <i class="menu-arrow"></i>
                                    @endif
                                </a>
                            @endif

                            @if ($menu->dropdown)
                                <div class="side03__navigation__dropdown dropdown-menu">
                                    @foreach ($menu->dropdown as $item)
                                        <a href="{{$item->route}}" target="{{$item->target}}" class="side03__navigation__sublink transition">
                                            {{$item->name}}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
                {{-- END .side03__navigation__wrapper --}}
            </nav>
            {{-- END .side03__navigation --}}
            @if ($linksCtaHeader->count())
                <div class="dropdown side03__dropdown mx-auto">
                    @if ($linksCtaHeader->count() > 1)
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{$callToActionTitle->title_header??''}} <i class="menu-arrow"></i>
                        </button>
                        <ul class="dropdown-menu side03__dropdown__menu">
                            @foreach ($linksCtaHeader as $linkCtaHeader)
                                <li><a class="dropdown-item" href="{{$linkCtaHeader->link}}" target="{{$linkCtaHeader->link_target}}">{{$linkCtaHeader->title}}</a></li>
                            @endforeach
                        </ul>
                    @else
                        @foreach ($linksCtaHeader as $title => $linkCtaHeader)
                            <li><a class="dropdown-item" href="{{$linkCtaHeader->link}}" target="{{$linkCtaHeader->link_target}}">{{$linkCtaHeader->title}}</a></li>
                        @endforeach
                    @endif
                </div>
            @endif
            {{-- END .side03__dropdown --}}

            @if ($socials->count())
                <nav class="side03__network d-flex align-items-center justify-content-center">
                    @foreach ($socials as $social)
                        <a href="{{$social->link}}"  target="_blank" class="social-link transition" title="{{$social->title}}">
                            <img src="{{asset('storage/'.$social->path_image_icon)}}" width="28.5px" alt="{{$social->title}}">
                        </a>
                    @endforeach
                </nav>
            @endif

            <nav class="side03__privacy">
                @if (isset($linksCtaFooter))
                    <ul class="d-flex align-items-center justify-content-center">
                        @foreach ($linksCtaFooter as $title => $linkCtaHeader)
                            <li><a href="{{$linkCtaHeader->link}}" target="{{$linkCtaHeader->link_target}}">{{$linkCtaHeader->title}}</a></li>
                        @endforeach
                    </ul>
                @endif
            </nav>
        </div>
        {{-- END .side03__network --}}
    </div>
</div>
{{-- END #SIDE03 --}}
