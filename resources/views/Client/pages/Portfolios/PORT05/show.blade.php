@extends('Client.Core.client')

@section('content')
    <main id="root" class="port05-show">

        {{-- BEGIN Page content --}}
        @if ($portfolio->active_banner === 1)
            <section class="port05-show__banner"
                style="background-image: url({{ asset('storage/' . $portfolio->path_image_desktop_banner) }});">
                @if ($portfolio->title_banner)
                    <h1 class="port05-show__banner__title">{{ $portfolio->title_banner }}</h1>
                @endif
            </section>
        @endif

        <section class="port05-show__content">
            <h2 class="port05-show__content__title">{{ $portfolio->title }}</h2>

            @if ($portfolio->categories->count())
                <div class="port05-show__content__categories">
                    <menu class="port05-show__content__categories__swiper-wrapper swiper-wrapper">
                        @foreach ($portfolio->categories as $category)
                            <a class="port05-show__content__categories__item swiper-slide"
                                href="{{ route('port05.category.page', ['PORT05PortfoliosCategory' => $category->slug]) }}"
                                title="{{ $category->title }}">
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </menu>
                </div>
            @endif

            <div class="port05-show__content__paragraph">
                {!! $portfolio->description !!}
            </div>
        </section>

        @if ($galleries->count())
            <section class="port05-show__gallery">
                @foreach ($galleries->where('featured', false) as $gallery)
                    {{-- FRONTEND: Caso tenha $gallery->link_video, a imagem será usada como capa --}}
                    @if ($gallery->link_video)
                        <div class="port05-show__gallery__item">
                            <img class="port05-show__gallery__item__bg" src="{{ asset('storage/' . $gallery->path_image) }}"
                                alt="Imagem da galeria">

                            <button class="port05-show__gallery__item__button" data-src="{{ getUri($gallery->link_video) }}"
                                data-fancybox="gallery">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="117" viewBox="0 0 100 117"
                                    fill="none">
                                    <path d="M100 58.5L0.249995 116.091L0.25 0.909305L100 58.5Z" fill="#404040" />
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="port05-show__gallery__item">
                            <img class="port05-show__gallery__item__bg" src="{{ asset('storage/' . $gallery->path_image) }}"
                                data-fancybox="gallery" alt="Imagem da galeria">
                        </div>
                    @endif
                @endforeach

                @foreach ($galleries->where('featured', true) as $gallery)
                    {{-- FRONTEND: Caso tenha $gallery->link_video, a imagem será usada como capa --}}
                    @if ($gallery->link_video)
                        <div class="port05-show__gallery__item--highlighted">
                            <img class="port05-show__gallery__item__bg" src="{{ asset('storage/' . $gallery->path_image) }}"
                                alt="Imagem da galeria">

                            <button class="port05-show__gallery__item__button"
                                data-src="{{ getUri($gallery->link_video) }}" data-fancybox="gallery">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="117" viewBox="0 0 100 117"
                                    fill="none">
                                    <path d="M100 58.5L0.249995 116.091L0.25 0.909305L100 58.5Z" fill="#404040" />
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="port05-show__gallery__item--highlighted">
                            <img class="port05-show__gallery__item__bg"
                                src="{{ asset('storage/' . $gallery->path_image) }}" data-fancybox="gallery"
                                alt="Imagem da galeria">
                        </div>
                    @endif
                @endforeach
            </section>
        @endif

        @if ($testimonials->count())
            <section class="port05-show__feedback">
                <h2 class="port05-show__feedback__title">Depoimentos</h2>

                <div class="port05-show__feedback__carousel">
                    <div class="port05-show__feedback__carousel__swiper-wrapper swiper-wrapper">

                        @foreach ($testimonials as $testimonial)
                            <article class="port05-show__feedback__carousel__item swiper-slide">
                                @if ($testimonial->path_image)
                                    <img class="port05-show__feedback__carousel__item__image"
                                        src="{{ asset('storage/' . $testimonial->path_image) }}"
                                        alt="Imagem do {{ $testimonial->name }}">
                                @endif
                                <div class="port05-show__feedback__carousel__item__information">
                                    @if ($testimonial->name)
                                        <h3 class="port05-show__feedback__carousel__item__information__name">
                                            {{ $testimonial->name }}</h3>
                                    @endif
                                    @if ($testimonial->profession)
                                        <h4 class="port05-show__feedback__carousel__item__information__role">
                                            {{ $testimonial->profession }}</h4>
                                    @endif
                                    @if ($testimonial->feedback)
                                        <div class="port05-show__feedback__carousel__item__information__paragraph">
                                            {!! $testimonial->feedback !!}
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($portfolios->count())
            <section class="port05-show__related">
                <h2 class="port05-show__related__title">Relacionados</h2>

                <div class="port05-show__related__carousel">
                    <div class="port05-show__related__carousel__swiper-wrapper swiper-wrapper">

                        @foreach ($portfolios as $portfolio)
                            <figure class="port05-show__related__carousel__item swiper-slide">
                                <a href="{{ route('port05.show', ['PORT05Portfolios' => $portfolio->slug]) }}"
                                    class="link-full" title="{{ $category->title }}"></a>
                                @if ($portfolio->path_image)
                                    <img class="port05-show__related__carousel__item__image"
                                        src="{{ asset('storage/' . $portfolio->path_image) }}"
                                        alt="Ícone de {{ $portfolio->title }}" loading="lazy">
                                @endif
                                <figcaption class="port05-show__related__carousel__item__description">
                                    {{ $portfolio->title }}
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
