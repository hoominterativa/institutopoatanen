@extends('Client.Core.client')
@section('content')
    <main id="root">
        @if($banner->active_banner == 1)
        <section class="port06-show__banner" style="background-image: url({{ asset('storage/' . $banner->path_image_desktop_banner) }})">
            @if ($banner->subtitle_page)
                <h2 class="port06-show__banner__subtitle">{{ $banner->subtitle_page }}</h2>
            @endif
            @if ($banner->title_page)
                <h1 class="port06-show__banner__title">{{ $banner->title_page }}</h1>
            @endif
        </section>
        @endif

        <section class="port06-show__content">
            <img src="{{ asset('storage/' . $portfolio->path_image) }}" alt="" class="port06-show__content__image">

            <header class="port06-show__content__header">
                @if ($portfolio->subtitle)
                    <h3 class="port06-show__content__header__subtitle">
                        {{ $portfolio->subtitle }}
                    </h3>
                @endif
                @if ($portfolio->title)
                    <h2 class="port06-show__content__header__title">{{ $portfolio->title }}</h2>
                @endif
                <div class="port06-show__content__header__paragraph">
                    {!! $portfolio->paragraph !!}
                </div>
            </header>
        </section>

        <section class="port06-show__gallery">
            @foreach($portfolio->galleriesExist as $image)
                {{-- BACKEND EXEMPLO DE IMAGEM --}}
            @if($image->link_video)

                {{-- BACKEND EXEMPLO DE VIDEO COM THUMBNAIL --}}
                <div class="port06-show__gallery__video"
                    data-src="{{ $image->link_video }}"
                    style="background-image: url({{ asset('storage/' . $image->path_image) }});">
                    <button class="port06-show__gallery__video__button" title="Play">
                        <img class="port06-show__gallery__video__button__icon" src="{{ asset('images/play.png') }}"
                            alt="Play Vídeo">
                    </button>
                </div>
                @else
                <img src="{{ asset('storage/' . $image->path_image) }}" alt="[descrição da img]" class="port06-show__gallery__image"
                loading="lazy">
                @endif
            @endforeach
        </section>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
