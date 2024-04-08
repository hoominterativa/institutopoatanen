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
                    <img src="{{ asset('storage/' . $service->path_image) }}" alt="Imagem Box"
                        class="serv10-show__main__image__img">
                </div>
            @endif

            @if ($service->title || $service->text)
                <div class="serv10-show__main__information">
                    @if ($service->title)
                        <h2 class="serv10-show__main__information__title">{{ $service->title }}</h2>
                    @endif

                    @if ($service->text)
                        <div class="serv10-show__main__information__paragraph">
                            {!! $service->text !!}
                        </div>
                    @endif
                </div>
            @endif
        </section>

        @if ($contents->count())
            <section class="serv10-show__faq">
                @if ($service->active_content == 1)
                    @if ($service->title_content || $service->subtitle_content || $service->description_content)
                        <header class="serv10-show__faq__header">

                            @if ($service->title_content)
                                <h2 class="serv10-show__faq__header__title">{{ $service->title_content }}</h2>
                            @endif

                            @if ($service->subtitle_content)
                                <h3 class="serv10-show__faq__header__subtitle">{{ $service->subtitle_content }}</h3>
                            @endif

                            @if ($service->description_content)
                                <div class="serv10-show__faq__header__paragraph">
                                    <p>
                                        {!! $service->description_content !!}
                                    </p>
                                </div>
                            @endif

                        </header>
                    @endif
                @endif

                <main class="serv10-show__faq__main">
                    @foreach ($contents as $content)
                        <details class="serv10-show__faq__main__item">
                            <summary class="serv10-show__faq__main__item__title" aria-level="3" role="heading">
                                {{ $content->title }}
                            </summary>

                            @if ($content->description)
                                <div class="serv10-show__faq__main__item__paragraph details-content">
                                    <p>
                                        {!! $content->description !!}
                                    </p>
                                </div>
                            @endif

                        </details>
                    @endforeach
                </main>

            </section>
        @endif

        @if ($topics->count())
            <section class="serv10-show__topics">
                @if ($service->active_topic == 1)
                    @if ($service->title_topic || $service->subtitle_topic || $service->description_topic)
                        <header class="serv10-show__topics__header">
                            @if ($service->title_topic)
                                <h2 class="serv10-show__topics__header__title">{{ $service->title_topic }}</h2>
                            @endif

                            @if ($service->subtitle_topic)
                                <h3 class="serv10-show__topics__header__subtitle">{{ $service->subtitle_topic }}</h3>
                            @endif

                            @if ($service->description_topic)
                                <div class="serv10-show__topics__header__paragraph">
                                    <p>
                                        {!! $service->description_topic !!}
                                    </p>
                                </div>
                            @endif
                        </header>
                    @endif
                @endif

                <main class="serv10-show__topics__main">
                    @foreach ($topics as $topic)
                        <div class="serv10-show__topics__main__item">

                            @if ($topic->path_image)
                                <img class="serv10-show__topics__main__item__bg"
                                    src="{{ asset('storage/' . $topic->path_image) }}"
                                    alt="background do tópico {{ $topic->title }}">
                            @endif

                            @if ($topic->path_image_icon)
                                <img src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="ícone">
                            @endif

                            @if ($topic->title)
                                <h4 class="serv10-show__topics__main__item__title">
                                    {{ $topic->title }}</h4>
                            @endif

                            @if ($topic->description)
                                <div class="serv10-show__topics__main__item__paragraph">
                                    <p>
                                        {!! $topic->description !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </main>

            </section>
        @endif

        @if ($galleries->count())
            <div class="serv10-show__gallery">

                @if ($service->active_gallery == 1)
                    <header class="serv10-show__gallery__header">
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
                    </header>
                @endif

                <main class="serv10-show__gallery__main">
                    @foreach ($galleries as $gallery)
                        <img class="serv10-show__gallery__main__item" src="{{ asset('storage/' . $gallery->path_image) }}"
                            alt="Imagem Galeria">
                    @endforeach
                </main>

            </div>
        @endif

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>

@endsection
