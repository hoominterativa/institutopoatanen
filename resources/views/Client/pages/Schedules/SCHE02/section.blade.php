@if ($section)
    <section id="SCHE02" class="sche02" style="background-image: url('{{ asset('storage/' . $section->path_image_desktop_section) }}'); background-color: {{$section->background_color_section}};">
        @if ($section->path_image_desktop_section)
            <div class="sche02__mask"></div>
        @endif
        <div class="container container--sche02">
            <main class="sche02__main">
                <div class="sche02__main__box d-flex justify-content-between">
                    <div class="row mx-auto px-0">
                        <div class="sche02__main__box__left col-sm-7">
                            <header  class="sche02__main__box__left__header">
                                @if ($section->title_section || $section->subtitle_section)
                                    <h1 class="sche02__main__box__left__header__title">{{$section->title_section}}</h1>
                                    <h2 class="sche02__main__box__left__header__subtitle">{{$section->subtitle_section}}</h2>
                                    <hr class="sche02__main__box__left__header__hr">
                                @endif
                                <div class="sche02__main__box__left__header__paragraph">
                                    @if ($section->description_section)
                                        <p>
                                            {!! $section->description_section !!}
                                        </p>
                                    @endif
                                </div>
                            </header>
                            <div class="sche02__main__box__left__engDropdown">
                                @foreach ($schedulesFeatured as $scheduleFeatured)
                                    <div class="sche02__left__engDropdown__dropdown">

                                        <button class="sche02__main__box__left__engDropdown__dropdown__aba d-flex justify-content-between accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#schedule-{{ $scheduleFeatured->id }}" aria-expanded="false" aria-controls="collapseTwo">
                                            <div class="sche02__main__box__left__engDropdown__dropdown__aba__leftAba">
                                                <span class="sche02__main__box__left__engDropdown__dropdown__aba__leftAba__title">{{Carbon\Carbon::parse($scheduleFeatured->event_date)->formatLocalized('%d')}}</span>
                                                <span class="sche02__main__box__left__engDropdown__dropdown__aba__leftAba__subtitle">{{Carbon\Carbon::parse($scheduleFeatured->event_date)->formatLocalized('%b')}}</span>
                                            </div>
                                            <div class="sche02__main__box__left__engDropdown__dropdown__aba__rightAba">
                                                <span class="sche02__main__box__left__engDropdown__dropdown__aba__rightAba__title">{{ucfirst(Carbon\Carbon::parse($scheduleFeatured->event_date)->formatLocalized('%A'))}}</span>
                                                <h3 class="sche02__main__box__left__engDropdown__dropdown__aba__rightAba__subtitle">{{$scheduleFeatured->event_locale}}</h3>
                                            </div>
                                        </button>
                                        {{-- fim-sche02__left__dropdown__aba --}}

                                        <div id="schedule-{{ $scheduleFeatured->id }}" class="sche02__main__box__left__engDropdown__dropdown__description accordion-collapse collapse" data-bs-parent="#schedule-{{ $scheduleFeatured->id }}">
                                            <div class="sche02__main__box__left__engDropdown__dropdown__description__paragraph">
                                                {!! $scheduleFeatured->informations !!}
                                            </div>
                                            <div class="sche02__main__box__left__engDropdown__dropdown__description__engButton">
                                                @if ($scheduleFeatured->link_button_one)
                                                    <a href="{{getUri($scheduleFeatured->link_button_one)}}" target="{{$scheduleFeatured->target_link_button_one}}" class="sche02__main__box__left__engDropdown__dropdown__description__engButton__cta">
                                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                                        @if ($scheduleFeatured->title_button_one)
                                                            {{$scheduleFeatured->title_button_one}}
                                                        @endif
                                                    </a>
                                                @endif
                                                @if ($scheduleFeatured->link_button_two)
                                                    <a href="{{getUri($scheduleFeatured->link_button_two)}}" target="_blank" class="sche02__main__box__left__engDropdown__dropdown__description__engButton__cta">
                                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                                        @if ($scheduleFeatured->title_button_two)
                                                            {{$scheduleFeatured->title_button_two}}
                                                        @endif
                                                    </a>
                                                @endif
                                            </div>

                                        </div>
                                        {{-- fim-sche02__left__dropdown__description --}}

                                    </div>
                                @endforeach
                            </div>
                            <div class="sche02__main__box__left__btnEmphasis">
                                <a href="#ligtbox-sche02-page" data-fancybox>
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                    CTA
                                </a>
                            </div>
                            @include('Client.pages.Schedules.SCHE02.page', [
                                'schedules' => $schedules,
                                'section' => $section
                            ])
                        </div>
                        <div class="sche02__main__box__right col-sm-5 d-flex align-items-end">
                            <div class="sche02__main__box__right__image mx-auto">
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
