@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <div class="abou04-page" id="abou04-page">
        @if ($section)
            <section class="abou04-page__banner w-100"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }}); background-color: {{ $section->background_color_banner }};">
                <header
                    class="abou04-page__banner__content container d-flex flex-column align-items-center justify-content-center">
                    @if ($section->title_banner || $section->subtitle_banner)
                        <h1 class="abou04-page__banner__title">{{ $section->title_banner }}</h1>
                        <div class="abou04-page__banner__subtitle">{{ $section->subtitle_banner }}</div>
                        <hr class="abou04-page__banner__line">
                    @endif
                </header>
            </section>
        @endif
        @if ($about)
            <section class="abou04-page__cont w-100">
                <main class="abou04-page__cont__main container">
                    @if ($about->path_image)
                        <img src="{{ asset('storage/' . $about->path_image) }}" alt="{{ $about->title }}" class="abou04-page__cont__image">
                    @endif
                    <div class="abou04-page__cont__content d-flex flex-column align-items-start">
                        @if ($about->title || $about->subtitle)
                            <h2 class="abou04-page__cont__title">{{ $about->title }}</h2>
                            <h3 class="abou04-page__cont__subtitle">{{ $about->subtitle }}</h3>
                            <hr class="abou04-page__cont__line">
                        @endif
                        <div class="abou04-page__cont__desc">
                            @if ($about->text)
                                <p>
                                    {!! $about->text !!}
                                </p>
                            @endif
                        </div>
                    </div>
                </main>
            </section>
        @endif
        @if ($categories->count())
            <section class="abou04-page__gallery w-100 d-flex flex-column align-items-center">
                @if ($section)
                    <header class="abou04-page__gallery__header container d-flex flex-column align-items-center">
                        @if ($section->title_galleries || $section->description_galleries)
                            <h2 class="abou04-page__gallery__header__title text-center">{{ $section->title_galleries }}</h2>
                            <p class="abou04-page__gallery__header__description text-center">{!! $section->description_galleries !!}</p>
                            <hr class="abou04-page__gallery__header__line">
                        @endif
                    </header>
                @endif
                <main class="abou04-page__gallery__main container d-flex flex-column align-items-center">
                    @foreach ($categories as $category)
                        <h4>{{ $category->title }}</h4>
                        <p>{!! $category->description !!}</p>
                        <hr class="abou04-page__gallery__header__line">
                        @if ($category->galleries->count())
                            {{-- NOTE: A SEÇÃO DA GALERIA PRECISA SER ATIVADA NO PAINEL PARA MOSTRAR IMGS MSM QUE NÃO HAJA TITULO OU BTN --}}
                            <div class="abou04-page__gallery__list w-100 d-flex justify-content-start align-items-stretch flex-wrap">
                                @foreach ($category->galleries as $gallery)
                                    <div class="abou04-page__gallery__list__item">
                                        @if ($gallery->path_image)
                                            <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="{{ $gallery->title }}" class="abou04-page__gallery__list__item__image">
                                            <a href="{{ asset('storage/' . $gallery->path_image) }}" data-fancybox class="link-full"></a>
                                        @endif
                                        @if ($gallery->title)
                                            <h4 class="abou04-page__gallery__list__item__title">{{ $gallery->title }}</h4>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                    @if ($section->link_button_galleries)
                        <a href="{{ getUri($section->link_button_galleries) }}" target="{{ $section->target_link_button_galleries }}" class="abou04-page__gallery__cta">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícone" class="abou04-page__gallery__cta__icon">
                            @if ($section->title_button_galleries)
                                {{ $section->title_button_galleries }}
                            @endif
                        </a>
                    @endif
                </main>
            </section>
        @endif
        @if ($topics->count())
            <section class="abou04-page__topics w-100"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop_topics) }}); background-color: {{ $section->background_color_topics }};">
                <div class="abou04-page__topics__list container d-flex flex-wrap justify-content-start align-items-stretch ">
                    @foreach ($topics as $topic)
                        <article
                            class="abou04-page__topics__item d-flex flex-column justify-content-start align-items-stretch">
                            <header class="abou04-page__topics__item__header">
                                @if ($topic->path_image_icon)
                                    <img src="{{ asset('storage/' . $topic->path_image_icon) }}" alt=""
                                        class="abou04-page__topics__item__icon">
                                @endif
                                @if ($topic->title)
                                    <h3 class="abou04-page__topics__item__title">{{ $topic->title }}</h3>
                                @endif
                            </header>
                            <main class="abou04-page__topics__item__desc">
                                @if ($topic->description)
                                    <p>
                                        {!! $topic->description !!}
                                    </p>
                                @endif
                            </main>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
