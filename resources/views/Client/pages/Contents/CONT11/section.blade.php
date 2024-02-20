@if ($contents->count())
    @foreach ($contents as $content)
        <section class="cont11" id="CONT11">
            @if ($content->galleries->count() > 0)
                <div class="cont11__gallery">
                    <div class="cont11__gallery__swiper-wrapper swiper-wrapper">
                        @foreach ($content->galleries as $gallery)
                            <img class="cont11__gallery__item swiper-slide" src="{{ asset('storage/' . $gallery->path_image) }}"
                                alt="Imagems da galeria de {{ $content->title }}" loading="lazy">
                        @endforeach
                    </div>

                    <div class="cont11__gallery__nav">
                        <div class="cont11__gallery__nav__swiper-button-prev swiper-button-prev"></div>
                        <div class="cont11__gallery__nav__swiper-button-next swiper-button-next"></div>
                    </div>
                </div>
            @endif

            @if ($content->title)
                <div class="cont11__information">
                    @if ($content->title)
                        <h2 class="cont11__information__title">{{ $content->title }}</h2>
                    @endif

                    @if ($content->subtitle)
                        <h3 class="cont11__information__subtitle">{{ $content->subtitle }}</h3>
                    @endif

                    @if ($content->title || $content->subtitle)
                        <hr class="cont11__information__line">
                    @endif

                    @if ($content->text)
                        <div class="cont11__information__paragraph">
                            <p>
                                {!! $content->text !!}
                            </p>
                        </div>
                    @endif

                    @if ($content->link_button)
                        <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                            class="cont11__information__cta">
                            @if ($content->title_button)
                                {{ $content->title_button }}
                            @endif
                        </a>
                    @endif
                </div>
            @endif
        </section>
    @endforeach
@endif
