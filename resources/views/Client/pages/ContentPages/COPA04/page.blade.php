{{-- BEGIN Page content --}}
@extends('Client.Core.client')
@section('content')
    <main id="root" class="copa04-page">
        {{-- BEGIN Page content --}}
        <style>
            /* BACKEND: Imprimir as variaveis de cor aqui ❤ */
            :root {

                @if ($sectionHeros)
                    --bg-hero-primary: {{ $sectionHeros ? $sectionHeros->color_one : 'lightgray' }};
                    --bg-hero-secondary: {{ $sectionHeros ? $sectionHeros->color_two : 'lightblue' }};
                    --bg-hero-tertiary: {{ $sectionHeros ? $sectionHeros->color_three : 'white' }};
                @endif

                @if ($sectionVideo)
                    --bg-video-section: {{ $sectionVideo ? $sectionVideo->color_one : 'purple' }};
                @endif

                @if ($sectionHighlighted)
                    --bg-higlighted: {{ $sectionHighlighted ? $sectionHighlighted->color_one : 'red' }};
                @endif
                @if ($sectionTopic)
                    --bg-topics: {{ $sectionTopic ? $sectionTopic->color_one : 'white' }};
                @endif
                @if ($sectionTopicCarousel)
                    --bg-topics-carousel: {{ $sectionTopicCarousel ? $sectionTopicCarousel->color_one : 'white' }};
                @endif
                @if ($sectionGallery)
                    --bg-gallery-topics: {{ $sectionGallery ? $sectionGallery->color_one : 'white' }};
                @endif
                @if ($sectionAdditionalContent)
                    --bg-additional-content: {{ $sectionAdditionalContent ? $sectionAdditionalContent->color_one : 'white' }};
                @endif
                @if ($sectionFaq)
                    --bg-faq: {{ $sectionFaq ? $sectionFaq->color_one : 'white' }};
                @endif
                @if ($sectionProducts)
                    --bg-products: {{ $sectionProducts ? $sectionProducts->color_one : 'white' }};
                @endif
                --bg-productsss: gray;

            }
        </style>
        {{-- Seção Hero --}}
        {{-- {{ $sectionHeros ? $sectionHeros->color_one : 'default_primary_value' }}; --}}
        @if ($sectionHeros)
            <section class="copa04-page__hero ">
                <aside class="copa04-page__hero__aside">
                    {{-- BACKEND está faltando verificação do conteúdo desses elementos --}}
                    <img class="copa04-page__hero__aside__logo" src="{{ asset('storage/' . $sectionHeros->path_logo) }}"
                        alt="icone referente a seção {{ $sectionHeros->title }}">
                    <a class="copa04-page__hero__aside__cta"
                        href="{{ $sectionHeros->button_link }}">{{ $sectionHeros->button_text }}</a>
                </aside>

                <div class="copa04-page__hero__information">
                    <header class="copa04-page__hero__information__header">
                        <img class="copa04-page__hero__information__header__icon"
                            src="{{ asset('storage/' . $sectionHeros->path_icon) }}"
                            alt="ícone do {{ $sectionHeros->title }}">
                        @if ($sectionHeros->title)
                            <h1 class="copa04-page__hero__information__header__title">{{ $sectionHeros->title }}</h1>
                        @endif
                    </header>
                    @if ($sectionHeros->description)
                        <p class="copa04-page__hero__information__paragraph">
                            {!! $sectionHeros->description !!}
                        </p>
                    @endif
                    @if ($sectionHeros->link)
                        <a href="{{ $sectionHeros->link }}"
                            class="copa04-page__hero__information__cta">{{ $sectionHeros->title_btn }}</a>
                    @endif
                </div>
                @if ($sectionHeros->path_image)
                    <img class="copa04-page__hero__image" src="{{ asset('storage/' . $sectionHeros->path_image) }}"
                        alt="Imagem ilustrativa da seção {{ $sectionHeros->title }}">
                @endif
            </section>
        @endif
        {{-- Seção Video --}}
        @if ($sectionVideo)
            <section class="copa04-page__video-section">
                @if ($sectionVideo->title)
                    <h2 class="copa04-page__video-section__title">{{ $sectionVideo->title }}</h2>
                @endif

                @if ($sectionVideo->subtitle)
                    <h3 class="copa04-page__video-section__subtitle">{{ $sectionVideo->subtitle }}</h3>
                @endif
                @if ($sectionVideo->text)
                    <div class="copa04-page__video-section__paragraph">
                        {!! $sectionVideo->text !!}
                    </div>
                @endif
                @if ($sectionVideo->link)
                    <div data-src="{{ $sectionVideo->link ?? 'Error' }}" class="copa04-page__video-section__video"
                        style="background-image: url({{ asset('storage/' . $sectionVideo->path_image) }})">
                        <button id="video_play" class="copa04-page__video-section__video__button">
                            <img class="copa04-page__video-section__video__button__icon"
                                src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                        </button>
                    </div>
                @endif
            </section>
        @endif
        {{-- Seção Highlighted --}}
        @if ($sectionHighlighted)
            <section class="copa04-page__highlighted">
                <div class="copa04-page__highlighted__information">
                    @if ($sectionHighlighted->title)
                        <h2 class="copa04-page__highlighted__information__title">{{ $sectionHighlighted->title }}</h2>
                    @endif

                    @if ($sectionHighlighted->subtitle)
                        <h3 class="copa04-page__highlighted__information__subtitle">{{ $sectionHighlighted->subtitle }}
                        </h3>
                    @endif

                    @if ($sectionHighlighted->text)
                        <div class="copa04-page__highlighted__information__paragraph">

                            {!! $sectionHighlighted->text !!}

                        </div>
                    @endif

                    @if ($sectionHighlighted->link)
                        <a href="{{ $sectionHighlighted->link }}" target="_blank"
                            class="copa04-page__highlighted__information__cta">{{ $sectionHighlighted->btn_title }}</a>
                    @endif
                </div>
                @if ($sectionHighlighted->path_image)
                    <img class="copa04-page__highlighted__image"
                        src="{{ asset('storage/' . $sectionHighlighted->path_image) }}"
                        alt="Imagem referente a seção {{ $sectionHighlighted->title }}">
                @endif
            </section>
        @endif

        {{-- Seção Topics --}}
        @if ($sectionTopic)
            <section class="copa04-page__topics">
                <header class="copa04-page__topics__header">
                    @if ($sectionTopic->title)
                        <h2 class="copa04-page__topics__header__title">{{ $sectionTopic->title }}</h2>
                    @endif

                    @if ($sectionTopic->subtitle)
                        <h3 class="copa04-page__topics__header__subtitle">{{ $sectionTopic->subtitle }}</h3>
                    @endif

                    @if ($sectionTopic->description)
                        <div class="copa04-page__topics__header__paragraph">
                            {!! $sectionTopic->description !!}
                        </div>
                    @endif
                </header>

                <div class="copa04-page__topics__main">
                    @foreach ($topicItems as $topic)
                        <div class="copa04-page__topics__main__item">
                            <img class="copa04-page__topics__main__item__icon"
                                src="{{ asset('storage/' . $topic->path_image) }}"
                                alt="ícone do tópico {{ $topic->title }}">
                            <h4 class="copa04-page__topics__main__item__title">{{ $topic->title }}</h4>
                            <div class="copa04-page__topics__main__item__paragraph">
                                <p>{!! $topic->text !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($sectionTopic->btn_title)
                    <a href="#" class="copa04-page__topics__cta">{{ $sectionTopic->btn_title }}</a>
                @endif
            </section>
        @endif

        {{-- Seção Topics - Carousel --}}
        @if ($sectionTopicCarousel)
            <section class="copa04-page__topics-carousel">
                <header class="copa04-page__topics-carousel__header">
                    @if ($sectionTopicCarousel->title)
                        <h2 class="copa04-page__topics-carousel__header__title">{{ $sectionTopicCarousel->title }}</h2>
                    @endif
                    <h3 class="copa04-page__topics-carousel__header__subtitle">{{ $sectionTopicCarousel->subtitle }}</h3>
                    <div class="copa04-page__topics-carousel__header__paragraph">
                        {!! $sectionTopicCarousel->description !!}
                    </div>
                </header>
                @if ($carouselItems)
                    <div class="copa04-page__topics-carousel__carousel">
                        <div class="copa04-page__topics-carousel__swiper-wrapper swiper-wrapper">
                            @foreach ($carouselItems as $item)
                                <div class="copa04-page__topics-carousel__carousel__item swiper-slide">

                                    @if ($item->path_image)
                                        <img class="copa04-page__topics-carousel__carousel__item__icon"
                                            src="{{ asset('storage/' . $item->path_image) }}"
                                            alt="ícone do tópico {{ $item->title }}">
                                    @endif

                                    @if ($item->title)
                                        <h4 class="copa04-page__topics-carousel__carousel__item__title">{{ $item->title }}
                                        </h4>
                                    @endif

                                    @if ($item->description)
                                        <div class="copa04-page__topics-carousel__carousel__item__paragraph">
                                            {!! $item->description !!}
                                        </div>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($sectionTopicCarousel->btn_title || $sectionTopicCarousel->link)
                    <a href="{{ $sectionTopicCarousel->button_link }}"
                        class="copa04-page__topics-carousel__cta">{{ $sectionTopicCarousel->btn_title }}</a>
                @endif
            </section>
        @endif
        {{-- Seção Gallery Topics --}}
        @if ($sectionGallery)
            <section class="copa04-page__gallery-topics">
                <header class="copa04-page__gallery-topics__header">

                    @if ($sectionGallery->title)
                        <h2 class="copa04-page__gallery-topics__header__title">{{ $sectionGallery->title }}</h2>
                    @endif

                    @if ($sectionGallery->subtitle)
                        <h3 class="copa04-page__gallery-topics__header__subtitle">{{ $sectionGallery->subtitle }}</h3>
                    @endif

                    @if ($sectionGallery->description)
                        <div class="copa04-page__gallery-topics__header__paragraph">
                            {!! $sectionGallery->description !!}
                        </div>
                    @endif

                </header>

                {{-- @dd($galleryItems) BACKEND Tirar da Migration Subtitle --}}
                <div class="copa04-page__gallery-topics__carousel">
                    <div class="copa04-page__gallery-topics__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($galleryItems as $galleryItem)
                            <div class="copa04-page__gallery-topics__carousel__item swiper-slide">
                                {{-- se image usar essa estrutura --}}

                                @if ($galleryItem->link_video)
                                    {{-- se video --}}
                                    <div data-fancybox data-src="{{ $galleryItem->link_video }}"
                                        class="copa04-page__gallery-topics__carousel__item__video"
                                        style="background-image: url('{{ asset('storage/' . $galleryItem->path_image) }}')">
                                        <button class="copa04-page__gallery-topics__carousel__item__video__button">
                                            <img class="copa04-page__gallery-topics__carousel__item__video__button__icon"
                                                src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                                        </button>
                                    </div>
                                @else
                                    <img class="copa04-page__gallery-topics__carousel__item__image"
                                        src="{{ asset('storage/' . $galleryItem->path_image) }}"
                                        alt="Imagem do tópico title ">
                                @endif

                                <div class="copa04-page__gallery-topics__carousel__item__information">
                                    @if ($galleryItem->title)
                                        <h4 class="copa04-page__gallery-topics__carousel__item__information__title">
                                            {{ $galleryItem->title }}
                                        </h4>
                                    @endif

                                    @if ($galleryItem->description)
                                        <div class="copa04-page__gallery-topics__carousel__item__information__paragraph">
                                            {!! $galleryItem->description !!}
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
            </section>
        @endif

        {{-- Seção Additional Content --}}
        @if ($sectionAdditionalContent)
            <section class="copa04-page__additional-content">

                <div class="copa04-page__additional-content__header">
                    @if ($sectionAdditionalContent->title)
                        <div class="copa04-page__additional-content__header__title"> {{ $sectionAdditionalContent->title }}
                        </div>
                    @endif
                    @if ($sectionAdditionalContent->subtitle)
                        <div class="copa04-page__additional-content__header__subtitle">
                            {{ $sectionAdditionalContent->subtitle }}</div>
                    @endif
                    @if ($sectionAdditionalContent->description)
                        <div class="copa04-page__additional-content__header__paragraph">
                            {!! $sectionAdditionalContent->description !!}
                        </div>
                    @endif
                    <a class="copa04-page__additional-content__header__cta"
                        href="{{ $sectionAdditionalContent->button_link }}">{{ $sectionAdditionalContent->button_text }}</a>
                </div>
                <div class="copa04-page__additional-content__carousel">
                    <div class="copa04-page__additional-content__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($additionalItemImages as $item)
                            @if ($item->link_video)
                                {{-- Se tiver video --}}
                                <div data-fancybox data-src="{{ $item->link_video }}"
                                    class="copa04-page__additional-content__carousel__item--video swiper-slide"
                                    style="background-image: url('{{ asset('storage/' . $item->path_image) }}')">
                                    <button class="copa04-page__additional-content__carousel__item--video__button">
                                        <img class="copa04-page__additional-content__carousel__item--video__button__icon"
                                            src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                                    </button>
                                </div>
                            @else
                                {{-- Se tiver somente imagem --}}
                                <img class="copa04-page__additional-content__carousel__item swiper-slide"
                                    src="{{ asset('storage/' . $item->path_image) }}" alt="{Image}">
                            @endif
                        @endforeach
                    </div>

                </div>

            </section>
        @endif

        {{-- Seção Additional Topics Carousel --}}
        @if ($additionalTopics->count() > 0)
            <section class="copa04-page__additional-topics">
                <div class="copa04-page__additional-topics__carousel">
                    <div class="copa04-page__additional-topics__carousel__swiper-wrapper swiper-wrapper">
                        {{-- if image --}}
                        @foreach ($additionalTopics as $topic)
                            @if ($topic->link_video)
                                {{-- if video --}}
                                <div class="copa04-page__additional-topics__carousel__item--video swiper-slide">
                                    <div data-fancybox data-src="https://www.youtube.com/embed/EDnIEWyVIlE"
                                        class="copa04-page__additional-topics__carousel__item--video__video"
                                        style="background-image: url('{{ asset('storage/' . $topic->path_image) }}')">
                                        <button
                                            class="copa04-page__additional-topics__carousel__item--video__video__button">
                                            <img class="copa04-page__additional-topics__carousel__item--video__video__button__icon"
                                                src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                                        </button>
                                    </div>
                                    <p class="copa04-page__additional-topics__carousel__item--video__title">
                                        {{ $topic->title }}
                                    </p>
                                    <a href=""
                                        class="copa04-page__additional-topics__carousel__item--video__cta">cta</a>

                                </div>
                            @else
                                <figure class="copa04-page__additional-topics__carousel__item swiper-slide">
                                    <img class="copa04-page__additional-topics__carousel__item__image"
                                        src="{{ asset('storage/' . $topic->path_image) }}" alt=" {{ $topic->title }}">

                                    <figcaption class="copa04-page__additional-topics__carousel__item__title">Title
                                        {{ $topic->title }}</figcaption>

                                    <a href="{{ $topic->button_link }}"
                                        class="copa04-page__additional-topics__carousel__item__cta">{{ $topic->button_text }}</a>
                                </figure>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Seção FAQ --}}
        @if ($sectionFaq)
            <section class="copa04-page__faq">
                <header class="copa04-page__faq__header">
                    @if ($sectionFaq->title)
                        <h2 class="copa04-page__faq__header__title">{{ $sectionFaq->title }}</h2>
                    @endif

                    @if ($sectionFaq->subtitle)
                        <h3 class="copa04-page__faq__header__subtitle">{{ $sectionFaq->subtitle }}</h3>
                    @endif

                    @if ($sectionFaq->description)
                        <div class="copa04-page__faq__header__paragraph">
                            <p>{!! $sectionFaq->description !!}</p>
                        </div>
                    @endif
                </header>
                @foreach ($faqTopics as $topic)
                    @if ($topic->title || $topic->description)
                        <details class="copa04-page__faq__item">
                            <summary class="copa04-page__faq__item__title" aria-level="3" role="heading">
                                {{ $topic->title }}
                            </summary>
                            <div class="copa04-page__faq__item__paragraph details-content">
                                {!! $topic->description !!}.
                            </div>
                        </details>
                    @endif
                @endforeach
            </section>
        @endif

        {{-- Seção Section Products --}}
        @if ($sectionProducts)
            <section class="copa04-page__section-products">
                <header class="copa04-page__section-products__header">

                    @if ($sectionProducts->title)
                        <h2 class="copa04-page__section-products__header__title">{{ $sectionProducts->title }}</h2>
                    @endif

                    @if ($sectionProducts->subtitle)
                        <h3 class="copa04-page__section-products__header__subtitle">{{ $sectionProducts->subtitle }}</h3>
                    @endif

                    @if ($sectionProducts->description)
                        <div class="copa04-page__section-products__header__paragraph">
                            {!! $sectionProducts->description !!}
                        </div>
                    @endif

                </header>
                <div class="copa04-page__section-products__carousel">
                    <div class="copa04-page__section-products__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($productItem as $item)
                            <div class="copa04-page__section-products__carousel__item swiper-slide">
                                {{-- if tag --}}
                                @if ($item->promotion == 1)
                                    <span class="copa04-page__section-products__carousel__item__tag">Promoção</span>
                                @endif
                                <h4 class="copa04-page__section-products__carousel__item__title">{{ $item->title }}</h4>
                                <h5 class="copa04-page__section-products__carousel__item__subtitle">{{ $item->subtitle }}
                                </h5>
                                <div class="copa04-page__section-products__carousel__item__paragraph">
                                    {!! $item->description !!}
                                </div>
                                <div class="copa04-page__section-products__carousel__item__price">
                                    <h6 class="copa04-page__section-products__carousel__item__price__title">
                                        {{ $item->subtitle }}</h6>
                                    <p class="copa04-page__section-products__carousel__item__price__paragraph">R$
                                        <b>{{ $item->value }}</b>
                                    </p>

                                </div>
                                <a class="copa04-page__section-products__carousel__item__cta"
                                    href="{{ $item->button_link }}">{{ $item->button_text }}</a>


                            </div>
                        @endforeach
                    </div>
                </div>

            </section>
        @endif

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
