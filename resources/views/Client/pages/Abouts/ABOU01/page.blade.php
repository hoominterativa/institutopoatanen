@extends('Client.Core.client')
@section('content')
    <main class="abou01-page" id="root">
        @if ($about)
            @if ($about->active_banner)
                <section class="abou01-page__banner"
                    style="background-image: url({{ asset('storage/' . $about->path_image_banner_desktop) }}); ">
                    @if ($about->title_banner || $about->subtitle_banner)
                        @if ($about->title_banner)
                            <h1 class="abou01-page__banner__title">{{ $about->title_banner }}</h1>
                        @endif

                        @if ($about->subtitle_banner)
                            <h2 class="abou01-page__banner__subtitle">{{ $about->subtitle_banner }}</h2>
                        @endif
                    @endif
                </section>
            @endif

            @if ($about->path_image || $about->title || $about->subtitle || $about->text)
                <section class="abou01-page__main" {{-- style="background-image: url({{ asset('storage/' . $about->path_image_desktop) }});background-color: {{ $about->background_color }}" --}}>
                    @if ($about->path_image)
                        <div class="abou01-page__main__image">
                            <img src="{{ asset('storage/' . $about->path_image) }}" class="abou01-page__main__image__img"
                                alt="{{ $about->title }}">
                        </div>
                    @endif

                    @if ($about->title || $about->subtitle || $about->text)
                        <div class="abou01-page__main__information">
                            @if ($about->title || $about->subtitle)
                                <header class="abou01-page__main__information__header">
                                    @if ($about->title)
                                        <h2 class="abou01-page__main__information__header__title">{{ $about->title }}</h2>
                                    @endif

                                    @if ($about->subtitle)
                                        <h3 class="abou01-page__main__information__header__subtitle">{{ $about->subtitle }}
                                        </h3>
                                    @endif
                                </header>
                            @endif

                            @if ($about->text)
                                <div class="abou01-page__main__information__paragraph">
                                    {!! $about->text !!}
                                </div>
                            @endif
                        </div>
                    @endif
                </section>
            @endif

            @if ($about->topics->count())
                <section class="abou01-page__topics">

                    <div class="abou01-page__topics__carousel">
                        <div class="abou01-page__topics__carousel__swiper-wrapper swiper-wrapper">

                            @foreach ($about->topics as $topic)
                                <article class="abou01-page__topics__item swiper-slide">

                                    <header class="abou01-page__topics__item__header">

                                        @if ($topic->path_image_icon)
                                            <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                                class="abou01-page__topics__item__header__icon" alt="{{ $topic->title }}">
                                        @endif

                                        @if ($topic->title)
                                            <h3 class="abou01-page__topics__item__header__title">{{ $topic->title }}</h3>
                                        @endif
                                    </header>

                                    @if ($topic->description)
                                        <div class="abou01-page__topics__item__paragraph">
                                            {!! $topic->description !!}
                                        </div>
                                    @endif

                                </article>
                            @endforeach

                        </div>

                        <div class="abou01-page__topics__carousel__swiper-pagination"></div>
                    </div>

                </section>
            @endif


            @if ($about->active_content)
                <section class="abou01-page__section">

                    @if ($about->path_image_content)
                        <div class="abou01-page__section__image">
                            <img src="{{ asset('storage/' . $about->path_image_content) }}"
                                class="abou01-page__section__image__img" alt="{{ $about->title_content }}">
                        </div>
                    @endif

                    @if ($about->title_content || $about->subtitle_content || $about->text_content)
                        <div class="abou01-page__section__information">
                            @if ($about->title_content || $about->subtitle_content)
                                <header class="abou01-page__section__information__header">
                                    @if ($about->title_content)
                                        <h2 class="abou01-page__section__information__header__title">
                                            {{ $about->title_content }}
                                        </h2>
                                    @endif

                                    @if ($about->subtitle_content)
                                        <h3 class="abou01-page__section__information__header__subtitle">
                                            {{ $about->subtitle_content }}
                                        </h3>
                                    @endif
                                </header>
                            @endif

                            @if ($about->text_content)
                                <div class="abou01-page__section__information__paragraph">
                                    {!! $about->text_content !!}
                                </div>
                            @endif

                            @if ($about->link_button_content)
                                <a title="{{ $about->title_button_content }}"
                                    href="{{ getUri($about->link_button_content) }}"
                                    target="{{ $about->target_link_button_content }}"
                                    class="abou01-page__section__information__cta">

                                    @if ($about->title_button_content)
                                        {{ $about->title_button_content }}
                                    @endif
                                </a>
                            @endif
                        </div>
                    @endif
                </section>
            @endif


        @endif


        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
