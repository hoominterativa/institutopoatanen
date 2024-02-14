@if ($feedbacks->count())
    <section id="FEED01" class="feed01 container-fluid px-0">
        <div class="container container--feed01">
            @if ($section)
                <header class="feed01__header d-flex justify-content-center align-items-center">
                    @if ($section->title)
                        <h2 class="feed01__header__title mb-0">{{ $section->title }}</h2>
                    @endif
                </header>
            @endif
            <div class="feed01__content carousel-feed01 owl-carousel">
                @foreach ($feedbacks as $feedback)
                    <div class="feed01__content__item mx-auto text-center">
                        <div class="feed01__content__item__description text-center">
                            @if ($feedback->testimony)
                                <p>{!! $feedback->testimony !!}</p>
                            @endif
                        </div>
                        @if ($feedback->path_image)
                            <div class="feed01__content__item__image mx-auto">
                                <img src="{{ asset('storage/' . $feedback->path_image) }}" class="w-100 h-100" alt="Imagem Perfil">
                            </div>
                        @endif
                        @if ($feedback->name)
                            <h4 class="feed01__content__item__titulo">{{ $feedback->name }}</h4>
                        @endif
                        @if ($feedback->profession)
                            <h4 class="feed01__content__item__subtitulo mb-0">{{ $feedback->profession }}</h4>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
