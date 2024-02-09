@if ($section)
    <section id="TOPI101" class="topi101">
        @if ($section->title || $section->subtitle)
            <header class="topi101__header">
                @if ($section->title)
                    <h2 class="topi101__header__title">{{ $section->title }}</h4>
                @endif

                @if ($section->subtitle)
                    <h3 class="topi101__header__subtitle">{{ $section->subtitle }}</h3>
                @endif

                @if ($section->title || $section->subtitle)
                    <hr class="topi101__header__line">
                @endif
            </header>
        @endif


        @if ($topics->count())
            <main class="topi101__timeline">
                <div class="topi101__timeline__swiper-wrapper swiper-wrapper">
                    @foreach ($topics as $topic)
                        @if ($topic->path_image && $topic->description)
                            <article class="topi101__timeline__item swiper-slide">

                                <div class="topi101__timeline__item__image">
                                    <img src="{{ asset('storage/' . $topic->path_image) }}" loading="lazy" alt="Imagem do tópico {{ $topic->description }}"
                                        class="topi101__timeline__item__image__img">
                                </div>

                                <div class="topi101__timeline__item__information">
                                    <div class="topi101__timeline__item__information__paragraph">
                                        {!! $topic->description !!}
                                    </div>
                                </div>

                            </article>
                        @endif
                    @endforeach
                </div>
                <div class="topi101__timeline__nav">
                    <div class="topi101__timeline__nav__swiper-button-prev swiper-button-prev"></div>
                    <div class="topi101__timeline__nav__swiper-button-next swiper-button-next"></div>
                </div>
            </main>


        @endif

        </div>

    </section>
@endif
