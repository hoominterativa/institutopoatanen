@if ($section && $contents->count() > 0)
    <section id="CONT07" class="cont07"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">

        @if ($section->title_section || $section->subtitle_seciton)
            <header class="cont07__header text-center">
                @if ($section->title_section)
                    <h2 class="cont07__header__title">{{ $section->title_section }}</h2>
                @endif

                @if ($section->subtitle_section)
                    <h3 class="cont07__header__subtitle">{{ $section->subtitle_section }}</h3>
                @endif

            </header>
        @endif


        <main class="cont07__video">
            <button title="play" class="cont07__video__button">
                <img class="cont07__video__button__icon" src="{{ asset('storage/uploads/tmp/play.png') }}"
                    alt="Play Vídeo">
            </button>

        </main>


        <div class="cont07__gallery">
            <div class="cont07__gallery__carousel">
                <div class="cont07__gallery__swiper-wrapper swiper-wrapper">
                    @foreach ($contents as $content)
                        <div class="cont07__gallery__item swiper-slide" data-src="{{ getUri($content->link_video) }}"
                            data-fancybox="galeria-video">
                            @if ($content->link_video)
                                @if ($content->path_image)
                                    <img loading='lazy' alt="imagem de background" class="cont07__gallery__item__bg"
                                        src="{{ asset('storage/' . $content->path_image) }}" />
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="cont07__gallery__nav">
                <div class="cont07__gallery__nav__swiper-button-prev swiper-button-prev"></div>
                <div class="cont07__gallery__nav__swiper-button-next swiper-button-next"></div>
            </div>

        </div>


        @if ($section->link_button)
            <a title="{{ $section->title_button }}" href="{{ getUri($section->link_button) }}"
                target="{{ $section->target_link_button }}" class="cont07__cta">
                @if ($section->title_button)
                    {{ $section->title_button }}
                @endif
            </a>
        @endif
    </section>
@endif
{{-- END #cont07 --}}
