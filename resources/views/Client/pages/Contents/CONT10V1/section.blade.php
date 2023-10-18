@if ($section)
    <section id="CONT10V1" class="cont10v1 container-fluid px-0"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
        <div class="cont10v1__mask"></div>
        <div class="container container--pd">
            <header class="cont10v1__encompass text-center">
                @if ($section->title || $section->subtitle)
                    <h4 class="cont10v1__encompass__title">{{ $section->title }}</h4>
                    <h5 class="cont10v1__encompass__subtitle">{{ $section->subtitle }}</h5>
                @endif
            </header>
            @if ($contents->count())
                <div class="cont10v1__content">
                    <ul class="cont10v1__content__navigation">
                        <li class="cont10v1__content__navigation__title">Datas</li>
                        <li class="cont10v1__content__navigation__title">Local</li>
                        <li class="cont10v1__content__navigation__title">CTA</li>
                    </ul>
                    <div class="carousel-cont10v1 cont10v1__content__list owl-carousel">
                        <!-- <div class="cont10v1__content__list__item flex-column"> -->
                            @foreach ($contents as $content)
                                <div class="cont10v1__content__list__item__box d-flex">
                                    @if ($content->date)
                                        <div class="cont10v1__content__list__item__title">
                                            <span>
                                                {{ Carbon\Carbon::parse($content->date)->formatLocalized('%d') }}
                                            </span>
                                            <span>
                                                {{ Carbon\Carbon::parse($content->date)->formatLocalized('%b') }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="cont10v1__content__list__item__title">
                                        @if ($content->locale)
                                            {{ $content->locale }}
                                        @endif
                                        @if ($content->description)
                                            {!! $content->description !!}
                                        @endif
                                    </div>
                                    @if ($content->link)
                                        <div class="cont10v1__content__list__item__title">
                                            <a href="{{ getUri($content->link) }}" target="{{ $content->link_target }}"
                                                class="cont10v1__content__cta transition d-flex justify-content-center align-items-center">
                                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="cont10v1__content__cta__icon me-3 transition">
                                                @if ($content->title)
                                                    {{ $content->title }}
                                                @endif
                                            </a>
                                        </div>
                                    @else
                                        <div>
                                            Sold out
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        <!-- </div> -->
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif

