@if ($topics->count())
    <section id="TOPI05" class="topi05">

        @foreach ($topics as $topic)
            <article class="topi05__item">

                @if ($topic->link)
                    <a class="link-full" href="{{ getUri($topic->link) }}" target="{{ $topic->target_link }}"></a>
                @endif

                @if ($topic->path_image)
                    <img src="{{ asset('storage/' . $topic->path_image) }}" loading="lazy"
                        alt="Imagem do tópico {{ $topic->title }}" class="topi05__item__image">
                @endif

                @if ($topic->title)
                    <h2 class="topi05__item__title">{{ $topic->title }}</h2>
                @endif

                @if ($topic->description)
                    <div class="topi05__item__paragraph">

                        {!! $topic->description !!}

                    </div>
                @endif

            </article>
        @endforeach
    </section>

@endif
