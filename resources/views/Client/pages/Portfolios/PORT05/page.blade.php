@extends('Client.Core.client')
@section('content')
    <main id="root" class="port05-page">
        @if ($banner)
            <section class="port05-page__banner"
                style="background-image: url({{ asset('storage/' . $banner->path_image_desktop_banner) }});">
                @if ($banner->title_banner)
                    <h1 class="port05-page__banner__title">{{ $banner->title_banner }}</h1>
                @endif
            </section>
        @endif
        <section class="port05-page__content">
            {{-- BACKEND ADD ESSE TÍTULO QUE FICOU FALTANDO --}}
            <h2 class="port05-page__content__title">Título</h2>
            @if ($categories->count())
                <div class="port05-page__content__categories">
                    <menu class="port05-page__content__categories__swiper-wrapper swiper-wrapper">
                        @foreach ($categories as $category)
                            <a class="port05-page__content__categories__item swiper-slide"
                                href="{{ route('port05.category.page', ['PORT05PortfoliosCategory' => $category->slug]) }}"
                                title="{{ $category->title }}">
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </menu>
                </div>
            @endif
        </section>
        @if ($portfolios->count())
            <div class="port05-page__list">
                @foreach ($portfolios as $portfolio)
                    <figure class="port05-page__list__item" data-category="{{ $category->title }}">
                        <a href="{{ route('port05.show', ['PORT05Portfolios' => $portfolio->slug]) }}" class="link-full"
                            title="{{ $category->title }}"></a>

                        @if ($portfolio->path_image)
                            <img class="port05-page__list__item__image"
                                src="{{ asset('storage/' . $portfolio->path_image) }}"
                                alt="Ícone de {{ $portfolio->title }}" loading="lazy">
                        @endif

                        <figcaption class="port05-page__list__item__description">
                            {{ $portfolio->title }}
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @endif

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    @endsection
</main>
