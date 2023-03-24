@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    @if ($section)
        <main id="root">
            <div id="SERV04" class="serv04-page">
                <section class="container-fluid px-0">
                    <header class="serv04-page__header"
                        style="background-image: url({{ asset('storage/' . $section->path_image_banner_desktop) }}); background-color: {{ $section->background_color_banner }};">
                        <div class="container d-flex flex-column justify-content-center align-items-center">
                            @if ($section->title_banner)
                                <h3 class="serv04-page__header__title">{{ $section->title_banner }}</h3>
                            @endif
                            <div class="serv04-page__header__paragraph">
                                @if ($section->description_banner)
                                    <p>
                                        {!! $section->description_banner !!}
                                    </p>
                                @endif
                            </div>
                            @if ($categories->count())
                                <nav class="serv04-page__navigation">
                                    <div class="container container--navi px-0 mx-auto">
                                        <ul class="px-0">
                                            @foreach ($categories as $categoryGet)
                                                <li class="{{ $categoryGet->id == $category->id ? 'active' : '' }}">
                                                    <a href="{{ route('serv04.category.page', ['SERV04ServicesCategory' => $categoryGet->slug]) }}"
                                                        class="serv04-page__header__category__item {{ isset($categoryGet->selected) ? 'serv04-page__header__category__item--active' : '' }}">{{ $categoryGet->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="serv04-page__navigation__select">
                                            <div class="dropdown serv04-page__navigation__select__dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Categoria
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @foreach ($categories as $categoryGet)
                                                        <li><a class="dropdown-item" href="{{ route('serv04.category.page', ['SERV04ServicesCategory' => $categoryGet->slug]) }}">{{ $categoryGet->title }}</a></li>
                                                    @endforeach
                                                </ul>
                                              </div>
                                        </div>
                                    </div>
                                </nav>
                            @endif
                        </div>
                    </header>

                    <div class="serv04-page__content">
                        <div class="serv04-page__text">
                            <div class="container container--sepa px-0 mx-auto">
                                <div class="serv04-page__box">
                                    <div class="row row--sepa mx-auto px-0">
                                        @if ($category->path_image)
                                            <div class="serv04-page__box__image col-auto px-0">
                                                <img src="{{ asset('storage/' . $category->path_image) }}"
                                                    alt="Image Categoria" loading="lazy">
                                            </div>
                                        @endif
                                        <div class="serv04-page__box__description col">
                                            @if ($category->title)
                                                <h2 class="serv04-page__box__title">{{ $category->title }}</h2>
                                            @endif
                                            @if ($category->description)
                                                <div class="serv04-page__box__paragraph">
                                                    <p>
                                                        {!! $category->description !!}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END .serv04-page__content --}}
                </section>
                {{-- END .serv04-page --}}
                @if ($services->count())
                    <section class="serv04-page__subcategory container-fluid px-0">
                        <div class="container container--seps">
                            <div class="serv04-page__subcategory__nav">
                                <div
                                    class="carousel-serv04-page__subcategory px-0 mb-0 owl-carousel serv04-page__subcategory____eng">
                                    @foreach ($services as $serviceGet)
                                        <div class="serv04-page__subcategory__box position-relative {{ $serviceGet->id == $service->id ? 'active' : '' }}"
                                            style="background-image:url({{ asset('storage/' . $serviceGet->path_image_box) }});">
                                            <a href="{{ route('serv04.page.content', ['SERV04ServicesCategory' => $category->slug, 'SERV04Services' => $serviceGet->slug]) }}"
                                                class="link-full"></a>
                                            <div class="serv04-page__subcategory__box__image">
                                                <img src="{{ asset('storage/' . $serviceGet->path_image_icon) }}"
                                                    alt="Subcategoria" loading="lazy">
                                            </div>
                                            <h2 class="serv04-page__subcategory__box__title">{{ $serviceGet->title }}</h2>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="serv04-page__subcategory__content">
                                <div class="serv04-page__subcategory__content__box">
                                    <div class="row mx-auto px-0">
                                        <div class="serv04-page__subcategory__content__box__image col-auto px-0">
                                            <img src="{{ asset('storage/' . $service->path_image) }}" alt="Categoria"
                                                loading="lazy">
                                        </div>
                                        <div class="serv04-page__subcategory__content__box__description col">
                                            @if ($service->title || $service->subtitle)
                                                <h2 class="serv04-page__subcategory__content__box__title">
                                                    {{ $service->title }}
                                                </h2>
                                                <h2 class="serv04-page__subcategory__content__box__subtitle">
                                                    {{ $service->subtitle }}</h2>
                                            @endif
                                            @if ($service->text)
                                                <div class="serv04-page__subcategory__content__box__paragraph">
                                                    <p>
                                                        {!! $service->text !!}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="serv04-page__subcategory__content__accordion">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        @foreach ($topics as $topic)
                                            <div
                                                class="accordion-item serv04-page__subcategory__content__accordion__boxQuestion">
                                                @if ($topic->title)
                                                    <h2 class="accordion-header" id="flush-collapseOne">
                                                        <button
                                                            class="accordion-button collapsed serv04-page__subcategory__content__accordion__boxQuestion__title"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapse-{{ $topic->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="flush-collapse-{{ $topic->id }}">
                                                            {{ $topic->title }}
                                                        </button>
                                                    </h2>
                                                @endif
                                                @if ($topic->text)
                                                    <div id="flush-collapse-{{ $topic->id }}"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="flush-headingOne"
                                                        data-bs-parent="#accordionFlushExample">
                                                        <div
                                                            class="accordion-body serv04-page__subcategory__content__accordion__boxQuestion__texto">
                                                            <p>
                                                                {!! $topic->text !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
                {{-- END .serv04-page__subcategory --}}
            </div>
            {{-- END .serv04-page --}}
        </main>
    @endif
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
