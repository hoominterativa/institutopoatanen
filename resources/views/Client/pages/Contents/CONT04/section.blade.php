@if ($section)
    <section id="CONT04" class="cont04">
        @if ($section->title || $section->subtitle || $section->description)
            <header class="cont04__header">
                <h2 class="cont04__header__title">{{ $section->title }}</h2>
                <h3 class="cont04__header__subtitle">{{ $section->subtitle }}</h3>
                <hr class="cont04__header__line">

                <div class="cont04__header__paragraph">
                    @if ($section->description)
                        <p>
                            {!! $section->description !!}
                        </p>
                    @endif
                </div>
            </header>
        @endif
        @if ($content)
            <main class="cont04__main">
                @if ($content->path_image)
                    <img src="{{ asset('storage/' . $content->path_image) }}" loading="lazy" alt="Imagem de apoio do {{ $content->title }}" class="cont04__main__image">
                @endif


                <div class="cont04__main__information">
                    @if ($content->subtitle)
                        <h5 class="cont04__main__information__subtitle">{{ $content->subtitle }}</h5>
                    @endif

                    @if ($content->title)
                        <h4 class="cont04__main__information__title">{{ $content->title }}</h4>
                    @endif

                    @if ($content->title || $content->subtitle)
                        <hr class="cont04__main__information__line">
                    @endif

                    @if ($content->description)
                        <div class="cont04__main__information__paragraph">
                            <p>
                                {!! $content->description !!}
                            </p>
                        </div>
                    @endif

                    @if ($content->link_button)
                        <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                            class="cont04__main__information__cta">
                            @if ($content->title_button)
                                {{ $content->title_button }}
                            @endif
                        </a>
                    @endif
                </div>
            </main>
        @endif

    </section>
@endif
