<div id="SIDE03" class="side03 transition">
        <a href="#" class="side03__button-close">
            <svg class="side03__button-close__icon" width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-3.71547e-07 7.5L12.75 0.138784L12.75 14.8612L-3.71547e-07 7.5Z" fill="#D9D9D9"></path>
            </svg>
        </a>
        <div class="side03__scroll row mx-auto">
        <div class="side03__left col-sm-6 h-100 col-sm-6 h-100 flex-column d-flex justify-content-end" style="background-image">
            <div class="side03__image mx-auto">
                <img src="{{asset('storage/uploads/tmp/png-slide.png')}}" />
            </div>
        </div>
        {{-- END .side03__left --}}
        <div class="side03__right col-sm-6 h-100 flex-column d-flex justify-content-center">
            <nav class="side03__navigation">

                <img src="{{asset('storage/'.$generalSetting->path_logo_header_dark)}}" class="side03__logo" width="203" alt="{{env('APP_NAME')}}">

                <ul class="side03__navigation__wrapper">
                    <li class="side03__navigation__item">
                        <a href="{{route('home')}}" class="side03__navigation__item__link transition">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="me-3" alt=""> Home
                        </a>
                    </li>
                </ul>
                {{-- END .side03__navigation__wrapper --}}
            </nav>
            {{-- END .side03__navigation --}}




            {{-- END .side03__dropdown --}}

        </div>
        {{-- END .side03__right --}}
    </div>
</div>
{{-- END #SIDE03 --}}
