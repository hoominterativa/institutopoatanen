<header class="head06">
    <menu class="head06__content">
        <nav class="head06__content__left">
            <ul class="head06__content__left__list">
                <li class="head06__content__left__list__item">
                    <a href="#">Home</a>
                </li>
                <li class="head06__content__left__list__item">
                    <div class="head06__content__right__encompass-cta__cta__dropdown dropdown">
                        <button class="dropdown-toggle head06__content__right__encompass-cta__cta__dropdown__dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            CTA
                        </button>
                        <ul class="dropdown-menu head06__content__right__encompass-cta__cta__dropdown__dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
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
            
            <div class="head06__content__right__encompass-cta">
                {{-- <div class="head06__content__right__encompass-cta__cta">
                    <a href="" class="head06__content__right__encompass-cta__cta__button">
                        CTA
                    </a>
                </div> --}}
                {{-- END BUTTON --}}
                <div class="head06__content__right__encompass-cta__cta">
                    <div class="head06__content__right__encompass-cta__cta__dropdown dropdown">
                        <button class="dropdown-toggle head06__content__right__encompass-cta__cta__dropdown__dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        CTA
                        </button>
                        <ul class="dropdown-menu head06__content__right__encompass-cta__cta__dropdown__dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                {{-- END DROPDOWN --}}
            </div>

            {{-- END .btn-cta --}}
                <div class="head06__content__right__rede">
                    @for($i = 0; $i <= 2; $i++)
                        <a href="#" title="Rede Social">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="ícone rede social">
                        </a>
                    @endfor
                </div>
            {{-- head06__content__right__rede --}}
        </div>
    </menu>
</header>
{{-- END .btn-cta --}}
