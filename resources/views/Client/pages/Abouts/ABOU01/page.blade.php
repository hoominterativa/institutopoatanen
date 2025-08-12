@extends('Client.Core.client')
@section('content')
    <main class="abou01-page" id="root">
        @if ($about)
            @if ($about->active_banner)
                <section class="abou01-page__banner"
                    style="background-image: url({{ asset('storage/' . $about->path_image_banner_desktop) }}); ">
                    @if ($about->title_banner || $about->subtitle_banner)
                        @if ($about->title_banner)
                            <h1 class="abou01-page__banner__title animation fadeInLeft">{{ $about->title_banner }}</h1>
                        @endif

                        {{-- @if ($about->subtitle_banner)
                            <h2 class="abou01-page__banner__subtitle">{{ $about->subtitle_banner }}</h2>
                        @endif --}}
                    @endif
                </section>
            @endif

            <section class="abou01-page__top">
                <h3 class="abou01-page__top__title animation fadeInLeft">Juntos levamos oportunidades</h3>
                <p class="abou01-page__top__paragraph animation fadeInRight">Cada apoio recebido é um passo a mais para mudar histórias e construir futuros mais justos. Vamos juntos?</p>
            </section>

            @if ($about->path_image || $about->title || $about->subtitle || $about->text)
                <section class="abou01-page__main" {{-- style="background-image: url({{ asset('storage/' . $about->path_image_desktop) }});background-color: {{ $about->background_color }}" --}}>
                    @if ($about->path_image)
                        <div class="abou01-page__main__image animation fadeInUp">
                            <img src="{{ asset('storage/' . $about->path_image) }}" class="abou01-page__main__image__img"
                                alt="{{ $about->title }}">
                        </div>
                    @endif

                    @if ($about->title || $about->text)
                        <div class="abou01-page__main__information">
                            @if ($about->title || $about->subtitle)
                                <header class="abou01-page__main__information__header">
                                    @if ($about->title)
                                        <h2 class="abou01-page__main__information__header__title animation fadeInUp">{{ $about->title }}</h2>
                                    @endif

                                    {{-- @if ($about->subtitle)
                                        <h3 class="abou01-page__main__information__header__subtitle">{{ $about->subtitle }}
                                        </h3>
                                    @endif --}}
                                </header>
                            @endif

                            @if ($about->text)
                                <div class="abou01-page__main__information__paragraph animation fadeInUp">
                                    {!! $about->text !!}
                                </div>
                            @endif

                            <a href="/doacao" class="abou01-page__main__information__cta animation fadeInUp">
                                <span>Seja um apoiador</span>
                            </a>
                        </div>
                    @endif
                </section>
            @endif

            <div class="abou01-page__topics">
                <h3 class="abou01-page__topics__title animation fadeInLeft">A luta de um virou esperança para muitos. Esse é o Instituto Poatan</h3>
                @foreach ($about->topics as $topic)
                    <details class="abou01-page__topics__item animation fadeInUp">
                        <summary class="abou01-page__topics__item__title" aria-level="3" role="heading">
                            {{ $topic->title }}
                        </summary>
                        <div class="abou01-page__topics__item__paragraph details-content">
                            {!! $topic->description !!}
                        </div>
                    </details>
                @endforeach
            </div>


            @if ($about->active_content)
                <section class="abou01-page__section">

                    @if ($about->path_image_content)
                        <div class="abou01-page__section__image animation fadeInRight">
                            <img src="{{ asset('storage/' . $about->path_image_content) }}"
                                class="abou01-page__section__image__img" alt="{{ $about->title_content }}">
                        </div>
                    @endif

                    @if ($about->title_content || $about->subtitle_content || $about->text_content)
                        <div class="abou01-page__section__information">
                            @if ($about->title_content || $about->subtitle_content)
                                <header class="abou01-page__section__information__header">
                                    @if ($about->title_content)
                                        <h2 class="abou01-page__section__information__header__title animation fadeInLeft">
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
                                <div class="abou01-page__section__information__paragraph animation fadeInLeft">
                                    {!! $about->text_content !!}
                                </div>
                            @endif

                            @if ($about->link_button_content)
                                <a title="{{ $about->title_button_content }}"
                                    href="{{ getUri($about->link_button_content) }}"
                                    target="{{ $about->target_link_button_content }}"
                                    class="abou01-page__section__information__cta animation fadeInLeft">

                                    @if ($about->title_button_content)
                                        <span>
                                            {{ $about->title_button_content }}
                                        </span>
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
