@if ($contents->count())
    @if ($section)
        <section id="CONT10" class="cont10 container-fluid px-0"
            style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
            <div class="container container--pd">
                <header class="cont10__encompass text-center">
                    @if ($section->title || $section->subtitle)
                        <h4 class="cont10__encompass__title">{{$section->title}}</h4>
                        <h5 class="cont10__encompass__subtitle">{{$section->subtitle}}</h5>
                    @endif
                </header>
                <div class="cont10__content">
                    <ul class="cont10__content__navigation">
                        <li class="cont10__content__navigation__title">Datas</li>
                        <li class="cont10__content__navigation__title">Local</li>
                        <li class="cont10__content__navigation__title">CTA</li>
                    </ul>
                    <div class="carousel-cont10 cont10__content__list owl-carousel">
                        @foreach ($contents as $content)
                            <ul class="cont10__content__list__item ">
                                @if ($content->date)
                                    <li class="cont10__content__list__item__title">{{ $content->date }}</li>
                                @endif
                                @if ($content->locale)
                                    <li class="cont10__content__list__item__title">{{ $content->locale }}</li>
                                @endif
                                @if ($content->link || $content->link_target)
                                    <li class="cont10__content__list__item__title">
                                        <a href="{{ $content->link }}" target="{{ $content->link_target }}"
                                            class="cont10__content__cta transition d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                alt="" class="cont10__content__cta__icon me-3 transition">
                                            CTA
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
