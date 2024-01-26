@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT10" class="cont10 container-fluid px-0"
            style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};">
            <div class="cont10__mask"></div>
            <div class="container container--pd">
                <header class="cont10__encompass text-center">
                    @if ($content->title)
                        <h4 class="cont10__encompass__title">{{ $content->title }}</h4>
                    @endif
                    @if ($content->subtitle)
                        <h5 class="cont10__encompass__subtitle">{{ $content->subtitle }}</h5>
                    @endif
                </header>
                @if ($content->topics->count())
                    <div class="cont10__content">
                        <ul class="cont10__content__navigation">
                            <li class="cont10__content__navigation__title">Datas</li>
                            <li class="cont10__content__navigation__title">Local</li>
                            <li class="cont10__content__navigation__title">CTA</li>
                        </ul>
                        <div class="carousel-cont10 cont10__content__list owl-carousel">
                            <!-- <div class="cont10__content__list__item flex-column"> -->
                                @foreach ($content->topics as $topic)
                                    <div class="cont10__content__list__item__box d-flex">
                                        @if ($topic->date)
                                            <div class="cont10__content__list__item__title">{{ Carbon\Carbon::parse($topic->date)->format('d/m/Y') }}</div>
                                        @endif
                                        @if ($topic->locale)
                                            <div class="cont10__content__list__item__title">{{ $topic->locale }}</div>
                                        @endif
                                        @if ($topic->link_button)
                                            <div class="cont10__content__list__item__title">
                                                <a href="{{ getUri($topic->link_button) }}" target="{{ $topic->link_target_button }}" class="cont10__content__cta transition d-flex justify-content-center align-items-center">
                                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="cont10__content__cta__icon me-3 transition">
                                                    @if ($topic->title_button)
                                                        {{ $topic->title_button }}
                                                    @endif
                                                </a>
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
    @endforeach
@endif
