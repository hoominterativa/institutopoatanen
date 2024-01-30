@if ($topics->count())
    <section id="TOPI01" class="topi01">
        @if ($section)
            @if ($section->title || $section->subtitle || $section->description)
                <header class="topi01__header">
                    @if ($section->title)
                        <h2 class="topi01__header__title">{{ $section->title }}</h2>
                    @endif

                    @if ($section->subtitle)
                        <h3 class="topi01__header__subtitle">{{ $section->subtitle }}</h3>
                    @endif

                    @if ($section->title || $section->subtitle)
                        <hr class="topi01__header__line">
                    @endif

                    @if ($section->description)
                        <p class="topi01__header__paragraph">{!! $section->description !!}</p>
                    @endif
                </header>
            @endif
        @endif
        <main class="topi01__topics">
            <div class="topi01__topics__swiper-wrapper swiper-wrapper">
                @foreach ($topics as $topic)
                    <article class="topi01__topics__item swiper-slide">
                        @if ($topic->link)
                            <a class="link-full" href="{{ getUri($topic->link) }}"
                                target="{{ $topic->target_link }}"></a>
                        @endif

                        @if ($topic->path_image)
                            <img src="{{ asset('storage/' . $topic->path_image) }}"
                                alt="imagem de fundo do  tópico {{ $topic->title }}" class="topi01__topics__item__bg">
                        @endif

                        @if ($topic->path_image_icon)
                            <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                class="topi01__topics__item__icon" alt="Ícone do item {{ $topic->title }}">
                        @endif

                        @if ($topic->title || $topic->description)
                            <h3 class="topi01__topics__item__title">{{ $topic->title }}</h3>
                            <p class="topi01__topics__item__paragraph">{!! $topic->description !!}</p>
                        @endif
                    </article>
                @endforeach

            </div>
        </main>

    </section>
@endif
