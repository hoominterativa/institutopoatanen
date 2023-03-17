@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    @if ($brands->count())
        @if ($section)
            <section id="BRAN01" class="bran01-page container-fluid px-0">
                <header class="bran01-page__header"
                    style="background-image: url({{ asset('storage/' . $section->path_image_banner_desktop) }}); background-color: {{ $section->background_color_banner }};">
                    @if ($section->title_banner || $section->subtitle_banner || $section->active_banner == 1)
                        <h2 class="container container--bran01-page d-block text-center">
                            <span class="bran01-page__header__title d-block">{{ $section->title_banner }}</span>
                            <span class="bran01-page__header__subtitle d-block">{{ $section->subtitle_banner }}</span>
                            <hr class="bran01-page__header__line mb-0">
                        </h2>
                    @endif
                </header>

                <main class="bran01-page__main">
                    <div class="container container--bran01-page__main">
                        <div class="bran01-page__encompass px-0 text-center mx-auto w-100">
                            @if ($section->title_section || $section->active_section == 1)
                                <h2 class="bran01-page__encompass__title">{{ $section->title_section }}</h2>
                                <h3 class="bran01-page__encompass__subtitle">{{ $section->subtitle_section }}</h3>
                                <hr class="bran01-page__encompass__line">
                            @endif
                            <div class="bran01-page__encompass__paragraph mx-auto">
                                @if ($section->description_section || $section->active_section == 1)
                                    <p>
                                        {!! $section->description_section !!}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="bran01-page__content">
                            <div class="row row--bran01-page w-100 mx-auto">
                                @foreach ($brands as $brand)
                                    <div class="bran01-page__box col-sm-3 position-relative">
                                        <a href="{{ $brand->link }}" target="{{ $brand->target_link }}"
                                            class="link-full"></a>
                                        <div class="bran01-page__box__content"
                                            style="background-image:url({{ asset('storage/' . $brand->path_image_box) }}); background-size:cover;background-repeat:no-repeat; background-position:center;">
                                            <div class="bran01-page__box__image">
                                                <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo"
                                                    loading="lazy">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- END .bran01-page__box --}}
                            </div>
                        </div>
                    </div>
                </main>
            </section>
        @endif
    @endif
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
