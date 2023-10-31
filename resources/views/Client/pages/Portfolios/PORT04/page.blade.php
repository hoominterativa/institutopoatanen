@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root">
        <section class="port04-page">
            <header class="port04-page__banner container-fluid px-0">
                <div class="port04-page__banner__container">
                    @if ($section->active_banner)
                        <div class="port04-page__banner__image"
                            style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }});  background-color: {{ $section->background_color_banner }};">
                            @if ($section->title_banner || $section->subtitle_banner)
                                <div class="container port04-page__banner__header">
                                    <h4 class="port04-page__banner__header__subtitle">{{ $section->subtitle_banner }}</h4>
                                    <h3 class="port04-page__banner__header__title">{{ $section->title_banner }}</h3>
                                    <hr class="port04-page__banner__header__line">
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </header>
            <main class="port04-page__portfolio">
                <div class="container">
                    <div class="port04-page__portfolio__header">
                        @if ($section->active_content)
                            @if ($section->subtitle_content || $section->title_content)
                                <h2 class="port04-page__portfolio__header__subtitle">{{ $section->title_content }}</h2>
                                <h1 class="port04-page__portfolio__header__title">{{ $section->subtitle_content }}</h1>
                                <hr class="port04-page__portfolio__header__line">
                            @endif
                            @if ($section->text_content)
                                <div class="port04-page__portfolio__header__description">
                                    <p>
                                        {!! $section->text_content !!}
                                    </p>
                                </div>
                            @endif
                        @endif
                        @if ($categories->count())
                            <nav class="port04-page__portfolio__categories">
                                <ul class="port04-page__portfolio__categories__list w-100">
                                    <div class="port04-page__portfolio__categories__carousel">
                                        @foreach ($categories as $category)
                                            <li
                                                class=" {{ isset($category->selected) ? 'active' : '' }} port04-page__portfolio__categories__list__item">
                                                <a class=" d-flex w-100 h-100 justify-content-between align-items-center"
                                                    href="{{ route('port04.category.page', ['PORT04PortfoliosCategory' => $category->slug]) }}">
                                                    @if ($category->path_image)
                                                        <img src="{{ asset('storage/' . $category->path_image) }}"
                                                            alt="Ícone da categoria"
                                                            class="port04-page__portfolio__categories__list__item__icon">
                                                    @endif
                                                    {{ $category->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </div>
                                </ul>

                                <div class="port04-page__portfolio__categories__dropdown-mobile">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2
                                                class="accordion-header port04-page__portfolio__categories__dropdown-mobile__item">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                        alt=""
                                                        class="port04-page__portfolio__categories__dropdown-mobile__item__icon">
                                                    Categorias
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <ul>
                                                        @foreach ($categories as $category)
                                                            <li
                                                                class="port04-page__portfolio__categories__dropdown-mobile__item">
                                                                <a class=" d-flex w-100 h-100 justify-content-start align-items-center"
                                                                    href="{{ route('port04.category.page', ['PORT04PortfoliosCategory' => $category->slug]) }}">
                                                                    @if ($category->path_image)
                                                                        <img src="{{ asset('storage/' . $category->path_image) }}"
                                                                            alt="Ícone da categoria"
                                                                            class="port04-page__portfolio__categories__dropdown-mobile__item__icon">
                                                                    @endif
                                                                    {{ $category->title }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        @endif
                    </div>
                    @if ($portfolios->count())
                        <div class="port04-page__portfolio__content">
                            <div class="port04-page__portfolio__content__carousel">
                                @foreach ($portfolios as $portfolio)
                                    <article class="port04-page__portfolio__content__item">
                                        <a class="d-flex flex-row align-items-end w-100"
                                            href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $portfolio->category->slug, 'PORT04Portfolios' => $portfolio->slug]) }}">
                                            <img class="port04-page__portfolio__content__item__image"
                                                src="{{ asset('storage/' . $portfolio->path_image) }}"
                                                alt="Imagem do portfólio">
                                            <div class="port04-page__portfolio__content__item__container">

                                                <div class="port04-page__portfolio__content__item__container__header">
                                                    @if ($portfolio->title)
                                                        <h4
                                                            class="port04-page__portfolio__content__item__container__header__title">
                                                            {{ $portfolio->title }}</h4>
                                                    @endif
                                                    @if ($portfolio->description)
                                                        <p
                                                            class="port04-page__portfolio__content__item__container__header__description">
                                                            {!! $portfolio->description !!}
                                                        </p>
                                                    @endif
                                                </div>
                                                <img class="port04-page__portfolio__content__item__container__icon"
                                                    src="{{ asset('storage/' . $portfolio->path_image_icon) }}"
                                                    alt="Ícone do portfólio">
                                            </div>

                                        </a>
                                    </article>
                                @endforeach
                            </div>

                        </div>
                    @endif
                </div>
            </main>
        </section>
        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
