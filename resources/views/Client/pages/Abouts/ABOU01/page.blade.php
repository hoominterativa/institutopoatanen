@extends('Client.Core.client')
@section('content')
    <main id="root">
        {{-- BEGIN Page content --}}
        @if ($about)
            <div id="ABOU01" class="abou01-page">
                <section class="container-fluid px-0">
                    @if ($section->active_banner)
                        <header class="abou01-page__header"
                            style="background-image: url({{ asset('storage/' . $section->path_image_banner_desktop) }});background-color: {{ $section->background_color_banner }}">
                            <div class="container d-flex flex-column justify-content-center align-items-center">
                                @if ($section->title_banner || $section->subtitle_banner)
                                    <h3 class="abou01-page__header__container">
                                        <span class="abou01-page__header__title">{{ $section->title_banner }}</span>
                                        <span class="abou01-page__header__subtitle">{{ $section->subtitle_banner }}</span>
                                    </h3>
                                    <hr class="abou01-page__header__line">
                                @endif
                            </div>
                        </header>
                    @endif
                    <div class="container">
                        <div class="container__img">
                            @if ($about->path_image)
                                <img src="{{ asset('storage/' . $about->path_image) }}" class="" width="430"
                                    alt="{{ $about->title }}">
                            @endif
                        </div>
                        <div class="abou01-page__content">
                            @if ($about->title || $about->subtitle)
                                <h2 class="abou01-page__content__container">
                                    <span class="abou01-page__content__title">{{ $about->title }}</span>
                                    <span class="abou01-page__content__subtitle">{{ $about->subtitle }}</span>
                                </h2>
                                <hr class="abou01-page__content__line">
                            @endif
                            @if ($about->text)
                                <div class="abou01-page__content__paragraph">
                                    {!! $about->text !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
                {{-- END .abou01-page__content --}}
                @if ($topics->count())
                    <section class="abou01-page__topic container-fluid"
                        style="background-image: url({{ asset('storage/' . $section->path_image_topic_desktop) }}); background-color: {{ $section->background_color_topic }};">
                        <div class="container">
                            <div class="row carousel-abou01-topic">
                                @foreach ($topics as $topic)
                                    <article class="abou01-page__topic__item col-12 col-lg-4">
                                        <div class="abou01-page__topic__content transition">
                                            <div class="abou01-page__topic__item__header d-flex align-items-center">
                                                @if ($topic->path_image_icon)
                                                    <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                                        width="32" class="abou01-page__topic__item__icon"
                                                        alt="{{ $topic->title }}">
                                                @endif
                                                @if ($topic->title)
                                                    <h3 class="abou01-page__topic__item__title">{{ $topic->title }}</h3>
                                                @endif
                                            </div>
                                            @if ($topic->description)
                                                <p class="abou01-page__topic__item__paragraph">
                                                    {!! $topic->description !!}
                                                </p>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
                {{-- END .abou01-page__topic --}}
                @if ($section->active_content)
                    <section class="abou01-page__section container-fluid"
                        style="background-image: url({{ asset('storage/' . $section->path_image_content_desktop) }}); background-color: {{ $section->background_color_content }};">
                        <div class="container">
                            <div class="row abou01-page__section__row align-items-center">
                                <div class="abou01-page__section__image col-12 col-lg-5">
                                    @if ($section->path_image_content)
                                        <img src="{{ asset('storage/' . $section->path_image_content) }}"
                                            class="abou01-page__section__image__item" width="430"
                                            alt="{{ $section->title_content }}">
                                    @endif
                                </div>
                                <div class="col-12 col-lg-7">
                                    @if ($section->title_content || $section->subtitle_content)
                                        <h2 class="abou01-page__section__container">
                                            <span class="abou01-page__section__title">{{ $section->title_content }}</span>
                                            <span
                                                class="abou01-page__section__subtitle">{{ $section->subtitle_content }}</span>
                                            <hr class="abou01-page__section__line">
                                        </h2>
                                    @endif
                                    @if ($section->text_content)
                                        <p class="abou01-page__section__paragraph">
                                            {!! $section->text_content !!}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
                {{-- END .abou01-page__section --}}
            </div>
            {{-- END .abou01-page --}}

        @endif
        {{-- Finish Content page Here --}}

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
