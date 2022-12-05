<section id="FOOT02" class="foot02 container-fluid">
    <div class="container foot02__container">
        <div class="row">
            <div class="foot02__logo col-12 col-lg-3">
                <div class="d-table foot02__logo__wraper">
                    <img class="foot02__logo__item" width="202" src="{{asset('storage/'.$generalSetting->path_logo_footer_light??$generalSetting->path_logo_footer_dark)}}" alt="{{env('APP_NAME')}}">
                    <nav class="foot02__socials d-flex align-items-center justify-content-center">
                        @foreach ($socials as $social)
                            <a href="{{$social->link}}" title="{{$social->title}}" target="_blank" class="foot02__socials__item transition mdi {{$social->icon}}"></a>
                        @endforeach
                    </nav>
                </div>
            </div>
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
            <nav class="foot02__nav foot02__nav--right col-6 col-lg-2">
                <span class="foot02__nav__header">Contatos</span>
                <a href="tel:{{$generalSetting->phone}}" class="foot02__nav__item transition">{{$generalSetting->phone}}</a>
                <a href="https://api.whatsapp.com/send?phone=55{{Str::slug($generalSetting->whatsapp,'')}}" target="_blank" class="foot02__nav__item transition">{{$generalSetting->phone}}</a>
                <p class="foot02__nav__item transition pe-3">
                    {{$generalSetting->address}}
                </p>
            </nav>
            <div class="foot02__nav foot02__nav--icon col-6 col-lg-2">
                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="43" alt="">
            </div>
        </div>
    </div>
    <div class="foot02__copyright-section">
        <div class="container foot02__copyright-section__container">
            <div class="row">
                <nav class="foot02__copyright-section__compliances col-12 col-lg-9 d-flex align-items-center">
                    @if (isset($linksCtaFooter))
                        @foreach ($linksCtaFooter as $title => $linkCtaHeader)
                            @if ($title <> 'title')
                                @if ($linkCtaHeader[1] == '_lightbox')
                                    <a href="{{$linkCtaHeader[0]}}" data-fancybox="" class="foot02__copyright-section__compliances__item">{{$title}}</a>
                                @else
                                    <a href="{{$linkCtaHeader[0]}}" target="{{$linkCtaHeader[1]}}" class="foot02__copyright-section__compliances__item">{{$title}}</a>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </nav>
                <div class="col-12 col-lg-2">
                    <a href="http://hoom.com.br" target="_blank" class="d-table ms-auto">
                        <img class="foot02__logo__hoom" width="147" src="{{asset('storage/uploads/tmp/logo.png')}}" alt="Hoom Interativa">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
