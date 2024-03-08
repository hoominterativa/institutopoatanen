@if ($section || $topics->count())
    <section id="TOPI02" class="topi02"
    {{-- BACKEND: Ocultar do painel esses itens --}}
    {{-- style="background-image: url({{asset('storage/'.$section->path_image_background)}}); background-color: {{$section->background_color}};" --}}>
        @if ($section)
            @if ($section->title || $section->subtitle || $section->description)
                <header class="topi02__header">
                    @if ($section->title)
                        <h2 class="topi02__header__title">{{ $section->title }}</h2>
                    @endif

                    @if ($section->subtitle)
                        <h3 class="topi02__header__subtitle">{{ $section->subtitle }}</h3>
                    @endif

                    @if ($section->description)
                        <div class="topi02__header__paragraph">{!! $section->description !!}</div>
                    @endif
                </header>
            @endif
        @endif

        @if ($topics->count())
            <main class="topi02__topics">
                <div class="topi02__topics__carousel">
                    <div class="topi02__topics__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($topics as $topic)
                            <article class="topi02__topics__item swiper-slide">

                                @if ($topic->link)
                                    <a
                                    title="{{ $topic->title }}"
                                    class="link-full" href="{{ getUri($topic->link) }}"
                                        target="{{ $topic->target_link }}"></a>
                                @endif

                                @if ($topic->path_image)
                                    <img src="{{ asset('storage/' . $topic->path_image) }}"
                                        alt="imagem de fundo do  tópico {{ $topic->title }}" loading="lazy"
                                        class="topi02__topics__item__bg">
                                @endif


                                @if ($topic->path_image_icon)
                                    <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                        class="topi02__topics__item__icon" loading="lazy"
                                        alt="Ícone do item {{ $topic->title }}">
                                @endif


                                @if ($topic->title || $topic->description)
                                    <h3 class="topi02__topics__item__title">{{ $topic->title }}</h3>
                                    <p class="topi02__topics__item__paragraph">{!! $topic->description !!}</p>
                                @endif
                            </article>
                        @endforeach

                    </div>

                </div>

            </main>
        @endif
    </section>
@endif
