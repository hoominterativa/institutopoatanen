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

        {{-- @if ($categories->count()) --}}
        {{-- BACKEND: As categorias não estão imprimindo. Para fazer o filtro eu criei a estrutura abaixo. Ai vc já sabe o que fazer 💕. --}}
        <aside class="port05__categories categories">
            <menu class="port05__categories__swiper-wrapper swiper-wrapper">
                @for ($i = 0; $i < 10; $i++)
                    <button data-category='categoria {{ $i }}' class="port05__categories__item swiper-slide categoryBtn"
                        title="categoria {{ $i }}">
                        Categoria {{ $i }}
                    </button>
                    {{-- @foreach ($categories as $category)
                        <li>
                            {{ $category->title }}
                            <a href="{{ route('port05.category.page', ['PORT05PortfoliosCategory' => $category->slug]) }}"
                                class="link-full" title="{{ $category->title }}"></a>
                        </li>
                    @endforeach --}}
                @endfor
            </menu>
        </aside>
        {{-- @endif --}}

        @if ($portfolios->count())
            <div class="port05__list">
                @foreach ($portfolios as $portfolio)
                    @for ($i = 0; $i < 10; $i++)
                    {{-- BACKEND: O parametro do data-category pode ser o category-title, mas o script tem que ser revisado depois de consertar o link das categorias --}}
                        <figure class="port05__list__item item" data-category="categoria {{ $i }}">
                            {{-- BACKEND: O link aqui tbm não está funcionando --}}
                            @foreach ($portfolio->categories as $category)
                                <a href="{{ route('port05.show', ['PORT05PortfoliosCategory' => $category->slug, 'PORT05Portfolios' => $portfolio->slug]) }}"
                                    class="link-full" title="{{ $portfolio->title }}"></a>
                            @endforeach

                            @if ($portfolio->path_image)
                                <img
                                class="port05__list__item__image"
                                src="{{ asset('storage/' . $portfolio->path_image) }}"
                                    alt="Imagem do {{ $portfolio->title }}" loading="lazy">
                            @endif

                            <figcaption class="port05__list__item__description">
                                {{ $portfolio->title }}
                            </figcaption>
                        </figure>
                    @endfor
                @endforeach
            </div>
        @endif


        <a title="ver todos os projetos" href="{{ route('port05.page') }}" class="port05__cta">
            Ver todos
        </a>
    </section>

@endif
