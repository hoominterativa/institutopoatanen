<div id="SIDE03" class="side03 transition">
       
        <div class="side03__scroll row mx-auto">
        <div class="side03__left col-sm-6 h-100 col-sm-6 h-100 flex-column d-flex justify-content-end" style="background-image">
            <div class="side03__image mx-auto">
                <img src="{{asset('storage/uploads/tmp/png-slide.png')}}" alt="Logo" loading="lazy"/>
            </div>
        </div>
        {{-- END .side03__left --}}
        <div class="side03__right col-sm-6 h-100 flex-column position-relative d-flex justify-content-center">
            <a href="#" class="side03__button-close">
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
                    <li class="side03__navigation__item">
                        <a href="{{route('home')}}" class="side03__navigation__item__link transition">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="me-3" alt="" loading="lazy"> Home
                        </a>
                    </li>
                    <li class="side03__navigation__item">
                        <a href="{{route('home')}}" class="side03__navigation__item__link transition">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="me-3" alt="" loading="lazy"> Home
                        </a>
                    </li>
                    <li class="side03__navigation__item">
                        <a href="{{route('home')}}" class="side03__navigation__item__link transition">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="me-3" alt="" loading="lazy"> Home
                        </a>
                    </li>
                    <li class="side03__navigation__item">
                        <a href="{{route('home')}}" class="side03__navigation__item__link transition">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="me-3" alt="" loading="lazy"> Home
                        </a>
                    </li>
                </ul>
                {{-- END .side03__navigation__wrapper --}}
            </nav>
            {{-- END .side03__navigation --}}

            <div class="dropdown side03__dropdown mx-auto">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    CTA
                </button>
                <ul class="dropdown-menu side03__dropdown__menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
            {{-- END .side03__dropdown --}}


            <div class="side03__network d-flex align-items-center justify-content-center">
                <a href="#" target="_blank" class="side03__cta-network transition">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" alt="logos" loading="lazy"/>
                </a>
                    <a href="#" target="_blank" class="btn-cta-network transition">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" alt="logos" loading="lazy"/>
                </a>
                <a href="#" target="_blank" class="btn-cta-network transition">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" alt="logos" loading="lazy"/>
                </a>
                <a href="#" target="_blank" class="btn-cta-network transition">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" alt="logos" loading="lazy"/>
                </a>
            </div>

            <nav class="side03__privacy">
                <ul class="d-flex align-items-center justify-content-center">
                    <li>
                        <a href="#">Privacidade</a>
                    </li>
                    <li>
                        <a href="#">Trabalhe Conosco</a>
                    </li>
                </ul>
            </nav>

        </div>
        {{-- END .side03__network --}}
    </div>
</div>
{{-- END #SIDE03 --}}
