@if ($section)
    <section id="SCHE02" class="sche02" style="background-image: url({{ asset('storage/' . $section->path_image_desktop_section) }}); background-color: {{$section->background_color_section}};">
        @if ($section->path_image_desktop_section)
            <div class="sche02__mask"></div>
        @endif
        <div class="container">
            <main class="sche02__main">
                <div class="sche02__main__box d-flex justify-content-between">
                    <div class="row mx-auto px-0">
                        <div class="sche02__left col-sm-7">
                            <header  class="sche02__left__header">
                                @if ($section->title_section || $section->subtitle_section)
                                    <h1 class="sche02__left__header__title">{{$section->title_section}}</h1>
                                    <h2 class="sche02__left__header__subtitle">{{$section->subtitle_section}}</h2>
                                    <hr class="sche02__left__header__hr">
                                @endif
                                <div class="sche02__left__header__paragraph">
                                    @if ($section->description_section)
                                        <p>
                                            {!! $section->description_section !!}
                                        </p>
                                    @endif
                                </div>
                            </header>
                            <div class="sche02__left__engDropdown">
                                @foreach ($schedules as $schedule)
                                    <div class="sche02__left__engDropdown__dropdown">
                                        
                                        <button class="sche02__left__engDropdown__dropdown__aba d-flex justify-content-between accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#schedule-{{ $schedule->id }}" aria-expanded="false" aria-controls="collapseTwo">
                                            <div class="sche02__left__engDropdown__dropdown__aba__leftAba">
                                                <span>{{Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%d')}}</span>
                                                <span>{{Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%b')}}</span>
                                            </div>
                                            <div class="sche02__left__engDropdown__dropdown__aba__rightAba">
                                                <span>{{ucfirst(Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%A'))}}</span>
                                                <h3>{{$schedule->event_locale}}</h3>
                                            </div>
                                        </button>
                                        {{-- fim-sche02__left__dropdown__aba --}}
        
                                        <div id="schedule-{{ $schedule->id }}" class="sche02__left__engDropdown__dropdown__description accordion-collapse collapse" data-bs-parent="#schedule-{{ $schedule->id }}">
                                            <div class="sche02__left__engDropdown__dropdown__description__paragraph">
                                                <p>{!! $schedule->informations !!}</p>
                                            </div>
                                            @if ($schedule->link_button_one)
                                                <a href="{{getUri($schedule->link_button_one)}}" target="{{$schedule->target_link_button_one}}" class="sche02__left__engDropdown__dropdown__description__btn">
                                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                                    @if ($schedule->title_button_one)
                                                        {{$schedule->title_button_one}}
                                                    @endif
                                                </a>
                                            @endif
                                            @if ($schedule->link_button_two)
                                                <a href="{{getUri($schedule->link_button_two)}}" target="_blank" class="sche02__left__engDropdown__dropdown__description__btn">
                                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                                    @if ($schedule->title_button_two)
                                                        {{$schedule->title_button_two}}
                                                    @endif
                                                </a>
                                            @endif
                                        </div>
                                        {{-- fim-sche02__left__dropdown__description --}}
                                        
                                    </div>
                                @endforeach
                            </div>
                            <div class="sche02__left__btnEmphasis">
                                <a href="#" data-fanybox>
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                    CTA
                                </a>
                            </div>
                        </div>
                        <div class="sche02__right col-sm-5 d-flex align-items-end">
                            <div class="sche02__right__image mx-auto">
                                @if ($section->path_image_section)
                                    <img src="{{ asset('storage/' . $section->path_image_section) }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>
@endif
