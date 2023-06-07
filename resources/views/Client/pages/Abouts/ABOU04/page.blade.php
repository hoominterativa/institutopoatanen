@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <div class="abou04-page" id="abou04-page">
        @if ($banner)
            <section class="abou04-page__banner w-100"
                style="background-image: url({{ asset('storage/' . $banner->path_image_desktop) }}); background-color: {{$banner->background_color}};">
                <header class="abou04-page__banner__content container d-flex flex-column align-items-center justify-content-center">
                    @if ($banner->title || $banner->subtitle)
                        <h1 class="abou04-page__banner__title">{{$banner->title}}</h1>
                        <div class="abou04-page__banner__subtitle">{{$banner->subtitle}}</div>
                        <hr class="abou04-page__banner__line">
                    @endif
                </header>
            </section>
        @endif
        @if ($about)
            <section class="abou04-page__cont w-100">
                <main class="abou04-page__cont__main container">
                    @if ($about->path_image)
                        <img src="{{ asset('storage/' . $about->path_image) }}" alt="" class="abou04-page__cont__image">
                    @endif
                    <div class="abou04-page__cont__content d-flex flex-column align-items-start">
                        @if ($about->title || $about->subtitle)
                            <h2 class="abou04-page__cont__title">{{$about->title}}</h2>
                            <h3 class="abou04-page__cont__subtitle">{{$about->subtitle}}</h3>
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
        <section class="abou04-page__gallery w-100 d-flex flex-column align-items-center">
            @if ($sectionGallery)
                <header class="abou04-page__gallery__header container d-flex flex-column align-items-center">
                    @if ($sectionGallery->title || $sectionGallery->subtitle)
                        <h2 class="abou04-page__gallery__header__title text-center">{{$sectionGallery->title}}</h2>
                        <h3 class="abou04-page__gallery__header__subtitle text-center">{{$sectionGallery->subtitle}}</h3>
                        <hr class="abou04-page__gallery__header__line">
                    @endif
                </header>
            @endif
            <main class="abou04-page__gallery__main container d-flex flex-column align-items-center">
                @if ($galleries->count())
                    <div class="abou04-page__gallery__list w-100 d-flex justify-content-start align-items-stretch flex-wrap">
                       @foreach ($galleries as $gallery)
                            <div class="abou04-page__gallery__list__item">
                                @if ($gallery->path_image)
                                    <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="" class="abou04-page__gallery__list__item__image">
                                @endif
                                @if ($gallery->title)
                                    <h4 class="abou04-page__gallery__list__item__title">{{$gallery->title}}</h4>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
                <a href="{{$sectionGallery->link_button ? getUri($sectionGallery->link_button) : '#'}}" target="{{ $sectionGallery->target_link_button }}" class="abou04-page__gallery__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                        class="abou04-page__gallery__cta__icon">
                    @if ($sectionGallery->title_button)
                        {{ $sectionGallery->title_button }}
                    @endif
                </a>
            </main>
        </section>
        @if ($sectionTopic)
            <section class="abou04-page__topics w-100"
            style="background-image: url({{ asset('storage/' . $sectionTopic->path_image_desktop) }}); background-color: {{ $sectionTopic->background_color }};">
                @if ($topics->count())
                    <div class="abou04-page__topics__list container d-flex flex-wrap justify-content-start align-items-stretch ">
                        @foreach ($topics as $topic)
                            <article class="abou04-page__topics__item d-flex flex-column justify-content-start align-items-stretch">
                                <header class="abou04-page__topics__item__header">
                                    @if ($topic->path_image_icon)
                                        <img src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="" class="abou04-page__topics__item__icon">
                                    @endif
                                    @if ($topic->title)
                                        <h3 class="abou04-page__topics__item__title">{{$topic->title}}</h3>
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
                @endif
            </section>
        @endif
    </div>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
