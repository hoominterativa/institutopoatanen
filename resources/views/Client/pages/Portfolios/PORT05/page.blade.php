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
        @if ($categories->count())
            <aside class="port05-page__categories">
                <menu class="port05-page__categories__swiper-wrapper swiper-wrapper">
                    @foreach ($categories as $category)
                        <button data-category="{{ $category->title }}"
                            class="port05-page__categories__item swiper-slide">
                            <a href="{{ route('port05.category.page', ['PORT05PortfoliosCategory' => $category->slug]) }}"
                                class="link-full" title="{{ $category->title }}"></a>
                            {{ $category->title }}
                        </button>
                    @endforeach
                </menu>
            </aside>
        @endif
        @if ($portfolios->count())
            <div class="port05-page__list">
                @foreach ($portfolios as $portfolio)
                    <figure class="port05-page__list__item" data-category="{{ $category->title }}">
                            <a href="{{ route('port05.show', ['PORT05Portfolios' => $portfolio->slug]) }}"
                                class="link-full" title="{{ $category->title }}"></a>

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
        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    @endsection
</main>
