@if ($categories->count() || $portfolios->count() || $section)
    <section id="PORT05" class="port05">
        @if ($section)
            <header class="port05__header">
                @if ($section->title_section)
                    <h2 class="port05__header__title">{{ $section->title_section }}</h2>
                @endif

                @if ($section->subtitle_section)
                    <h3 class="port05__header__subtitle">{{ $section->subtitle_section }}</h3>
                @endif
            </header>
        @endif

        @if ($categories->count())
            <aside class="port05__categories categories">
                <menu class="port05__categories__swiper-wrapper swiper-wrapper">

                    @foreach ($categories as $category)
                        <button data-category='{{$category->id}}' class="port05__categories__item swiper-slide categoryBtn">
                            {{ $category->title }}
                        </button>
                    @endforeach
                </menu>
            </aside>
        @endif

        @if ($portfolios->count())
            <div class="port05__list">
                @foreach ($portfolios as $portfolio)
                    <figure class="port05__list__item category__item" data-category="{{ $portfolio->categoryIds }}">
                        <a href="{{ route('port05.show', ['PORT05Portfolios' => $portfolio->slug]) }}" class="link-full" title="{{ $portfolio->title }}"></a>
                        @if ($portfolio->path_image)
                            <img class="port05__list__item__image"
                                src="{{ asset('storage/' . $portfolio->path_image) }}"
                                alt="Imagem do {{ $portfolio->title }}" loading="lazy">
                        @endif
                        <figcaption class="port05__list__item__description">
                            {{ $portfolio->title }}
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @endif

        <a title="ver todos os projetos" href="{{ route('port05.page') }}" class="port05__cta">
            Ver todos
        </a>
    </section>

@endif
