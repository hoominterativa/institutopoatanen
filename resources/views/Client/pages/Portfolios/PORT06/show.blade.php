@extends('Client.Core.client')
@section('content')
    <main id="root">
        <section class="port06-show__banner" style="background-image: url({{ asset('images/banner.png') }})">
            <h2 class="port06-show__banner__subtitle">Subtítulo</h2>
            <h1 class="port06-show__banner__title">Título</h1>
        </section>

        <section class="port06-show__content">
            <img src="{{ asset('images/imageServ.png') }}" alt="" class="port06-show__content__image">

            <header class="port06-show__content__header">
                <h3 class="port06-show__content__header__subtitle">subítulo</h3>
                <h2 class="port06-show__content__header__title">Título</h2>
                <div class="port06-show__content__header__paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget
                        purus mattis posuere. Donec tincidunt dignissim faucibus. Vestibulum Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus
                        commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec
                        tincidunt dignissim faucibus. Vestibulum </p>
                </div>
            </header>
        </section>

        <section class="port06-show__gallery">
            @for ($i = 0; $i < 3; $i++)
                {{-- BACKEND EXEMPLO DE IMAGEM --}}
                <img src="{{ asset('images/banner.png') }}" alt="[descrição da img]" class="port06-show__gallery__image"
                    loading="lazy">

                {{-- BACKEND EXEMPLO DE VIDEO COM THUMBNAIL --}}
                <div class="port06-show__gallery__video"
                    data-src="{{ 'https://www.youtube.com/embed/SIOTfrjvhj0?si=n-M7Yh96f61PEAkD' }}"
                    style="background-image: url({{ asset('images/imageServ.png') }});">
                    <button class="port06-show__gallery__video__button" title="Play">
                        <img class="port06-show__gallery__video__button__icon" src="{{ asset('images/play.png') }}"
                            alt="Play Vídeo">
                    </button>
                </div>
            @endfor
        </section>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
