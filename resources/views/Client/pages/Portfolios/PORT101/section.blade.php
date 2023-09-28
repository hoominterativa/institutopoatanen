@if ($sections)
    <section id="PORT101" class="port101 container-fluid px-0"
        style="background-image:url({{ asset('storage/' . $sections->path_image_desktop) }});">
        <div class="container container--pd">
            @if ($sections->title || $sections->subtitle)
                <header class="port101__emcompass text-center">
                    <h2 class="port101__emcompass__title">{{ $sections->title }}</h2>
                    <h3 class="port101__emcompass__subtitle">{{ $sections->subtitle }}</h3>
                    <hr class="port101__emcompass__line" />
                </header>
            @endif
            {{-- END .port101__emcompass --}}
            @if ($portfolios->count())
                <div class="port101__content carousel-port101 owl-carousel">
                    @foreach ($portfolios as $portfolio)
                        <div class="port101__content__box" data-modal="#lightbox-port101-{{ $portfolio->id }}">
                            <div class="port101__content__box__image">
                                <img src="{{ asset('storage/' . $portfolio->path_image_box) }}" alt="Título Tópico">
                            </div>
                            <div class="port101__content__box__description">
                                @if ($portfolio->title)
                                    <h4 class="port101__content__box__description__title">{{ $portfolio->title }}</h4>
                                @endif
                                @if ($portfolio->description)
                                    <div class="port101__content__box__description__paragraph">
                                        <p>
                                            {{ $portfolio->description }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- END .port101__content__box --}}
                    @endforeach
                </div>
                {{-- END .carousel-port101 --}}
            @endif
            @foreach ($portfolios as $portfolio)
                @include('Client.pages.Portfolios.PORT101.show', [
                    'portfolio' => $portfolio,
                ])
            @endforeach
        </div>
        {{-- END .container --}}
    </section>
    {{-- END .port101 --}}
@endif
