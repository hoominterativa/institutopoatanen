<div id="HEAD03" class="container-fluid">
    <div class="container">
        <div class="container-header d-flex align-items-center justify-content-between">
            <div id="logoHeader">
                <a href="{{route('home')}}" alt="{{__('NOME SITE')}}">
                    <img src="{{asset('storage/'.$generalSetting->path_logo_header_light)}}" alt="Logo">
                </a>
            </div>
            {{-- END #logoHeader --}}
            <div class="menu-sidebar-header">
                <div class="btn-menu-sidebar-header">
                    <span>Menu</span>
                    <a href="#menu02--sidebar-right" alt="#" nofollow data-plugin="sidebar" data-sb-position="right" class="d-flex align-items-center">
                        <div class="lines">
                            <i class="w-100 mb-2 mx-auto transition"></i>
                            <i class="w-100 mb-2 mx-auto transition"></i>
                            <i class="w-100 mb-0 mx-auto transition"></i>
                        </div>
                    </a>
                </div>
            </div>
            {{-- END menu-sidebar-header --}}
        </div>
        {{-- END .container-header --}}
    </div>
    {{-- END .container --}}
</div>
{{-- END #HEAD02 --}}

<div class="head3-flutuante container-fluid">
    @if ($socials->count())
        <div class="link-flutuante">
            @foreach ($socials as $social)
                <a href="{{$social->link}}"  target="_blank" class="social-link transition" title="{{$social->title}}">
                    <img src="{{asset('storage/'.$social->path_image_icon)}}" width="28.5px" alt="{{$social->title}}">
                </a>
            @endforeach
        </div>
    @endif
    <nav class="d-flex align-items-center link-translate">
        <a href="#" class="btn-translate px-2" alt="{{__('Traduzir para Inglês')}}">EN</a>
        <a href="#" class="btn-translate px-2 border-0" alt="{{__('Traduzir para Portugês')}}">PT</a>
    </nav>
    {{-- END .link-translate --}}
</div>
