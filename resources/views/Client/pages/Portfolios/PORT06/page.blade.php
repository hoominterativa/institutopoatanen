@extends('Client.Core.client')
@section('content')
    <main id="root">
        @if ($banner->active_banner == 1)
            <section class="port06-page__banner"
                style="background-image: url({{ asset('storage/' . $banner->path_image_desktop_banner) }})">
                @if ($banner->subtitle_page)
                    <h2 class="port06-page__banner__subtitle">{{ $banner->subtitle_page }}</h2>
                @endif
                @if ($banner->title_page)
                    <h1 class="port06-page__banner__title">{{ $banner->title_page }}</h1>
                @endif
            </section>
        @endif
        <aside class="port06-page__categories">
            <menu class="port06-page__categories__swiper-wrapper swiper-wrapper">
                @foreach ($categories as $category)
                    <a class="port06-page__categories__item swiper-slide"
                        href="{{ route('port06.category.page', ['PORT06PortfoliosCategory' => $category->slug]) }}"
                        title="{{ $category->title }}">
                        {{ $category->title }}
                    </a>
                @endforeach
            </menu>
        </aside>
        @if ($portfolios->count())
            <section class="port06-page__list">
                @foreach ($portfolios as $portfolio)
                    <article class="port06-page__list__item">

                        <a class="link-full" title="{{ $portfolio->title }}"
                            href="{{ route('port06.show', ['PORT06Portfolios' => $portfolio->slug]) }}"></a>

                        <img src="{{ asset('storage/' . $portfolio->path_image_box) }}" alt="Imagem do [título do item]"
                            class="port06-page__list__item__image">
                        <span class="port06-page__list__item__category">{{ $portfolio->category->title }}</span>
                        @if ($portfolio->title)
                            <h4 class="port06-page__list__item__title">{{ $portfolio->title }}</h4>
                        @endif
                        @if ($portfolio->subtitle)
                            <p class="port06-page__list__item__paragraph">{{ $portfolio->subtitle }} </p>
                        @endif
                    </article>
                @endforeach

            </section>
        @endif
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
