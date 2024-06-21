@if ($topics->count() || $section)
    <section id="TOPI13" class="topi13">

        @if ($section)
            <header class="topi13__header">
                @if ($section->title)
                    <h2 class="topi13__header__title">{{ $section->title }}</h2>
                @endif
                @if ($section->subtitle)
                    <h3 class="topi13__header__subtitle">{{ $section->subtitle }}</h3>
                @endif
            </header>
        @endif
        @if ($topics->count())
        <div class="topi13__container splide">
            <div class="topi13__container__topics splide__track">
                <div class="topi13__container__topics__list splide__list">
                    @foreach ($topics as $topic)
                        {{-- BACKEND: Precisa-se cadastrar um bg para a seção (cor e img), pois quando o slide for alterado vai ter essa mudança --}}
                        <div class="topi13__container__topics__list__item splide__slide"
                            @if ($topic->path_image_mobile) data-bg-mobile="{{ asset('storage/' . $topic->path_image_mobile) }}" @endif
                            @if ($topic->path_image_desktop) data-bg-desktop="{{ asset('storage/' . $topic->path_image_desktop) }}" @endif
                            @if ($topic->color) data-color="{{ $topic->color }}" @endif>

                            @if ($topic->path_image_icon)
                                <img class="topi13__container__topics__list__item__image"
                                    src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="Ícone do tópico">
                            @endif

                            <div class="topi13__container__topics__list__item__information">
                                @if ($topic->text)
                                    <div class="topi13__container__topics__list__item__information__paragraph">
                                        {!! $topic->text !!}
                                    </div>
                                @endif

                                @if ($topic->link_button)
                                    <a class="topi13__container__topics__list__item__information__cta"
                                        href="{{ getUri($topic->link_button) }}" target="{{ $topic->target_link }}">
                                        {{ $topic->title_button }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </section>
@endif
