@extends('Client.Core.client')
@section('content')
    <main id="root" class="unit05-page">
        <section class="unit05-page__banner" style="background-image: url({{ asset('images/banner.png') }});">
            <h2 class="unit05-page__banner__subtitle">Subtítulo</h2>
            <h1 class="unit05-page__banner__title">título</h1>
        </section>
        {{-- FRONTEND TIRAR DUVIDA SOBRE O POSICIONAMENTO DO BOTÃO --}}
        <form class="unit05-page__form">
            <div class="unit05-page__form__input">
                <input type="search" name="buscar" class="" placeholder="Buscar">
            </div>
            <button class="unit05-page__form__submit" type="submit">
                <img src="{{ asset('storage/uploads/tmp/lupa.png') }}" alt="Lupa">
            </button>
        </form>

        <section class="unit05-page__menus">
            {{-- FRONTEND: DIV CATEGORIA --}}
            <menu class="unit05-page__menus__subcategory">
                <div class="unit05-page__menus__subcategory__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 4; $i++)
                        <a href="#" class="unit05-page__menus__subcategory__item swiper-slide">subcategoria
                            {{ $i }}</a>
                    @endfor
                </div>
            </menu>
        </section>

        <section class="unit05-page__services">
            @for ($i = 0; $i < 15; $i++)
                <article class="unit05-page__services__item">
                    <img class="unit05-page__services__item__bg" src="{{ asset('images/banner.png') }}"
                        alt="Imagem de background {{-- BACKEND: Inserir variavel de titulo e subtitulo --}}">
                    <div class="unit05-page__services__item__information">
                        <img class="unit05-page__services__item__information__logo"
                            src="{{ asset('images/logo-client.svg') }}" alt="Logo marca do serviço {{-- BACKEND: Inserir variavel de titulo e subtitulo --}}">

                        <h4 class="unit05-page__services__item__information__subtitle">Subtítulo</h4>
                        <h3 class="unit05-page__services__item__information__title">Titulo Topico</h3>
                        <p class="unit05-page__services__item__information__paragraph">Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit. </p>

                        <a href="#" class="unit05-page__services__item__information__cta">CTA</a>
                        <a href="#" class="unit05-page__services__item__information__cta">CTA</a>
                    </div>
                </article>
            @endfor
        </section>


        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
