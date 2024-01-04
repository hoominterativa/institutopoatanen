<section id="TOPI08" class="topi08 container-fluid"
    style="background-image: url({{ asset('storage/' . isset($section->path_image_desktop)) }}); background-color: {{ isset($section->background_color) }};">
    <div class="container">
        @if ($section)
            <header class="topi08__header w-100">
                @if ($section->title || $section->subtitle)
                    <h2 class="topi08__header__title">{{ $section->title }}</h2>
                    <h3 class="topi08__header__subtitle">{{ $section->subtitle }}</h3>
                    <hr class="topi08__header__line">
                @endif
                @if ($section->description)
                    <p class="topi08__header__desc">
                        <p>
                            {!! $section->description !!}
                        </p>
                    </p>
                @endif
            </header>
        @endif
        @if ($topics->count())
            <main class="topi08__carousel owl-carousel">
                @foreach ($topics as $topic)
                    <article class="topi08__item d-flex justify-content-end flex-column">
                        @if ($topic->path_image)
                            <img src="{{ asset('storage/' . $topic->path_image) }}" alt="imagem de fundo do tópico" class="topi08__item__bg">
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
                                    <a href="{{ getUri($topic->link_button) }}" target="{{ $topic->target_link_button }}" class="topi08__item__cta">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícone do botão" class="topi08__item__cta__icon">
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
        {{-- Área do botão nova, favor ajustar o CSS de acordo com o layout --}}
        @if (isset($section->link_button))
            <a href="{{ getUri($section->link_button) }}" target="{{ $section->target_link_button }}" class="">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícone do botão" class="topi08__item__cta__icon">
                @if ($section->title_button)
                    {{ $section->title_button }}
                @endif
            </a>
        @endif
    </div>
</section>

