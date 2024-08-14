@extends('Client.Core.client')
@section('content')
    <main id="root" class="abou02-page">

        @if ($section)
            @if ($section->active_banner == 1)
                @if ($section->title_banner || $section->subtitle_banner)
                    <section class="abou02-page__banner"
                        style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }}); background-color: {{ $section->background_color_banner }};">

                        @if ($section->title_banner)
                            <h1 class="abou02-page__banner__title">{{ $section->title_banner }}</h1>
                        @endif

                        @if ($section->subtitle_banner)
                            <h2 class="abou02-page__banner__subtitle">{{ $section->subtitle_banner }}</h2>
                        @endif

                    </section>
                @endif
            @endif
        @endif

        @if ($about)
            <section class="abou02-page__main">
                @if ($about->subtitle)
                    <h2 class="abou02-page__main__subtitle">{{ $about->subtitle }}</h2>
                @endif
                @if ($about->title)
                    <h3 class="abou02-page__main__title">{{ $about->title }}</h3>
                @endif
                @if ($about->text)
                    <div class="abou02-page__main__paragraph">
                        <p>
                            {!! $about->text !!}
                        </p>
                    </div>
                @endif
            </section>
        @endif

        @if ($topics->count())
            <section class="abou02-page__topics">

                @if ($section->active_topic)
                    @if ($section->title_topics || $section->subtitle_topics)
                        <header class="abou02-page__topics__header">
                            @if ($section->title_topics)
                                <h2 class="abou02-page__topics__header__title">{{ $section->title_topics }}</h2>
                            @endif
                            @if ($section->subtitle_topics)
                                <h3 class="abou02-page__topics__header__subtitle">{{ $section->subtitle_topics }}
                                </h3>
                            @endif
                        </header>
                    @endif
                @endif

                <div class="abou02-page__topics__carousel">
                    <div class="abou02-page__topics__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($topics as $topic)
                            <article data-fancybox data-src="#lightbox-abou02-{{ $topic->id }}"
                                class="abou02-page__topics__carousel__item swiper-slide">

                                @if ($topic->path_image_box)
                                    <img src="{{ asset('storage/' . $topic->path_image_box) }}"
                                        class="abou02-page__topics__carousel__item__image"
                                        alt="Imagem de fundo do tópico {{ $topic->title_box }}">
                                @endif


                                @if ($topic->title_box)
                                    <h3 class="abou02-page__topics__carousel__item__title">{{ $topic->title_box }}</h3>
                                @endif

                                @if ($topic->description_box)
                                    <div class="abou02-page__topics__carousel__item__paragraph">
                                        <p>{!! $topic->description_box !!}</p>
                                    </div>
                                @endif


                                @include('Client.pages.Abouts.ABOU02.show', [
                                    'topic' => $topic,
                                ])


                            </article>
                        @endforeach
                        {{-- END .abou02-page__topic__item --}}
                    </div>
                </div>

            </section>
        @endif

        @if ($section)
            @if ($section->active_content == 1)
                <section class="abou02-page__additional-content">
                    @if ($section->path_image_content)
                        <img class="abou02-page__additional-content__image"
                            src="{{ asset('storage/' . $section->path_image_content) }}"
                            alt="Imagem referente ao conteudo de título {{ $section->title_content }} ">
                    @endif

                    @if ($section->title_content || $section->subtitle_content || $section->description_content)
                        <div class="abou02-page__additional-content__information">
                            @if ($section->title_content)
                                <h2 class="abou02-page__additional-content__information__title">
                                    {{ $section->title_content }}
                                </h2>
                            @endif
                            @if ($section->subtitle_content)
                                <h3 class="abou02-page__additional-content__information__subtitle">
                                    {{ $section->subtitle_content }}</h3>
                            @endif
                            @if ($section->description_content)
                                <div class="abou02-page__additional-content__information__paragraph">
                                    <p>
                                        {!! $section->description_content !!}
                                    </p>
                                </div>
                            @endif

                            @if ($section->link_button_content)
                                <a href="{{ getUri($section->link_button_content) }}"
                                    target="{{ $section->target_link_button_content }}"
                                    class="abou02-page__additional-content__information__cta">

                                    @if ($section->title_button_content)
                                        {{ $section->title_button_content }}
                                    @endif
                                </a>
                            @endif
                        </div>
                    @endif

            @endif




            </section>

        @endif

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
