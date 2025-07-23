@if ($topics->count())
    <section id="TOPI11" class="topi11">
        @if ($section)
            @if ($section->title || $section->subtitle || $section->description)
                <header class="topi11__header">
                    @if ($section->title)
                        <h2 class="topi11__header__title">{{ $section->title }}</h2>
                    @endif

                    {{-- @if ($section->subtitle)
                        <h3 class="topi11__header__subtitle">{{ $section->subtitle }}</h3>
                    @endif

                    @if ($section->title || $section->subtitle)
                        <hr class="topi11__header__line">
                    @endif

                    @if ($section->description)
                        <div class="topi11__header__paragraph">{!! $section->description !!}</div>
                    @endif --}}
                </header>
            @endif
        @endif

        <main class="topi11__main">
            <div class="topi11__main__topics">
                @foreach ($topics as $topic)
                    <details class="topi11__main__topics__item">

                        <summary class="topi11__main__topics__item__title" aria-level="3" role="heading">
                            @if ($topic->path_image_icon)
                                <img class="topi11__main__topics__item__title__icon" loading="lazy" src="{{ asset('storage/'.$topic->path_image_icon) }}" alt="Ícone do tópico {{ $topic->title }}">
                            @endif
                            {{ $topic->title }}
                        </summary>

                        <div class="topi11__main__topics__item__paragraph details-content">
                            {!! $topic->text !!}
                        </div>

                    </details>
                @endforeach

            </div>

            @if ($image)
                @if ($image->path_image)
                    <div class="topi11__main__image">
                        <img src="{{ asset('storage/' . $image->path_image) }}" loading="lazy" class="topi11__main__image__img" alt="Imagem da seção {{ $image->title }}">
                    </div>
                @endif
            @endif

        </main>
    </section>
@endif
