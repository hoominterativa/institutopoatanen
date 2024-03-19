@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="port04-show">
        @if ($portfolio->active_banner)
            @if ($portfolio->title_banner || $portfolio->subtitle_banner)
                <section class="port04-show__banner"
                    style="background-image: url({{ asset('storage/' . $portfolio->path_image_desktop_banner) }});">
                    @if ($portfolio->title_banner)
                        <h1 class="port04-show__banner__title">{{ $portfolio->title_banner }}</h1>
                    @endif

                    @if ($portfolio->subtitle_banner)
                        <h2 class="port04-show__banner__subtitle">{{ $portfolio->subtitle_banner }}</h2>
                    @endif
                </section>
            @endif
        @endif

        <section class="port04-show__content">
            @if ($portfolio->active_content)
                <div class="port04-show__content__main-content">
                    @if ($portfolio->path_image_content)
                        <div class="port04-show__content__main-content__image">
                            <img loading= 'lazy' src="{{ asset('storage/' . $portfolio->path_image_content) }}"
                                alt="Imagem do conteúdo {{ $portfolio->title_content }}"
                                class="port04-show__content__main-content__image__img">
                        </div>
                    @endif
                    @if ($portfolio->title_content || $portfolio->subtitle_content || $portfolio->text_content)
                        <div class="port04-show__content__main-content__information">
                            @if ($portfolio->title_content)
                                <h3 class="port04-show__content__main-content__information__title">
                                    {{ $portfolio->title_content }}</h3>
                            @endif

                            @if ($portfolio->subtitle_content)
                                <h4 class="port04-show__content__main-content__information__subtitle">
                                    {{ $portfolio->subtitle_content }}</h4>
                            @endif

                            @if ($portfolio->text_content)
                                <div class="port04-show__content__main-content__information__paragraph">
                                    {!! $portfolio->text_content !!}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            @if ($additionalTopics->count())
                <div class="port04-show__content__additional-topic">
                    @foreach ($additionalTopics as $additionalTopic)
                        <details class="port04-show__content__additional-topic__item">
                            @if ($additionalTopic->title)
                                <summary class="port04-show__content__additional-topic__item__title" aria-level="3"
                                    role="heading">
                                    @if ($additionalTopic->path_image_icon)
                                        <img loading="lazy"
                                            class="port04-show__content__additional-topic__item__title__icon"
                                            src="{{ asset('storage/' . $additionalTopic->path_image_icon) }}"
                                            alt="ícone do tópico {{ $additionalTopic->title }}">
                                    @endif
                                    {{ $additionalTopic->title }}
                                </summary>
                            @endif

                            @if ($additionalTopic->text)
                                <div class="port04-show__content__additional-topic__item__paragraph details-content">
                                    {!! $additionalTopic->text !!}
                                </div>
                            @endif
                        </details>
                    @endforeach

                </div>
            @endif

            @if ($topics->count())
                <div class="port04-show__content__topics">
                    <div class="port04-show__content__topics__carousel">
                        <div class="port04-show__content__topics__carousel__swiper-wrapper swiper-wrapper">
                            @foreach ($topics as $topic)
                                <div class="port04-show__content__topics__item swiper-slide">
                                    @if ($topic->path_image_icon)
                                        <div class="port04-show__content__topics__item__image">
                                            <img
                                            src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="Ícone do tópico {{ $topic->title }}"
                                            loading='lazy'
                                            class="port04-show__content__topics__item__image__img">
                                        </div>
                                    @endif
                                    <div class="port04-show__content__topics__item__information">
                                        @if ($topic->title)
                                            <h4 class="port04-show__content__topics__item__information__title">
                                                {{ $topic->title }}</h4>
                                        @endif
                                        @if ($topic->text)
                                            <p class="port04-show__content__topics__item__information__description">
                                                {!! $topic->text !!}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if ($galleries->count())
                <div class="port04-show__content__gallery">
                    <div class="port04-show__content__gallery__carousel">
                        <div class="port04-show__content__gallery__carousel__swiper-wrapper swiper-wrapper">
                            @foreach ($galleries as $gallery)
                                <img src="{{ asset('storage/' . $gallery->path_image) }}"
                                loading='lazy'
                                alt="Imagem da galeria"
                                    class="port04-show__content__gallery__item swiper-slide">
                            @endforeach
                        </div>
                        <div class="port04-show__content__gallery__carousel__swiper-pagination swiper-pagination"></div>
                    </div>
                </div>
            @endif
        </section>

        @if ($relationships->count())
            <section class="port04-show__related">
                @if ($section->active_relationship)
                    @if ($section->title_relationship || $section->subtitle_relationship || $section->description_relationship)
                        <header class="port04-show__related__header">
                            @if ($section->title_relationship || $section->subtitle_relationship)
                                @if ($section->title_relationship)
                                    <h2 class="port04-show__related__header__title">
                                        {{ $section->title_relationship }}</h2>
                                @endif

                                @if ($section->subtitle_relationship)
                                    <h3 class="port04-show__related__header__subtitle">
                                        {{ $section->subtitle_relationship }}</h3>
                                @endif

                                @if ($section->description_relationship)
                                    <div class="port04-show__related__header__paragraph">
                                        <p>
                                            {!! $section->description_relationship !!}
                                        </p>
                                    </div>
                                @endif
                            @endif
                        </header>
                    @endif
                @endif
                <main class="port04-show__related__main">
                    <div class="port04-show__related__main__carousel">
                        <div class="port04-show__related__main__carousel__swiper-wrapper swiper-wrapper">
                            @foreach ($relationships as $relationship)
                                <article class="port04-show__related__main__item swiper-slide">
                                    <a class="link-full" title="{{ $relationship->title }}"
                                        href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $relationship->category->slug, 'PORT04Portfolios' => $relationship->slug]) }}"></a>

                                    <img loading='lazy' class="port04-show__related__main__item__bg"
                                        src="{{ asset('storage/' . $relationship->path_image) }}"
                                        alt="Imagem do portfólio">


                                    <div class="port04-show__related__main__item__information">
                                        @if ($relationship->title)
                                            <h4 class="port04-show__related__main__item__information__title">
                                                {{ $relationship->title }}</h4>
                                        @endif
                                        @if ($relationship->description)
                                            <p class="port04-show__related__main__item__information__description">
                                                {!! $relationship->description !!}
                                            </p>
                                        @endif
                                    </div>
                                    <img class="port04-show__related__main__item__icon" loading='lazy'
                                        src="{{ asset('storage/' . $relationship->path_image_icon) }}"
                                        alt="Ícone do portfólio  {{ $relationship->title }} ">
                                </article>
                            @endforeach
                        </div>
                        <div class="port04-show__related__main__carousel__swiper-pagination swiper-pagination"></div>
                    </div>
                </main>
            </section>
        @endif


        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
