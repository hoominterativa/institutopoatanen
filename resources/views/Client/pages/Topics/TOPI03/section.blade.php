@if ($section || $topics->count())
    <section id="TOPI03" class="topi03">
        @if ($section)
            @if ($section->title || $section->subtitle || $section->description)
                <header class="topi03__header">
                    @if ($section->title)
                        <h2 class="topi03__header__title">{{ $section->title }}</h2>
                    @endif

                    @if ($section->subtitle)
                        <h3 class="topi03__header__subtitle">{{ $section->subtitle }}</h3>
                    @endif

                    @if ($section->title || $section->subtitle)
                        <hr class="topi03__header__line">
                    @endif

                    @if ($section->description)
                        <div class="topi03__header__paragraph">{!! $section->description !!}</div>
                    @endif
                </header>
            @endif
        @endif

        @if ($topics->count())
            <main class="topi03__topics">
                @foreach ($topics as $topic)
                    <article class="topi03__topics__item">
                        @if ($topic->link)
                            <a class="link-full" href="{{ getUri($topic->link) }}"
                                target="{{ $topic->target_link }}"></a>
                        @endif

                        @if ($topic->path_image_icon)
                            <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                class="topi03__topics__item__icon" alt="ícone do tópico {{ $topic->title }}">
                        @endif

                        @if ($topic->title)
                            <h3 class="topi03__topics__item__title">{{ $topic->title }}</h3>
                        @endif

                        @if ($topic->description)
                            <p class="topi03__topics__item__paragraph">{!! $topic->description !!}</p>
                        @endif

                    </article>
                @endforeach
            </main>
        @endif
    </section>
@endif
