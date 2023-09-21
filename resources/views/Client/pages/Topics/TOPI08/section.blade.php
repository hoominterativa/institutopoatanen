@if ($section)
    <section id="TOPI08" class="topi08 container-fluid"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
        <div class="container">
            <header class="topi08__header w-100">
                @if ($section->title || $section->subtitle)
                    <h2 class="topi08__header__title">{{ $section->title }}</h2>
                    <h3 class="topi08__header__subtitle">{{ $section->subtitle }}</h3>
                    <hr class="topi08__header__line">
                    <p class="topi08__header__desc">
                        <p>
                            {!! $section->description !!}
                        </p>
                    </p>
                @endif
            </header>
            @if ($topics->count())
                <main class="topi08__carousel owl-carousel">
                    @foreach ($topics as $topic)
                        <article class="topi08__item d-flex justify-content-end flex-column">
                            @if ($topic->path_image_box)
                                <img src="{{ asset('storage/' . $topic->path_image_box) }}"
                                    alt="imagem de fundo do tópico" class="topi08__item__bg">
                            @endif
                            <div class="topi08__item__content d-flex flex-column w-100 position-relative">
                                @if ($topic->title)
                                    <h3 class="topi08__item__title">{{ $topic->title }}</h3>
                                @endif
                                <div class="topi08__item__desc">
                                    @if ($topic->description)
                                        <p>{!! $topic->description !!}</p>
                                    @endif
                                    @if ($topic->link_button)
                                        <a href="{{ getUri($topic->link_button) }}"
                                            target="{{ $topic->target_link_button }}"
                                            @if (!$topic->link_button) style="cursor: default;" @endif
                                            class="topi08__item__cta">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                alt="Ícone do botão" class="topi08__item__cta__icon">
                                            @if ($topic->title_button)
                                                {{ $topic->title_button }}
                                            @endif
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </main>
            @endif
        </div>
    </section>
@endif
