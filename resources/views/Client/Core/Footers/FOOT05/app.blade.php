<footer id="foot05" class="foot02">
    <section class="foot05__site">
        <main class="foot05__site__main container d-flex flex-column">
            <a href="{{ route('home') }}" class="foot05__site__logo">
                <img src="{{asset('storage/'.$generalSetting->path_logo_footer_light??$generalSetting->path_logo_footer_dark)}}" alt="{{env('APP_NAME')}}">
            </a>
            <div class="foot05__site__bottom w-100">
                <nav class="foot05__site__nav">
                    <ul class="foot05__site__nav__list">
                        <li class="foot05__site__nav__list__title"><a href="{{route('home')}}" class="{{isActive('home')}}" rel="next">Home</a></li>
                        @foreach ($listMenu as $module => $menu)
                            <li class="foot05__site__nav__list__item">
                                <a href="{{$menu->anchor? $menu->link: route($menu->link)}}" class="{{!$menu->anchor? isActive($menu->link) : ''}}" rel="next" {{$menu->anchor?'data-bs-toggle=jqueryanchor':''}}>
                                    {{$menu->title}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @foreach ($listModelFooter as $menuFooter)
                        <ul class="foot05__site__nav__list">
                            <li class="foot05__site__nav__list__title"><a href="{{route($menuFooter->link)}}">{{$menuFooter->title}}</a></li>
                            @if ($menuFooter->dropdown)
                                @foreach ($menuFooter->dropdown as $item)
                                    <li class="foot05__site__nav__list__item">
                                        <a href="{{$item->route}}" class="{{isActive($item->route)}}" rel="next">
                                            {{$item->name}}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    @endforeach
                </nav>
                <div class="foot05__site__right d-flex flex-column align-items-center justify-content-start">
                    <h3 class="foot05__site__right__title">Título</h3>
                    <ul class="foot05__site__right__list">
                        @foreach ($socials as $social)
                            <li class="foot05__site__right__list__item">
                                <a href="{{$social->link}}" title="{{$social->title}}" class="mdi {{$social->icon}}" target="_blank" rel="external">
                                    {{-- <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""> --}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <a href="#" class="foot05__site__cta">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                            class="foot05__site__cta__icon">
                        CTA
                    </a>
                </div>
            </div>
            <button class="foot05__site__scrolltop"
                onclick="window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth'
              })">
                <img src="{{ asset('storage/uploads/tmp/seta.png') }}" alt="Seta para cima">
            </button>
        </main>
    </section>
    <section class="foot05__hoom">
        <nav class="foot05__hoom__nav container">
            <ul class="foot05__hoom__links">
                <li class="foot05__hoom__copyright">© 2023 Hoom</li>
                @foreach (getCompliance() as $compliance)
                    <li class="foot05__hoom__links__item"><a href="{{$compliance->link}}" class="foot02__copyright-section__compliances__item">{{$compliance->title_page}}</a></li>
                @endforeach
                @if ($linksCtaFooter->count())
                    @foreach ($linksCtaFooter as $linkCtaHeader)
                        <li class="foot05__hoom__links__item"><a href="{{$linkCtaHeader->link}}" target="{{$linkCtaHeader->link_target}}" rel="next">{{$linkCtaHeader->title}}</a></li>
                    @endforeach
                @endif
            </ul>
            <a href="https://hoom.com.br" target="_blank" class="foot05__hoom__logo">
                <img src="{{ asset('storage/uploads/tmp/logo.png') }}" alt="Hoom Interativa">
            </a>
        </nav>
    </section>
</footer>
