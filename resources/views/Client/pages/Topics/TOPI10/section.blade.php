@if ($topics->count())
    <section id="TOPI10" class="topi10">
        @if ($section)
            @if ($section->title || $section->subtitle || $section->description)
                <header class="topi10__header">
                    @if ($section->title)
                        <h2 class="topi10__header__title">{{ $section->title }}</h2>
                    @endif

                    @if ($section->subtitle)
                        <span class="topi10__header__subtitle">{{ $section->subtitle }}</span>
                    @endif

                    @if ($section->title || $section->subtitle)
                        <hr class="topi10__header__line">
                    @endif

                    @if ($section->description)
                        <p class="topi10__header__paragraph">{!! $section->description !!}</p>
                    @endif
                </header>
            @endif
        @endif

        <div class="topi10__topics">
            @foreach ($topics as $topic)
                <article class="topi10__topics__item">

                    @if ($topic->path_image_box)
                        <img src="{{ asset('storage/' . $topic->path_image_box) }}"
                        loading="lazy" class="topi10__topics__item__bg"
                        alt="background do tópico {{ $topic->title }}">
                    @endif

                    @if ($topic->path_image_icon || $topic->title)
                        <header class="topi10__topics__item__header">
                            @if ($topic->path_image_icon)
                                <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                    alt="ícone do tópico {{ $topic->title }}"
                                    loading="lazy"
                                    class="topi10__topics__item__header__icon">
                            @endif


                            @if ($topic->title)
                                <h3 class="topi10__topics__item__header__title">{{ $topic->title }}</h3>
                            @endif
                        </header>
                    @endif

                    @if ($topic->description)
                        <div class="topi10__topics__item__paragraph">{!! $topic->description !!}</div>
                    @endif
                </article>
            @endforeach

        </div>

    </section>
@endif
