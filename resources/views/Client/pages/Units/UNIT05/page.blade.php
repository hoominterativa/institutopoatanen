@extends('Client.Core.client')
@section('content')
    <main id="root" class="unit05-page">
        <section class="unit05-page__banner" style="background-image: url({{ asset('images/banner.png') }});">
            <h2 class="unit05-page__banner__subtitle">Subtítulo</h2>
            <h1 class="unit05-page__banner__title">título</h1>
        </section>
        <form class="unit05-page__form">
            <div class="unit05-page__form__input">
                <input type="search" name="buscar" placeholder="Buscar">
            </div>
            <button class="unit05-page__form__submit" type="submit">
                <img src="{{ asset('storage/uploads/tmp/lupa.png') }}" alt="Lupa">
            </button>
        </form>

        <section class="unit05-page__menus">
            <menu class="unit05-page__menus__categories">
                <div class="unit05-page__menus__categories__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 5; $i++)
                        <a title="{{-- BACKEND: INSERIR A VARIAVEL DE CATEGORIA AQUI --}}" href="{{ route('unit05.page') }}"
                            class="unit05-page__menus__categories__item swiper-slide">Categoria
                            {{ $i }}</a>
                    @endfor
                </div>
            </menu>
            <menu class="unit05-page__menus__subcategories">
                <div class="unit05-page__menus__subcategories__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 4; $i++)
                        <a {{-- BACKEND: INSERIR A VARIAVEL DE CATEGORIA AQUI --}} href="#"
                            class="unit05-page__menus__subcategories__item swiper-slide">subcategoria
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
                        <div class="unit05-page__services__item__information__paragraph">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div>
                        {{-- BACKEND: LEMBRANDO QUE AQUI SO VAI IMPRIMIR NO MAXIMO DOIS --}}
                        @for ($j = 0; $j < 2; $j++)
                            <a href="#" class="unit05-page__services__item__information__cta">CTA</a>
                        @endfor
                    </div>
                </article>
            @endfor
        </section>


        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
