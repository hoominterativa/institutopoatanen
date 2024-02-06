<section id="TOPI11" class="topi11">

    @if ($section)
        @if ($section->title || $section->subtitle || $section->description)
            <header class="topi11__header">
                @if ($section->title)
                    <h2 class="topi11__header__title">{{ $section->title }}</h2>
                @endif

                @if ($section->subtitle)
                    <h3 class="topi11__header__subtitle">{{ $section->subtitle }}</h3>
                @endif

                @if ($section->title || $section->subtitle)
                    <hr class="topi11__header__line">
                @endif

                @if ($section->description)
                    <div class="topi11__header__paragraph">{!! $section->description !!}</div>
                @endif
            </header>
        @endif
    @endif

    <main class="topi11__main">
        <div class="topi11__main__topics">
            @foreach ($topics as $topic)
                <details class="topi11__main__topics__item">


                    <summary class="topi11__main__topics__item__title" aria-level="3" role="heading">
                        {{-- BACKEND: INSERIR DE FORMA DINÂMICA A INCLUSÃO DO ÍCONE DO TÓPICO --}}
                        <img class="topi11__main__topics__item__title__icon" src="{{ asset('images/cta.png') }}"
                            alt="Ícone do tópico {{ $topic->title }}">
                        {{ $topic->title }}
                    </summary>


                    <div class="topi11__main__topics__item__paragraph details-content">
                        {!! $topic->text !!}
                    </div>


                </details>
            @endforeach


        </div>

        {{-- BACKEND: Retirar a validação da imagem. A imagem deve ser um elemento solto, não um filho da seção  --}}
        @if ($section)
            @if ($section->path_image)
                <div class="topi11__main__image">
                    <img src="{{ asset('storage/' . $section->path_image) }}" class="topi11__main__image__img"
                        alt="Imagem da seção {{ $section->title }}">
                </div>
            @endif
        @endif


    </main>
</section>
