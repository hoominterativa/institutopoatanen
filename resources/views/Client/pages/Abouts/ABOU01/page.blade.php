@extends('Client.Core.client')
@section('content')
    <main id="root">
        {{-- BEGIN Page content --}}
        @if ($about)
            <div id="ABOU01" class="abou01-page">
                <section class="container-fluid px-0">
                    @if ($about->active_banner == 1)
                        <header class="abou01-page__header"
                            style="background-image: url({{ asset('storage/' . $about->path_image_banner_desktop) }});background-color: {{ $about->background_color_banner }}">
                            <div class="container d-flex flex-column justify-content-center align-items-center">
                                @if ($about->title_banner || $about->subtitle_banner)
                                    <h3 class="abou01-page__header__container">
                                        <span class="abou01-page__header__title">{{ $about->title_banner }}</span>
                                        <span class="abou01-page__header__subtitle">{{ $about->subtitle_banner }}</span>
                                    </h3>
                                    <hr class="abou01-page__header__line">
                                @endif
                            </div>
                        </header>
                    @endif
                    <div class="container"
                        style="background-image: url({{ asset('storage/' . $about->path_image_desktop) }});background-color: {{ $about->background_color }}">
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
                @if ($about->topics->count())
                    <section class="abou01-page__topic container-fluid"
                        style="background-image: url({{ asset('storage/' . $about->path_image_topic_desktop) }}); background-color: {{ $about->background_color_topic }};">
                        <div class="container">
                            <div class="row carousel-abou01-topic">
                                @foreach ($about->topics as $topic)
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
                @if ($about->active_content == 1)
                    <section class="abou01-page__section container-fluid"
                        style="background-image: url({{ asset('storage/' . $about->path_image_content_desktop) }}); background-color: {{ $about->background_color_content }};">
                        <div class="container">
                            <div class="row abou01-page__section__row align-items-center">
                                <div class="abou01-page__section__image col-12 col-lg-5">
                                    @if ($about->path_image_content)
                                        <img src="{{ asset('storage/' . $about->path_image_content) }}"
                                            class="abou01-page__section__image__item" width="430"
                                            alt="{{ $about->title_content }}">
                                    @endif
                                </div>
                                <div class="col-12 col-lg-7">
                                    @if ($about->title_content || $about->subtitle_content)
                                        <h2 class="abou01-page__section__container">
                                            <span class="abou01-page__section__title">{{ $about->title_content }}</span>
                                            <span
                                                class="abou01-page__section__subtitle">{{ $about->subtitle_content }}</span>
                                            <hr class="abou01-page__section__line">
                                        </h2>
                                    @endif
                                    @if ($about->text_content)
                                        <p class="abou01-page__section__paragraph">
                                            {!! $about->text_content !!}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @if ($about->link_button_content)
                                <a href="{{getUri($about->link_button_content)}}" target="{{ $about->target_link_button_content }}" class="">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="">
                                    @if ($about->title_button_content)
                                        {{$about->title_button_content}}
                                    @endif
                                </a>
                            @endif
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
