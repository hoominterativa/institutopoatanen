@if ($feedbacks->count())
    <section id="FEED03" class="feed03">
        @if ($section)
            <header class="feed03__header">
                {{-- <div class="feed03__header__image">
                    @if ($section->path_image_icon)
                        <img src="{{ asset('storage/' . $section->path_image_icon) }}" class="w-100 h-100" alt="Ícone">
                    @endif
                </div> --}}
                <div class="feed03__header__texto">
                    @if ($section->subtitle || $section->title)
                        {{-- <h3 class="feed03__header__texto__subtitle">{{ $section->subtitle }}</h3> --}}
                        <h2 class="feed03__header__texto__title animation fadeInLeft">{{ $section->title }}</h2>
                        <hr class="feed03__header__texto__line">
                    @endif
                </div>
            </header>
        @endif
        <div class="feed03__content carousel-feed03 owl-carousel">
            @foreach ($feedbacks as $feedback)
                <div class="feed03__content__item animation fadeInLeft">
                    <div class="feed03__content__item__top">
                        <div class="feed03__content__item__top__image">
                            @if ($feedback->path_image_icon)
                                <img src="{{ asset('storage/' . $feedback->path_image_icon) }}" class="w-100 h-100" alt="Imagem Perfil">
                            @endif
                        </div>
                    </div>
                    <div class="feed03__content__item__right">
                        @if ($feedback->name)
                            <h4 class="feed03__content__item__right__titulo">{{ $feedback->name }}</h4>
                        @endif

                            <h3 class="feed03__content__item__right__subtitulo">Médica</h3>

                        @if ($feedback->testimony)
                            <div class="feed03__content__item__right__description">
                                <p>{!! $feedback->testimony !!}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif

