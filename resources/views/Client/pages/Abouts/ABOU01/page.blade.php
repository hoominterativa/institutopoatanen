@extends('Client.Core.client')
@section('content')
    <main id="root">
        {{-- BEGIN Page content --}}
        @if ($about)
            <div id="ABOU01" class="abou01-page">

                @if ($about->active_banner == 1)
                    <section class="abou01-page__banner"
                        style="background-image: url({{ asset('storage/' . $about->path_image_banner_desktop) }}); background-color: {{ $about->background_color_banner }}">

                        @if ($about->title_banner || $about->subtitle_banner)
                            <h1 class="abou01-page__banner__title">{{ $about->title_banner }}</h1>
                            <h2 class="abou01-page__banner__subtitle">{{ $about->subtitle_banner }}</h2>
                            <hr class="abou01-page__banner__line">
                        @endif
                    </section>
                @endif

                <section class="abou01-page__main"
                    style="background-image: url({{ asset('storage/' . $about->path_image_desktop) }});background-color: {{ $about->background_color }}">

                    <div class="abou01-page__main__image">
                        @if ($about->path_image)
                            <img src="{{ asset('storage/' . $about->path_image) }}" class="abou01-page__main__image__img"
                                alt="{{ $about->title }}">
                        @endif
                    </div>

                    <div class="abou01-page__main__information">
                        @if ($about->title || $about->subtitle)
                            <header class="abou01-page__main__information__header">
                                <h2 class="abou01-page__main__information__header__title">{{ $about->title }}</h2>

                                <h3 class="abou01-page__main__information__header__subtitle">{{ $about->subtitle }}</h3>

                                <hr class="abou01-page__content__line">
                            </header>
                        @endif

                        @if ($about->text)
                            <div class="abou01-page__main__information__paragraph">
                                {!! $about->text !!}
                            </div>
                        @endif
                    </div>
                </section>

                @if ($about->topics->count())
                    <section class="abou01-page__topics"
                        style="background-image: url({{ asset('storage/' . $about->path_image_topic_desktop) }}); background-color: {{ $about->background_color_topic }};">

                        <div class="abou01-page__topics__carousel owl-carousel">

                            @foreach ($about->topics as $topic)
                                <article class="abou01-page__topics__item">

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

                    </section>
                @endif
                {{-- END .abou01-page__topic --}}

                @if ($about->active_content == 1)
                    <section class="abou01-page__section"
                        style="background-image: url({{ asset('storage/' . $about->path_image_content_desktop) }}); background-color: {{ $about->background_color_content }}">

                        <div class="abou01-page__section__image">
                            @if ($about->path_image_content)
                                <img src="{{ asset('storage/' . $about->path_image_content) }}"
                                    class="abou01-page__section__image__img" alt="{{ $about->title_content }}">
                            @endif
                        </div>

                        <div class="abou01-page__section__information">
                            @if ($about->title_content || $about->subtitle_content)
                                <header class="abou01-page__section__information__header">
                                    <h2 class="abou01-page__section__information__header__title">
                                        {{ $about->title_content }}
                                    </h2>

                                    <h3 class="abou01-page__section__information__header__subtitle">
                                        {{ $about->subtitle_content }}
                                    </h3>

                                    <hr class="abou01-page__section__information__header__line">
                                </header>
                            @endif

                            @if ($about->text_content)
                                <div class="abou01-page__section__information__paragraph">
                                    {!! $about->text_content !!}
                                </div>
                            @endif

                            @if ($about->link_button_content)
                                <a href="{{ getUri($about->link_button_content) }}"
                                    target="{{ $about->target_link_button_content }}"
                                    class="abou01-page__section__information__cta">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Icone do botão"
                                        class="abou01-page__section__information__cta__icon">

                                    @if ($about->title_button_content)
                                        {{ $about->title_button_content }}
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
