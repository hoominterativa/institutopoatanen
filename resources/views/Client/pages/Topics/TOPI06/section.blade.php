@if ($topics->count())
    <section id="TOPI06" class="topi06">
        @foreach ($topics as $topic)
            <article class="topi06__item">
                @if ($topic->path_image_desktop)
                    <img src="{{ asset('storage/' . $topic->path_image_desktop) }}" alt="Background"
                        class="topi06__item__bg">
                @endif


                @if ($topic->title || $topic->description)
                    <div class="topi06__item__information">
                        @if ($topic->title)
                            <h2 class="topi06__item__information__title">{{ $topic->title }}</h2>
                        @endif

                        @if ($topic->description)
                            <div class="topi06__item__information__paragraph">
                                <p>{{ $topic->description }}</p>
                            </div>
                        @endif

                        @if ($topic->link_button)
                            <a href="{{ getUri($topic->link_button) }}" target="{{ $topic->target_link_button }}"
                                class="topi06__item__information__cta">
                                {{ $topic->title_button }}
                            </a>
                        @endif
                    </div>
                @endif

                @if ($topic->path_image_icon)
                    <div class="topi06__item__icon">
                        <img src="{{ asset('storage/' . $topic->path_image_icon) }}" loading="lazy" class="topi06__item__icon__img"
                            alt="Ícone do tópico {{ $topic->title }}">
                    </div>
                @endif

            </article>
        @endforeach
    </section>
@endif
