<section id="PORT04" class="port04">
    @if ($section)
        <header class="port04__header container">
            @if ($section->title_section || $section->subtitle_section)
                <h3 class="port04__header__subtitle">{{ $section->subtitle_section }}</h3>
                <h2 class="port04__header__title">{{ $section->title_section }}</h2>
                <hr class="port04__header__line">
            @endif
            @if ($section->description_section)
                <p class="port04__header__description">
                    {!! $section->description_section !!}
                </p>
            @endif
        </header>
        @if ($portfolios->count())
            <section class="port04__portfolios d-flex flex-column container">
                <div class="port04__portfolios__carousel">
                    @foreach ($portfolios as $portfolio)
                        <article class="port04__portfolios__item">
                            <a class="d-flex flex-row align-items-end w-100"
                                href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $portfolio->category->slug, 'PORT04Portfolios' => $portfolio->slug]) }}">
                                <img src="{{ asset('storage/' . $portfolio->path_image) }}" alt="Imagem do portfólio"
                                    class="port04__portfolios__item__image">
                                <div class="port04__portfolios__item__container">
                                    <div class="port04__portfolios__item__container__header">
                                        @if ($portfolio->title)
                                            <h4 class="port04__portfolios__item__container__header__title ">
                                                {{ $portfolio->title }}
                                            </h4>
                                        @endif
                                        @if ($portfolio->description)
                                            <p class="port04__portfolios__item__container__header__description">
                                                {!! $portfolio->description !!}
                                            </p>
                                        @endif
                                    </div>
                                    <img src="{{ asset('storage/' . $portfolio->path_image_icon) }}"
                                        alt="Ícone do portfólio" class="port04__portfolios__item__container__icon transition">

                                </div>

                            </a>
                        </article>
                    @endforeach
                </div>
                <a class="port04__portfolios__cta" href="{{ route('port04.page') }}">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="me-2" alt="">
                    CTA
                </a>
            </section>
        @endif
    @endif
</section>
