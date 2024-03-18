<section id="PORT04" class="port04">
    @if ($section)
        @if ($section->title_section || $section->subtitle_section || $section->text_section)
            <header class="port04__header ">
                @if ($section->title_section)
                    <h2 class="port04__header__title">{{ $section->title_section }}</h2>
                @endif

                @if ($section->subtitle_section)
                    <h3 class="port04__header__subtitle">{{ $section->subtitle_section }}</h3>
                @endif

                @if ($section->text_section)
                    <div class="port04__header__paragraph">
                        <p>
                            {!! $section->text_section !!}
                        </p>
                    </div>
                @endif
            </header>
        @endif
        @if ($portfolios->count())
            <main class="port04__portfolios">
                <div class="port04__portfolios__carousel">
                    <div class="port04__portfolios__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($portfolios as $portfolio)
                            <article class="port04__portfolios__item swiper-slide">
                                <a class="link-full" title="{{ $portfolio->title }}"
                                    href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $portfolio->category->slug, 'PORT04Portfolios' => $portfolio->slug]) }}"></a>

                                <img src="{{ asset('storage/' . $portfolio->path_image) }}"
                                    alt="Imagem de background do  {{ $portfolio->title }}" loading= 'lazy'
                                    class="port04__portfolios__item__bg">

                                <div class="port04__portfolios__item__information">
                                    @if ($portfolio->title)
                                        <h4 class="port04__portfolios__item__information__title">
                                            {{ $portfolio->title }}
                                        </h4>
                                    @endif
                                    @if ($portfolio->description)
                                        <div class="port04__portfolios__item__information__description">
                                            <p>
                                                {!! $portfolio->description !!}
                                            </p>
                                        </div>
                                    @endif
                                </div>


                                <img  class="port04__portfolios__item__icon"
                                src="{{ asset('storage/' . $portfolio->path_image_icon) }}" loading="lazy"
                                    alt="Ícone do item {{ $portfolio->title }}"
                                   >


                            </article>
                        @endforeach
                    </div>
                    <div class="port04__portfolios__carousel__swiper-pagination swiper-pagination"></div>
                </div>

                <a title="Página de portifólios" class="port04__portfolios__cta" href="{{ route('port04.page') }}">
                    CTA
                </a>
            </main>
        @endif
    @endif
</section>
