<header class="head06">
    <menu class="head06__content">
        <nav class="head06__content__left">
            <ul class="head06__content__left__list">
                <li class="head06__content__left__list__item">
                    <a href="#">Home</a>
                </li>
                
            </ul>
        </nav>
        <div class="head06__content__logo">
            <a href="{{route('home')}}">
                <img src="{{asset('storage/'.$generalSetting->path_logo_header_light)}}" alt="" width="202">
            </a>
        </div>
        <div class="head06__content__right">
            <nav class="head06__content__right__menu">
               <ul>
                    @for($i = 0; $i <= 2; $i++)
                        <li>Euuu</li>
                    @endfor
                    
               </ul>
            </nav>
            
            @if ($linksCtaHeader->count() && $callToActionTitle->active_header??false)
                <div class="head06__content__right__cta">
                    <div class="dropdown">
                        @if ($linksCtaHeader->count()>1)
                            <a href="javascript:void(0)" data-bs-toggle="dropdown" class="btn-cta transition">
                                {{$callToActionTitle->title_header??''}}
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="sublink--cta-right text-end dropdown-menu" aria-labelledby="sublink--cta-right" >
                                @foreach ($linksCtaHeader as $linkCtaHeader)
                                    <a href="{{getUri($linkCtaHeader->link)}}" target="{{$linkCtaHeader->link_target}}" class="sublink-item">{{$linkCtaHeader->title}}</a>
                                @endforeach
                            </div>
                        @else
                            @foreach ($linksCtaHeader as $linkCtaHeader)
                                <a href="{{getUri($linkCtaHeader->link)}}" target="{{$linkCtaHeader->link_target}}" class="btn-cta">{{$linkCtaHeader->title}}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
            {{-- END .btn-cta --}}
            @if ($socials->count())
                <div class="head06__content__right__rede">
                    @foreach ($socials as $social)
                    <a href="{{$social->link}}" title="{{$social->title}}">
                        <img src="{{asset('storage/'.$social->path_image_icon)}}" alt="{{$social->title}}">
                    </a>
                    @endforeach
                </div>
            @endif
            {{-- head06__content__right__rede --}}
        </div>
    </menu>
</header>
{{-- END .btn-cta --}}
