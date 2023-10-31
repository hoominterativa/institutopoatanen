@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="gall03-page w-100" id="gall03-page">
        @if ($section)
            <header class="gall03-page__header w-100 d-flex flex-column align-items-center"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{$section->background_color}};">
                <div class="gall03-page__header__content container">
                    @if ($section->title_banner || $section->subtitle_banner)
                        <h1 class="gall03-page__header__title text-center">{{$section->title_banner}}</h1>
                        <h3 class="gall03-page__header__subtitle text-center">{{$section->subtitle_banner}}</h3>
                        <hr class="gall03-page__header__line">
                    @endif
                </div>
            </header>
        @endif
        @if ($galleries->count())
            <main class="gall03-page__main container-fluid">
                <div class="gall03-page__main__content d-flex flex-column align-items-center container">
                    @if ($section)
                        @if ($section->title_content || $section->subtitle_content)
                            <h2 class="gall03-page__main__title">{{$section->title_content}}</h2>
                            <h3 class="gall03-page__main__subtitle">{{$section->subtitle_content}}</h3>
                            <hr class="gall03-page__main__line">
                        @endif
                    @endif
                    <div class="gall03-page__main__list">
                        @foreach ($galleries  as $gallery)
                            <div class="gall03-page__main__list__item">
                                <a href="#lightbox-gall03-{{$gallery->id}}" data-fancybox class="link-full"></a>
                                @if ($gallery->path_image)
                                    <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="" class="gall03-page__main__list__item__image">
                                @endif
                                @if ($gallery->title)
                                    <h4 class="gall03-page__main__list__item__title">
                                        {{$gallery->title}}
                                    </h4>
                                @endif
                                @include('Client.pages.Galleries.GALL03.show', [
                                    'gallery' => $gallery,
                                ])
                            </div>
                        @endforeach
                    </div>
                </div>
            </main>
        @endif
    </section>

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
