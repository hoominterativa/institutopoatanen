@if ($section)
    <section id="TOPI08" class="topi08" {{-- OCULTAR NO PAINEL - REMOVER DO SISTEMA --}} {{--  style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};" --}}>
        @if ($section->title || $section->subtitle || $section->description)
            <header class="topi08__header">
                @if ($section->title)
                    <h2 class="topi08__header__title">{{ $section->title }}</h2>
                @endif

                @if ($section->subtitle)
                    <h3 class="topi08__header__subtitle">{{ $section->subtitle }}</h3>
                @endif

                @if ($section->title || $section->subtitle)
                    <hr class="topi08__header__line">
                @endif

                @if ($section->description)
                    <p class="topi08__header__paragraph">
                        {!! $section->description !!}
                    </p>
                @endif
            </header>
        @endif

        @if ($topics->count())
            <main class="topi08__topics">
                <div class="topi08__topics__swiper-wrapper swiper-wrapper">
                    @foreach ($topics as $topic)
                        <article class="topi08__topics__item swiper-slide hover-image-box">
                            @if ($topic->link_button)
                                <a href="{{ getUri($topic->link_button) }}" target="{{ $topic->target_link_button }}"
                                    class="link-full">
                                    {{-- BACKEND: ocultar no painel  --}}
                                    {{-- @if ($topic->title_button)
                                    {{ $topic->title_button }}
                                @endif --}}
                                </a>
                            @endif
                            @if ($topic->path_image)
                                <img src="{{ asset('storage/' . $topic->path_image) }}"
                                loading="lazy"
                                alt="imagem de fundo do tópico {{ $topic->title }}"
                                    class="topi08__topics__item__bg hover-image-box__target">
                            @endif

                            <div class="topi08__topics__item__content">
                                @if ($topic->title)
                                    <h3 class="topi08__topics__item__content__title">{{ $topic->title }}</h3>
                                @endif

                                @if ($topic->description)
                                    <div class="topi08__topics__item__content__information">
                                        {!! $topic->description !!}
                                    </div>
                                @endif

                            </div>
                        </article>
                    @endforeach

                </div>
                <div class="swiper-pagination"></div>
            </main>
        @endif

        @if ($section->link_button)
            <a href="{{ getUri($section->link_button) }}" target="{{ $section->target_link_button }}"
                class="topi08__cta">
                @if ($section->title_button)
                    {{ $section->title_button }}
                @endif
            </a>
        @endif

    </section>
@endif
