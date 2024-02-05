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
            <div class="accordion" id="accordion__topi11">
                @foreach ($topics as $topic)
                    <div class="topi11__wrapper__item accordion-item">
                        <h3 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $topic->id }}" aria-expanded="false"
                                aria-controls="collapseOne">
                                {{ $topic->title }}
                            </button>
                        </h3>
                        <div id="collapse-{{ $topic->id }}" class="accordion-collapse collapse"
                            aria-labelledby="headingOne" data-bs-parent="#accordion__topi11">
                            <div class="accordion-body">
                                {!! $topic->text !!}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

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
