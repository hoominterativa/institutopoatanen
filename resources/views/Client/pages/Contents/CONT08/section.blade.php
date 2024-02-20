@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT08" class="cont08">
            @if ($content->path_image)
                <div class="cont08__image">
                    <img class="cont08__image__img" src="{{ asset('storage/' . $content->path_image) }}"
                        alt="Imagem de apoio do conteúdo {{ $content->title }}">
                </div>
            @endif
            @if ($content->title || $content->subtitle || $content->text || $content->topics->count())
                <div class="cont08__information">
                    @if ($content->title || $content->subtitle || $content->text)
                        <header class="cont08__information__header">
                            @if ($content->title)
                                <h2 class="cont08__information__header__title">{{ $content->title }}</h2>
                            @endif

                            @if ($content->subtitle)
                                <h3 class="cont08__information__header__subtitle">{{ $content->subtitle }}</h3>
                            @endif

                            @if ($content->title || $content->subtitle)
                                <hr class="cont08__information__header__line">
                            @endif
                        </header>
                    @endif

                    @if ($content->text)
                        <div class="cont08__information__description">
                            {!! $content->text !!}
                        </div>
                    @endif

                    @if ($content->topics->count())
                        <div class="cont08__information__topics">
                            <div class="cont08__information__topics__swiper-wrapper swiper-wrapper">
                                @foreach ($content->topics as $topic)
                                    <article class="cont08__information__topics__item swiper-slide">

                                        @if ($topic->path_image)
                                            <img class="cont08__information__topics__item__icon"
                                                src="{{ asset('storage/' . $topic->path_image) }}"
                                                alt="Ícone do tópico">
                                        @endif

                                        @if ($topic->description)
                                            <div class="cont08__information__topics__item__description">
                                                {!! $topic->description !!}
                                            </div>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if ($content->link_button)
                        <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                            class="cont08__information__cta">
                            {{ $content->title_button }}
                        </a>
                    @endif

                </div>
            @endif
        </section>
    @endforeach
@endif
