
<section id="ligtbox-SCHE02-show" class="lish">
    {{-- <div class="lish__bg-dark"></div> --}}
    <div class="lish__contentBox">
        <div class="container-fluid px-0 container--lish">
            <header class="lish__topo">
                <div class="lish__topoengPrev">
                    <button class="lish__topoengPrev__prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24" viewBox="0 0 14 24" fill="none">
                            <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97919 12.6066 1.3934C12.0208 0.807611 11.0711 0.807611 10.4853 1.3934L0.93934 10.9393ZM3 10.5H2L2 13.5H3V10.5Z" fill="#404040"/>
                        </svg>
                    </button>
                    <span class="lish__topoengPrev__date">09/Abril/2023</span>
                </div>
                <button class="lish__topo__close">x</button>
            </header>
            <div class="lish__content">
                @foreach ($schedules as $schedule)
                    <div class="lish__content__box">
                        <button class="lish__content__box__top accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#lish-{{$schedule->id}}" aria-expanded="false" aria-controls="collapseTwo">
                            <div class="lish__content__box__top__left">
                                <h4 class="lish__content__box__top__left__title">{{ucfirst(Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%A'))}}</h4>
                                <h5 class="lish__content__box__top__left__subtitle">{{$schedule->event_locale}}</h5>
                            </div>
                        </button>
                        <div id="lish-{{$schedule->id}}" class="lish__content__box__bottom accordion-collapse collapse" data-bs-parent="#lish-{{$schedule->id}}">
                            <div class="lish__content__box__bottom__paragraph">
                                <p>
                                    {!! $schedule->informations !!}
                                </p>
                            </div>
                            {{-- fim-paragraph --}}
                            <div class="lish__content__box__bottom__buttons">
                                @if ($schedule->link_button_one)
                                    <a href="{{getUri($schedule->link_button_one)}}" target="{{$schedule->target_link_button_one}}" class="lish__content__box__bottom__buttons__btn">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                        @if ($schedule->title_button_one)
                                            {{$schedule->title_button_one}}
                                        @endif
                                    </a>
                                @endif
                                @if ($schedule->link_button_two)
                                    <a href="{{getUri($schedule->link_button_two)}}" target="_blank" class="lish__content__box__bottom__buttons__btn">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                        @if ($schedule->title_button_two)
                                            {{$schedule->title_button_two}}
                                        @endif
                                    </a>
                                @endif
                            </div>
                            {{-- fim-buttons --}}
                        </div>
                    </div>
                @endforeach
                {{-- fim-lish__content__box --}}
            </div>
        </div>
    </div>
</section>


