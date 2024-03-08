@if ($topics->count())
    @foreach ($topics as $topic)
        <section class="topi04">

            @if ($topic->galleries->count())
                <div class="topi04__gallery">
                    <div class="topi04__gallery__image__swiper-wrapper swiper-wrapper">
                        @foreach ($topic->galleries as $gallery)
                            <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Galeria de imagens"
                                loading="lazy" class="topi04__gallery__image__img swiper-slide">
                        @endforeach
                    </div>
                    <div class="topi04__gallery__nav">
                        <div class="topi04__gallery__nav__swiper-button-prev swiper-button-prev"></div>
                        <div class="topi04__gallery__nav__swiper-button-next swiper-button-next"></div>
                    </div>
                </div>
            @endif
            @if (
                $topic->title_topic ||
                    $topic->title ||
                    $topic->subtitle ||
                    $topic->description ||
                    $topic->topicSections->count() > 0)
                <div class="topi04__information">
                    @if ($topic->title_topic || $topic->title || $topic->subtitle || $topic->description)
                        <header class="topi04__information__header">

                            @if ($topic->title_topic)
                                <h2 class="topi04__information__header__featured-title">{{ $topic->title_topic }}</h2>
                            @endif

                            @if ($topic->title)
                                <h3 class="topi04__information__header__title">{{ $topic->title }}</h3>
                            @endif

                            @if ($topic->subtitle)
                                <h4 class="topi04__information__header__subtitle">{{ $topic->subtitle }}</h4>
                            @endif

                            @if ($topic->description)
                                <p class="topi04__information__header__paragraph">
                                    {!! $topic->description !!}
                                </p>
                            @endif

                            @if ($topic->link_button)
                                <a title="{{ $topic->title_button }}" href="{{ getUri($topic->link_button) }}"
                                    target="{{ $topic->target_link_button }}" class="topi04__information__header__cta">
                                    @if ($topic->title_button)
                                        {{ $topic->title_button }}
                                    @endif
                                </a>
                            @endif
                        </header>
                    @endif

                    @if ($topic->topicSections->count() > 0)
                        <div class="topi04__information__topics">
                            <div class="topi04__information__topics__carousel">
                                <div class="topi04__information__topics__carousel__swiper-wrapper swiper-wrapper">

                                    @foreach ($topic->topicSections as $topicSection)
                                        <article class="topi04__information__topics__item swiper-slide">
                                            @if ($topicSection->path_image_box)
                                                <img src="{{ asset('storage/' . $topicSection->path_image_box) }}"
                                                    alt="Imagem de fundo do topico {{ $topicSection->title }}"
                                                    loading="lazy" class="topi04__information__topics__item__image">
                                            @endif

                                            @if ($topicSection->path_image_icon)
                                                <img src="{{ asset('storage/' . $topicSection->path_image_icon) }}"
                                                    loading="lazy" class="topi04__information__topics__item__icon"
                                                    alt="Ícone do tópico {{ $topicSection->title }}">
                                            @endif

                                            @if ($topicSection->title)
                                                <h5 class="topi04__information__topics__item__title">
                                                    {{ $topicSection->title }}
                                                </h5>
                                            @endif

                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </section>
    @endforeach

@endif
