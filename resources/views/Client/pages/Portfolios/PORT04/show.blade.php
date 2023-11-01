@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root">
        <section class="port04-show">
            <header class="port04-show__banner container-fluid px-0">
                <div class="port04-show__banner__container">
                    @if ($portfolio->active_banner)
                        <div class="port04-show__banner__image"
                            style="background-image: url({{ asset('storage/' . $portfolio->path_image_desktop_banner) }});  background-color: {{ $portfolio->background_color_banner }};">
                            @if ($portfolio->title_banner || $portfolio->subtitle_banner)
                                <div class="port04-show__banner__header container">
                                    <h4 class="port04-show__banner__header__subtitle">{{ $portfolio->subtitle_banner }}</h4>
                                    <h3 class="port04-show__banner__header__title">{{ $portfolio->title_banner }}</h3>
                                    <hr class="port04-show__banner__header__line">
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </header>

            <main class="port04-show__content">
                @if ($portfolio->active_content)
                    <div class="port04-show__content__main-content">
                        @if ($portfolio->path_image_content)
                            <div class="port04-show__content__main-content__image">
                                <img src="{{ asset('storage/' . $portfolio->path_image_content) }}" alt="Imagem"
                                    class="port04-show__content__main-content__image__img">
                            </div>
                        @endif
                        <div class="port04-show__content__main-content__information">
                            @if ($portfolio->title_content || $portfolio->subtitle_content)
                                <h4 class="port04-show__content__main-content__information__subtitle">{{ $portfolio->subtitle_content }}</h4>
                                <h3 class="port04-show__content__main-content__information__title">{{ $portfolio->title_content }}</h3>
                                <hr class="port04-show__content__main-content__information__line">
                            @endif
                            @if ($portfolio->text_content)
                                <div class="port04-show__content__main-content__information__description">
                                    {!! $portfolio->text_content !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                @if ($additionalTopics->count())
                    <div class="port04-show__content__additional-topic">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @foreach ($additionalTopics as $additionalTopic)
                                <div class="accordion-item">
                                    @if ($additionalTopic->title)
                                        <h4 class="accordion-header" id="heading{{$additionalTopic->id}}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{$additionalTopic->id}}" aria-expanded="true"
                                                aria-controls="collapse{{$additionalTopic->id}}">
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
                                        <div id="collapse{{$additionalTopic->id}}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{$additionalTopic->id}}" data-bs-parent="#accordionFlushExample">

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
                    <div class="port04-show__content__gallery container">
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
            </main>

            @if ($relationships->count())
                <section class="port04-show__related-items">
                    @if ($portfolio->active_section)
                        <header class="port04-show__related-items__header container">
                                @if ($portfolio->title_section || $portfolio->subtitle_section)
                                    <h4 class="port04-show__related-items__header__subtitle">{{ $portfolio->subtitle_section }}</h4>
                                    <h3 class="port04-show__related-items__header__title">{{ $portfolio->title_section }}</h3>
                                    <hr class="port04-show__related-items__header__line">
                                @endif
                                @if ($portfolio->description_section)
                                    <div class="port04-show__related-items__header__description">
                                        {!! $portfolio->description_section !!}
                                    </div>
                                @endif
                        </header>
                    @endif
                    <div class="port04-show__related-items__content">
                        <div class="port04-show__related-items__carousel container">
                            @foreach ($relationships as $relationship)
                                <article class="port04-show__related-items__content__item">
                                    <a  class="d-flex flex-row align-items-end w-100"
                                        href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $relationship->category->slug, 'PORT04Portfolios' => $relationship->slug]) }}">
                                        <img
                                        class="port04-show__related-items__content__item__image"
                                        src="{{ asset('storage/' . $relationship->path_image) }}"
                                            alt="Imagem do portfólio">
                                            <div class="port04-show__related-items__content__item__container">
                                                <div class="port04-show__related-items__content__item__container__header">
                                                    @if ($relationship->title)
                                                        <h4 class="port04-show__related-items__content__item__container__header__title">{{ $relationship->title }}</h4>
                                                    @endif
                                                    @if ($relationship->description)
                                                        <p class="port04-show__related-items__content__item__container__header__description">
                                                            {!! $relationship->description !!}
                                                        </p>
                                                    @endif
                                                </div>
                                                <img
                                                class="port04-show__related-items__content__item__container__icon transition"
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

        </section>
        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
