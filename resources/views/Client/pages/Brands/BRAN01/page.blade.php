@extends('Client.Core.client')
@section('content')
    <main class="bran01-page" id="root">

        @if ($section->active_banner)
            <section class="bran01-page__banner"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }});">

                @if ($section->title_banner)
                    <h1 class="bran01-page__banner__title animation fadeInLeft">{{ $section->title_banner }}</h1>
                @endif

                {{-- @if ($section->subtitle_banner)
                    <h2 class="bran01-page__banner__subtitle">{{ $section->subtitle_banner }}</h2>
                @endif --}}

            </section>
        @endif

        <section class="bran01-page__main">
            @if ($section->active_content)
                @if ($section->title_content || $section->subtitle_content || $section->description_content)
                    <header class="bran01-page__main__header">
                        @if ($section->title_content)
                            <h2 class="bran01-page__main__header__title animation fadeInLeft">{{ $section->title_content }}</h2>
                        @endif

                        @if ($section->subtitle_content)
                            <h3 class="bran01-page__main__header__subtitle animation fadeInLeft">{{ $section->subtitle_content }}</h3>
                        @endif

                        <div class="bran01-page__main__header__conteudo">
                            @if ($section->description_content)
                                <div class="bran01-page__main__header__paragraph animation fadeInLeft">
                                    <p>
                                        {!! $section->description_content !!}
                                    </p>
                                </div>
                            @endif
                            <a href="#" class="bran01-page__main__header__cta animation fadeInRight">
                                <span>
                                    Become a Supporter
                                </span>    
                            </a>
                        </div>

                    </header>
                @endif
            @endif

            @if ($brands->count() > 0)
                <div class="bran01-page__main__content">
                    @foreach ($brands as $brand)
                        <div class="bran01-page__main__content__item animation fadeInLeft"
                            style="background-image:url({{ asset('storage/' . $brand->path_image_box) }});">

                            @if ($brand->link)
                                <a href="{{ getUri($brand->link) }}" title="link para a marca"
                                    target="{{ $brand->target_link }}" class="link-full"></a>
                            @endif

                            @if ($brand->path_image_icon)
                                <img src="{{ asset('storage/' . $brand->path_image_icon) }}"
                                    class="bran01-page__main__content__item__icon" alt="Logo" loading="lazy">
                            @endif

                        </div>
                    @endforeach
                </div>
            @endif
        </section>


        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
