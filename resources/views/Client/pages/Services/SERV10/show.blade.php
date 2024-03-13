@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="serv10-show">
        @if ($service->active_banner == 1)
            <section class="serv10-show__banner"
                style="background-image: url({{ asset('storage/' . $service->path_image_desktop_banner) }});
                /* BACKEND: OCULTAR BACKGROUND COLOR DO PAINEL */
                background-color: {{ $service->background_color_banner }};">

                @if ($service->title_banner)
                    <h1 class="serv10-show__banner__title">{{ $service->title_banner }}</h1>
                @endif
            </section>
        @endif

        <section class="serv10-show__main">
            @if ($service->path_image)
                <div class="serv10-show__main__image">
                    <img src="{{ asset('storage/' . $service->path_image) }}" alt="Imagem Box">
                </div>
            @endif

            @if ($service->title || $service->text)
                <div class="serv10-show__main__information">
                    @if ($service->title)
                        <h2 class="serv10-show__main__information__title">{{ $service->title }}</h2>
                    @endif

                    @if ($service->text)
                        <div class="serv10-show__main__information__paragraph">
                            <p>
                                {!! $service->text !!}
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        </section>

        @if ($contents->count())
            <div class="serv10-show__faq">
                <div class="container container--faq">
                    @if ($service->active_content == 1)
                        <div class="serv10-show__faq__header">
                            @if ($service->title_content || $service->subtitle_content)
                                <h2 class="serv10-show__faq__header__title">{{ $service->title_content }}</h2>
                                <h3 class="serv10-show__faq__header__subtitle">{{ $service->subtitle_content }}</h3>
                                <hr class="serv10-show__faq__header__line">
                            @endif
                            @if ($service->description_content)
                                <div class="serv10-show__faq__header__paragraph">
                                    <p>
                                        {!! $service->description_content !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="serv10-show__faq__main">
                        @foreach ($contents as $content)
                            <div class="serv10-show__faq__main__box">
                                @if ($content->title)
                                    <button class="serv10-show__faq__main__box__tab accordion-button collapsed"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $content->id }}"
                                        aria-expanded="false" aria-controls="collapseTwo">
                                        <h4 class="serv10-show__faq__main__box__tab__title">{{ $content->title }}</h4>
                                    </button>
                                @endif
                                @if ($content->description)
                                    <div id="faq-{{ $content->id }}"
                                        class="serv10-show__faq__main__box__description accordion-collapse collapse"
                                        data-bs-parent="#faq-{{ $content->id }}">
                                        <div class="serv10-show__faq__main__box__description__paragraph">
                                            <p>
                                                {!! $content->description !!}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($topics->count())
            <div class="serv10-show__featuredBox">
                <div class="container container--feat">
                    @if ($service->active_topic == 1)
                        <div class="serv10-show__featuredBox__header">
                            @if ($service->title_topic || $service->subtitle_topic)
                                <h2 class="serv10-show__featuredBox__header__title">{{ $service->title_topic }}</h2>
                                <h3 class="serv10-show__featuredBox__header__subtitle">{{ $service->subtitle_topic }}</h3>
                                <hr class="serv10-show__featuredBox__header__line">
                            @endif
                            @if ($service->description_topic)
                                <div class="serv10-show__featuredBox__header__paragraph">
                                    <p>
                                        {!! $service->description_topic !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="serv10-show__featuredBox__main row mx-auto">
                        @foreach ($topics as $topic)
                            <div class="serv10-show__featuredBox__main__box col-sm-3">
                                <div class="serv10-show__featuredBox__main__box__content">
                                    @if ($topic->path_image)
                                        <div class="serv10-show__featuredBox__main__box__bg">
                                            <img src="{{ asset('storage/' . $topic->path_image) }}" alt="Bg">
                                        </div>
                                    @endif
                                    <div class="serv10-show__featuredBox__main__box__description">
                                        @if ($topic->path_image_icon)
                                            <div class="serv10-show__featuredBox__main__box__description__icon">
                                                <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                                    alt="ícone">
                                            </div>
                                        @endif
                                        @if ($topic->title)
                                            <h4 class="serv10-show__featuredBox__main__box__description__title">
                                                {{ $topic->title }}</h4>
                                        @endif
                                        @if ($topic->description)
                                            <div class="serv10-show__featuredBox__main__box__description__paragraph">
                                                <p>
                                                    {!! $topic->description !!}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- END serv10-show__featuredBox__main__box --}}
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($galleries->count())
            <div class="serv10-show__gallery">
                <div class="container container--gall">
                    @if ($service->active_gallery == 1)
                        <div class="serv10-show__gallery__header">
                            @if ($service->title_gallery)
                                <h2 class="serv10-show__gallery__header__title">{{ $service->title_gallery }}</h2>
                            @endif
                            @if ($service->description_gallery)
                                <div class="serv10-show__gallery__header__paragraph">
                                    <p>
                                        {!! $service->description_gallery !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="serv10-show__gallery__main row mx-auto">
                        @foreach ($galleries as $gallery)
                            <div class="serv10-show__gallery__main__box col-sm-3">
                                <figure class="serv10-show__gallery__main__box__content">
                                    <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Imagem Galeria">
                                </figure>
                            </div>
                        @endforeach
                        {{-- END serv10-show__gallery__main__box --}}
                    </div>
                </div>
            </div>
        @endif

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>

@endsection
