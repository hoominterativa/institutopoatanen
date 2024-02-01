
<div id="HEAD01" class="container-fluid bg-theme py-4 header-floating fixed-floating top" data-min-scrolling="50">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div id="logotipo" class="logotipo">
                <a href="{{route('home')}}" alt="{{__('NOME SITE')}}">
                    <img src="{{asset('storage/'.$generalSetting->path_logo_header_light)}}" width="271" class="transition" alt="{{__('NOME SITE')}}" sizes="(max-width=320px) 250px" srcset="">
                </a>
            </div>
            {{-- END LOGOTIPO --}}
            <div class="navigation-header d-flex align-items-center">
                @if ($linksCtaHeader->count() && $callToActionTitle->active_header)
                    <div class="content-btn-cta me-4">
                        <a href="#" alt="{{__('Call to Action')}}" nofollow class="btn-cta py-1 px-3 transition">Call to Action</a>
                    </div>
                    <div class="content-btn-cta me-4">
                        <div class="dropdown">
                            @if ($linksCtaHeader->count()>1)
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" class="btn-cta py-1 px-3 transition">
                                    {{$callToActionTitle->title_header??''}}
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="sublink--cta-right text-end dropdown-menu" aria-labelledby="sublink--cta-right" >
                                    @foreach ($linksCtaHeader as $linkCtaHeader)
                                        <a href="{{getUri($linkCtaHeader->link)}}" target="{{$linkCtaHeader->link_target}}" class="sublink-item transition mb-2">{{$linkCtaHeader->title}}</a>
                                    @endforeach
                                </div>
                            @else
                                @foreach ($linksCtaHeader as $linkCtaHeader)
                                    <a href="{{getUri($linkCtaHeader->link)}}" target="{{$linkCtaHeader->link_target}}" class="btn-cta py-1 px-3 transition">{{$linkCtaHeader->title}}</a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
                {{-- END .btn-cta --}}
                {{-- END .content-btn-cta --}}
                <nav class="d-flex align-items-center link-translate me-4">
                    <a href="#" class="btn-translate px-2" alt="{{__('Traduzir para Inglês')}}">EN</a>
                    <a href="#" class="btn-translate px-2 border-0" alt="{{__('Traduzir para Portugês')}}">PT</a>
                </nav>
                {{-- END .link-translate --}}
                <div class="menu-sidebar-header">
                    <div class="btn-menu-sidebar-header">
                        <a href="#menu01--sidebar-right" alt="{{__('Abrir menu')}}" nofollow data-plugin="sidebar" data-sb-position="right" class="d-flex align-items-center">
                            <span class="title me-3">Menu</span>
                            <div class="lines">
                                <i class="w-80 mb-2 mx-auto transition"></i>
                                <i class="w-100 mb-2 mx-auto transition"></i>
                                <i class="w-80 mb-0 mx-auto transition"></i>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- END .menu-sidebar-header --}}
            </div>
            {{-- END .navigation-header --}}
        </div>
    </div>
    {{-- END container --}}
</div>
{{-- END container-fluid --}}
