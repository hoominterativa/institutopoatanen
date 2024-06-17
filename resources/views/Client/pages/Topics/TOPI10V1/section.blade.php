@if ($topics->count())
    <section id="TOPI10V1" class="topi10v1">
        @if ($section)
            @if ($section->title || $section->subtitle || $section->description)
                <header class="topi10v1__header">
                    @if ($section->title)
                        <h2 class="topi10v1__header__title">{{ $section->title }}</h2>
                    @endif

                    @if ($section->subtitle)
                        <h3 class="topi10v1__header__subtitle">{{ $section->subtitle }}</h3>
                    @endif

                    @if ($section->description)
                        <p class="topi10v1__header__paragraph">{!! $section->description !!}</p>
                    @endif
                </header>
            @endif
        @endif

        <div class="topi10v1__topics">
            @foreach ($topics as $topic)
                <article class="topi10v1__topics__item">

                    @if ($topic->path_image_box)
                        <img src="{{ asset('storage/' . $topic->path_image_box) }}" loading="lazy"
                            class="topi10v1__topics__item__bg" alt="background do tópico {{ $topic->title }}">
                    @endif

                    @if ($topic->path_image_icon || $topic->title)
                        <header class="topi10v1__topics__item__header">
                            @if ($topic->path_image_icon)
                                <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                    alt="ícone do tópico {{ $topic->title }}" loading="lazy"
                                    class="topi10v1__topics__item__header__icon">
                            @endif


                            @if ($topic->title)
                                <h3 class="topi10v1__topics__item__header__title">{{ $topic->title }}</h3>
                            @endif
                        </header>
                    @endif

                    @if ($topic->description)
                        <div class="topi10v1__topics__item__paragraph">{!! $topic->description !!}</div>
                    @endif
                </article>
            @endforeach

        </div>

    </section>
@endif
