@extends('Client.Core.client')
@section('content')
    <main class="bran01-page" id="root">

        @if ($section->active_banner)
            <section class="bran01-page__banner"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }});

                /* BACKEND: REMOVER FUNCIONALIDADE */
                /* background-color: {{ $section->background_color_banner }};*/">

                @if ($section->title_banner)
                    <h1 class="bran01-page__banner__title">{{ $section->title_banner }}</h1>
                @endif

                @if ($section->subtitle_banner)
                    <h2 class="bran01-page__banner__subtitle">{{ $section->subtitle_banner }}</h2>
                @endif

            </section>
        @endif

        <section class="bran01-page__main">
            @if ($section->active_content)
                @if ($section->title_content || $section->subtitle_content || $section->description_content)
                    <header class="bran01-page__main__header">
                        @if ($section->title_content)
                            <h2 class="bran01-page__main__header__title">{{ $section->title_content }}</h2>
                        @endif

                        @if ($section->subtitle_content)
                            <h3 class="bran01-page__main__header__subtitle">{{ $section->subtitle_content }}</h3>
                        @endif

                        @if ($section->title_content || $section->subtitle_content)
                            <hr class="bran01-page__main__header__line">
                        @endif

                        @if ($section->description_content)
                            <div class="bran01-page__main__header__paragraph">
                                <p>
                                    {!! $section->description_content !!}
                                </p>
                            </div>
                        @endif
                    </header>
                @endif
            @endif

            @if ($brands->count() > 0)
                <main class="bran01-page__main__content">
                    @foreach ($brands as $brand)
                        <div class="bran01-page__main__content__item"
                            style="background-image:url({{ asset('storage/' . $brand->path_image_box) }});">

                            @if ($brand->link)
                                <a href="{{ getUri($brand->link) }}" title="link para a marca"
                                    target="{{ $brand->target_link }}" class="link-full"></a>
                            @endif

                            @if ($brand->path_image_icon)
                                <div class="bran01-page__main__content__item__image">
                                    <img src="{{ asset('storage/' . $brand->path_image_icon) }}"
                                        class="bran01-page__main__content__item__image__img" alt="Logo" loading="lazy">
                                </div>
                            @endif

                        </div>
                    @endforeach
                </main>
            @endif
        </section>


        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
