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
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach ($additionalTopics as $additionalTopic)
                            <div class="accordion-item">
                                @if ($additionalTopic->title)
                                    <h4 class="accordion-header" id="heading{{ $additionalTopic->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $additionalTopic->id }}" aria-expanded="true"
                                            aria-controls="collapse{{ $additionalTopic->id }}">
                                            @if ($additionalTopic->path_image_icon)
                                                <div class="">
                                                    <img src="{{ asset('storage/' . $additionalTopic->path_image_icon) }}"
                                                        alt="Imagem" class="me-4">
                                                </div>
                                            @endif
                                            {{ $additionalTopic->title }}
                                        </button>
                                    </h4>
                                @endif
                                @if ($additionalTopic->text)
                                    <div id="collapse{{ $additionalTopic->id }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $additionalTopic->id }}"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            {!! $additionalTopic->text !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($topics->count())
                <div class="port04-show__content__topics">
                    <div class="port04-show__content__topics__carousel">
                        @foreach ($topics as $topic)
                            <div class="port04-show__content__topics__item">
                                @if ($topic->path_image_icon)
                                    <div class="port04-show__content__topics__item__image">
                                        <img src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="Imagem"
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
            @endif
            @if ($galleries->count())
                <div class="port04-show__content__gallery">
                    <div class="port04-show__content__gallery__carousel">
                        @foreach ($galleries as $gallery)
                            <div class="port04-show__content__gallery__item">
                                @if ($gallery->path_image)
                                    <div class="port04-show__content__gallery__item__image">
                                        <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Imagem"
                                            class="port04-show__content__gallery__item__image__img">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>
        @if ($relationships->count())
            <section class="port04-show__related-items">
                @if ($section->active_relationship)
                    <header class="port04-show__related-items__header">
                        @if ($section->title_relationship || $section->subtitle_relationship)
                            <h4 class="port04-show__related-items__header__subtitle">
                                {{ $section->subtitle_relationship }}</h4>
                            <h3 class="port04-show__related-items__header__title animation fadeInLeft">
                                {{ $section->title_relationship }}</h3>
                            <hr class="port04-show__related-items__header__line">
                        @endif
                        @if ($section->description_relationship)
                            <div class="port04-show__related-items__header__description">
                                {!! $section->description_relationship !!}
                            </div>
                        @endif
                    </header>
                @endif
                <div class="port04-show__related-items__content">
                    <div class="port04-show__related-items__carousel">
                        @foreach ($relationships as $relationship)
                            <article class="port04-show__related-items__content__item">
                                <a class="d-flex flex-row align-items-end w-100"
                                    href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $relationship->category->slug, 'PORT04Portfolios' => $relationship->slug]) }}">
                                    <img class="port04-show__related-items__content__item__image"
                                        src="{{ asset('storage/' . $relationship->path_image) }}"
                                        alt="Imagem do portfólio">
                                    <div class="port04-show__related-items__content__item_">
                                        <div class="port04-show__related-items__content__item___header">
                                            @if ($relationship->title)
                                                <h4 class="port04-show__related-items__content__item___header__title">
                                                    {{ $relationship->title }}</h4>
                                            @endif
                                            @if ($relationship->description)
                                                <p class="port04-show__related-items__content__item___header__description">
                                                    {!! $relationship->description !!}
                                                </p>
                                            @endif
                                        </div>
                                        <img class="port04-show__related-items__content__item___icon transition"
                                            src="{{ asset('storage/' . $relationship->path_image_icon) }}"
                                            alt="Ícone do portfólio">
                                    </div>
                                </a>
                            </article>
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
