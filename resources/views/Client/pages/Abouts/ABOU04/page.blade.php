@extends('Client.Core.client')
@section('content')
    <main class="abou04-page" id="root">

        @if ($about->active_banner == 1)
            <section class="abou04-page__banner"
                style="background-image: url({{ asset('storage/' . $about->path_image_desktop_banner) }}); background-color: {{ $about->background_color_banner }};">
                @if ($about->title_banner)
                    <h1 class="abou04-page__banner__title">{{ $about->title_banner }}</h1>
                @endif
                @if ($about->subtitle_banner)
                    <h2 class="abou04-page__banner__subtitle">{{ $about->subtitle_banner }}</h2>
                @endif
            </section>
        @endif

        @if ($about)
            <section class="abou04-page__content ">
                @if ($about->path_image)
                    <img src="{{ asset('storage/' . $about->path_image) }}" alt="{{ $about->title }}"
                        class="abou04-page__content__image">
                @endif

                <div class="abou04-page__content__information">
                    @if ($about->title)
                        <h2 class="abou04-page__content__information__title">{{ $about->title }}</h2>
                    @endif

                    @if ($about->subtitle)
                        <h3 class="abou04-page__content__information__subtitle">{{ $about->subtitle }}</h3>
                    @endif

                    @if ($about->text)
                        <div class="abou04-page__content__information__paragraph">
                            {!! $about->text !!}
                        </div>
                    @endif
                </div>

            </section>
        @endif

        @if ($categories->count())
            <section class="abou04-page__gallery">
                @if ($about->active_galleries)
                    <header class="abou04-page__gallery__header">
                        @if ($about->title_galleries || $about->description_galleries)
                            <h2 class="abou04-page__gallery__header__title">{{ $about->title_galleries }}</h2>
                        @endif
                        @if ($about->description_galleries)
                            <div class="abou04-page__gallery__header__paragraph">{!! $about->description_galleries !!}</div>
                        @endif
                    </header>
                @endif

                @foreach ($categories as $category)
                    <div class="abou04-page__gallery__item">
                        <h3 class="abou04-page__gallery__item__title">{{ $category->title }}</h3>

                        @if ($category->description)
                            <p class="abou04-page__gallery__item__paragraph">{!! $category->description !!}</p>
                        @endif

                        @if ($category->galleries->count())
                            {{-- NOTE: A SEÇÃO DA GALERIA PRECISA SER ATIVADA NO PAINEL PARA MOSTRAR IMGS MSM QUE NÃO HAJA TITULO OU BTN --}}
                            <div class="abou04-page__gallery__item__list">
                                @foreach ($category->galleries as $gallery)
                                    <div data-src="{{ asset('storage/' . $gallery->path_image) }}"
                                        data-fancybox="{{ $category->title }}"
                                        class="abou04-page__gallery__item__list__item">

                                        <img src="{{ asset('storage/' . $gallery->path_image) }}"
                                            alt="{{ $gallery->title }}"
                                            class="abou04-page__gallery__item__list__item__image">

                                        @if ($gallery->title)
                                            <h4 class="abou04-page__gallery__item__list__item__title">{{ $gallery->title }}
                                            </h4>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
                @if ($about->link_button_galleries && $about->active_galleries)
                    <a href="{{ getUri($about->link_button_galleries) }}"
                        target="{{ $about->target_link_button_galleries }}" class="abou04-page__gallery__cta">
                        @if ($about->title_button_galleries)
                            {{ $about->title_button_galleries }}
                        @endif
                    </a>
                @endif

            </section>
        @endif

        @if ($topics->count())
            <section class="abou04-page__topics">

                <div class="abou04-page__topics__carousel">
                    <div class="abou04-page__topics__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($topics as $topic)
                            <article class="abou04-page__topics__item swiper-slide">
                                <header class="abou04-page__topics__item__header">
                                    @if ($topic->path_image_icon)
                                        <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                            alt="Icone do tópico {{ $topic->title }}"
                                            class="abou04-page__topics__item__header__icon">
                                    @endif
                                    @if ($topic->title)
                                        <h3 class="abou04-page__topics__item__header__title">{{ $topic->title }}</h3>
                                    @endif
                                </header>
                                @if ($topic->description)
                                    <div class="abou04-page__topics__item__paragraph">
                                        {!! $topic->description !!}

                                    </div>
                                @endif
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
