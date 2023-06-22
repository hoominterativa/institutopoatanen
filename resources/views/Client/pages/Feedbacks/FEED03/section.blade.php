@if ($section)
    <section id="FEED03" class="feed03 container-fluid px-0"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
        <div class="container container--feed03">
            @if ($section->subtitle || $section->title || $section->path_image_icon)
                <header class="feed03__header d-flex justify-content-center align-items-center">
                    <div class="feed03__header__image">
                        @if ($section->path_image_icon)
                            <img src="{{ asset('storage/' . $section->path_image_icon) }}" class="w-100 h-100"
                                alt="Ícone">
                        @endif
                    </div>
                    <div class="feed03__header__texto d-flex flex-column align-align-items-end">
                        @if ($section->subtitle || $section->title)
                            <h3 class="feed03__header__texto__subtitle">{{ $section->subtitle }}</h3>
                            <h2 class="feed03__header__texto__title mb-0">{{ $section->title }}</h2>
                            {{-- <hr class="feed03__header__texto__line"> --}}
                        @endif
                    </div>
                </header>
            @endif
            @if ($feedbacks->count())
                <div class="feed03__content carousel-feed03 owl-carousel">
                    @foreach ($feedbacks as $feedback)
                        <div class="feed03__content__item w-100">
                            <div class="feed03__content__item__top d-flex justify-content-center align-items-center">
                                <div class="feed03__content__item__top__image">
                                    @if ($feedback->path_image_icon)
                                        <img src="{{ asset('storage/' . $feedback->path_image_icon) }}"
                                            class="w-100 h-100" alt="Imagem Perfil">
                                    @endif
                                </div>
                                @if ($feedback->name)
                                    <h4 class="feed03__content__item__top__titulo mb-0">{{ $feedback->name }}</h4>
                                @endif
                            </div>
                            <div class="feed03__content__item__description text-center">
                                @if ($feedback->testimony)
                                    <p>
                                        {!! $feedback->testimony !!}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
