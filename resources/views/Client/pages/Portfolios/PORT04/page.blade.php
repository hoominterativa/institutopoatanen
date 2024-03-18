@extends('Client.Core.client')
@section('content')
    <main class="port04-page" id="root">

        @if ($section->active_banner)
            @if ($section->title_banner || $section->subtitle_banner)
                <section class="port04-page__banner"
                    style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }})">

                    @if ($section->title_banner)
                        <h1 class="port04-page__banner__title">{{ $section->title_banner }}</h1>
                    @endif

                    @if ($section->subtitle_banner)
                        <h2 class="port04-page__banner__subtitle">{{ $section->subtitle_banner }}</h2>
                    @endif

                </section>
            @endif
        @endif


        <section class="port04-page__portfolio">
            @if ($section->active_content)
                @if ($section->subtitle_content || $section->title_content || $section->text_content)
                    <header class="port04-page__portfolio__header">
                        @if ($section->title_content)
                            <h2 class="port04-page__portfolio__header__title">{{ $section->title_content }}</h2>
                        @endif

                        @if ($section->subtitle_content)
                            <h3 class="port04-page__portfolio__header__subtitle">{{ $section->subtitle_content }}</h3>
                        @endif

                        @if ($section->text_content)
                            <div class="port04-page__portfolio__header__paragraph">
                                <p>
                                    {!! $section->text_content !!}
                                </p>
                            </div>
                        @endif
                    </header>
                @endif
            @endif

            @if ($categories->count())
                <aside class="port04-page__portfolio__categories">
                    <ul class="port04-page__portfolio__categories__swiper-wrapper swiper-wrapper">
                        @foreach ($categories as $category)
                            <li
                                class="{{ isset($category->selected) ? 'active' : '' }} port04-page__portfolio__categories__item swiper-slide">
                                <a title="{{ $category->title }}" class="link-full"
                                    href="{{ route('port04.category.page', ['PORT04PortfoliosCategory' => $category->slug]) }}">
                                </a>
                                @if ($category->path_image)
                                    <img class="port04-page__portfolio__categories__item__icon"
                                        src="{{ asset('storage/' . $category->path_image) }}"
                                        alt="Ícone da categoria {{ $category->title }}" loading="lazy">
                                @endif
                                {{ $category->title }}
                            </li>
                        @endforeach
                    </ul>
                </aside>
            @endif

            @if ($portfolios->count())
                <main class="port04-page__portfolio__main">
                    <div class="port04-page__portfolio__main__carousel">
                        <div class="port04-page__portfolio__main__carousel__swiper-wrapper swiper-wrapper">
                            @foreach ($portfolios as $portfolio)
                                <article class="port04-page__portfolio__main__item swiper-slide">
                                    <a class="link-full" title="{{ $portfolio->title }}"
                                        href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $portfolio->category->slug, 'PORT04Portfolios' => $portfolio->slug]) }}"></a>

                                    <img class="port04-page__portfolio__main__item__bg" loading= 'lazy'
                                        src="{{ asset('storage/' . $portfolio->path_image) }}"
                                        alt="Imagem de background do  {{ $portfolio->title }}">

                                    <div class="port04-page__portfolio__main__item__information">
                                        @if ($portfolio->title)
                                            <h4 class="port04-page__portfolio__main__item__information__title">
                                                {{ $portfolio->title }}</h4>
                                        @endif

                                        @if ($portfolio->description)
                                            <p class="port04-page__portfolio__main__item__information__description">
                                                {!! $portfolio->description !!}
                                            </p>
                                        @endif
                                    </div>

                                    <img class="port04-page__portfolio__main__item__container__icon"
                                        src="{{ asset('storage/' . $portfolio->path_image_icon) }}"
                                        alt="Ícone do portfólio {{ $portfolio->title }}"
                                        loading= 'lazy'
                                        >



                                </article>
                            @endforeach
                        </div>
                        <div class="port04-page__portfolio__main__carousel__swiper-pagination swiper-pagination"></div>
                    </div>

                </main>
            @endif
        </section>
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
