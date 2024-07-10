<div id="HEAD03" class="container-fluid">
    {{-- <div class="container"> --}}
    <div class="container-header d-flex align-items-start justify-content-between">
        <div id="logoHeader">
            <a href="{{ route('home') }}" alt="{{ __('NOME SITE') }}">
                <img src="{{ asset('storage/' . $generalSetting->path_logo_header_light) }}" alt="Logo">
            </a>
        </div>
        {{-- END #logoHeader --}}
        <div class="head03__right d-flex align-items-start justify-content-between">

            <nav class="d-flex align-items-center link-translate">
                <a href="#" class="btn-translate px-2" alt="{{ __('Traduzir para Inglês') }}">EN</a>
                <a href="#" class="btn-translate px-2 border-0" alt="{{ __('Traduzir para Portugês') }}">PT</a>
            </nav>

            @if ($socials->count())
                <div class="head03__right__socials">
                    @foreach ($socials as $social)
                        <a href="{{ $social->link }}" target="_blank" class="social-link transition"
                            title="{{ $social->title }}">
                            <img src="{{ asset('storage/' . $social->path_image_icon) }}" alt="{{ $social->title }}">
                        </a>
                    @endforeach
                </div>
            @endif

            @if ($linksCtaHeader->count() && $callToActionTitle->active_header??false)
                <div class="head03__right__cta-grp d-flex align-items-start">
                    @if ($linksCtaHeader->count())
                        @foreach ($linksCtaHeader as $linkCtaHeader)
                            <a href="{{getUri($linkCtaHeader->link)}}" target="{{$linkCtaHeader->link_target}}" class="head03__right__cta">{{$linkCtaHeader->title}}</a>
                        @endforeach
                    @endif
                </div>
            @endif

            <div class="menu-sidebar-header">
                <div class="btn-menu-sidebar-header">
                    <a href="#menu02--sidebar-right" class="d-flex align-items-center burguer">
                        <span>Menu</span>
                        <img src="{{ asset('images/menu-icon.svg') }}" alt="icone menu">
                    </a>
                </div>
            </div>
        </div>
        {{-- END menu-sidebar-header --}}
    </div>
    {{-- END .container-header --}}
    {{-- </div> --}}
    {{-- END .container --}}
</div>
{{-- END #HEAD02 --}}

<div class="head3-flutuante container-fluid">
    @if ($socials->count())
        <div class="link-flutuante">
            @foreach ($socials as $social)
                <a href="{{ $social->link }}" target="_blank" class="social-link transition"
                    title="{{ $social->title }}">
                    <img src="{{ asset('storage/' . $social->path_image_icon) }}" alt="{{ $social->title }}">
                </a>
            @endforeach
        </div>
    @endif
    {{-- <nav class="d-flex align-items-center link-translate">
        <a href="#" class="btn-translate px-2" alt="{{ __('Traduzir para Inglês') }}">EN</a>
        <a href="#" class="btn-translate px-2 border-0" alt="{{ __('Traduzir para Portugês') }}">PT</a>
    </nav> --}}
    {{-- END .link-translate --}}
</div>
