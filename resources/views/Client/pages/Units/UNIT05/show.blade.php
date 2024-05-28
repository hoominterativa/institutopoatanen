@extends('Client.Core.client')
@section('content')
    <main id="root" class="unit05-show">
        <header class="unit05-show__header">
            <img src="{{ asset('images/bg-colorido.svg') }}" alt="" class="unit05-show__header__bg">

            <div class="unit05-show__header__images">
                <img class="unit05-show__header__images__item" src="{{ asset('images/banner.png') }}"
                    alt="Image descritiva do serviço [BACKEND: INSERIR VARIAVEL DE TITULO E SUBTITULO]">
                <img class="unit05-show__header__images__logo" src="{{ asset('images/logo-client.svg') }}"
                    alt="Logomarca do serviço [BACKEND: INSERIR VARIAVEL DE TITULO E SUBTITULO]">
            </div>
            <section class="unit05-show__header__information">
                <h3 class="unit05-show__header__information__subtitle">Subtitlo da página</h3>
                <h2 class="unit05-show__header__information__title">Título</h2>
                <div class="unit05-show__header__information__paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget
                        purus ma</p>
                </div>

                <menu class="unit05-show__header__information__menu">
                    @for ($i = 0; $i < 3; $i++)
                        <a class="unit05-show__header__information__menu__item" title="{{-- BACKEND INSERIR A VARIAVEL DO LINK AQUI --}}"
                            href="#">ver mais</a>
                    @endfor
                </menu>

            </section>
        </header>

        @for ($i = 0; $i < 2; $i++)
            <section class="unit05-show__content">

                <div class="unit05-show__content__information">
                    <h3 class="unit05-show__content__information__subtitle">Subtítle</h3>
                    <h2 class="unit05-show__content__information__title">Títle</h2>
                    <div class="unit05-show__content__information__paragraph">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                            eget
                            purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                            consectetur
                            adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo
                            porta
                            velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt
                            dignissim
                            faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus
                            gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                            eget
                            purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectet
                        </p>
                    </div>
                </div>

                <img src="{{ asset('storage/uploads/tmp/bloco.png') }}" loading='lazy'
                    alt="Banner da seção [BACKEND add título da seção aqui]" class="unit05-show__content__image">
            </section>
        @endfor


        <section class="unit05-show__related">
            <header class="unit05-show__related__header">
                <h2 class="unit05-show__related__header__title">Categoria</h2>
                <h3 class="unit05-show__related__header__subtitle">Subcategoria</h3>
            </header>

            <div class="unit05-show__related__carousel">
                <div class="unit05-show__related__carousel__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 5; $i++)
                        <article class="unit05-show__related__carousel__item swiper-slide">
                            <img class="unit05-show__related__carousel__item__bg" src="{{ asset('images/banner.png') }}"
                                alt="Imagem de background {{-- BACKEND: Inserir variavel de titulo e subtitulo --}}">

                            <div class="unit05-show__related__carousel__item__information">
                                <img class="unit05-show__related__carousel__item__information__logo"
                                    src="{{ asset('images/logo-client.svg') }}"
                                    alt="Logo marca do serviço {{-- BACKEND: Inserir variavel de titulo e subtitulo --}}">

                                <h4 class="unit05-show__related__carousel__item__information__subtitle">Subtítulo</h4>
                                <h3 class="unit05-show__related__carousel__item__information__title">Titulo Topico</h3>
                                <div class="unit05-show__related__carousel__item__information__paragraph">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                                {{-- BACKEND: LEMBRANDO QUE AQUI SO VAI IMPRIMIR NO MAXIMO DOIS --}}
                                @for ($j = 0; $j < 2; $j++)
                                    <a href="#" class="unit05-show__related__carousel__item__information__cta">CTA</a>
                                @endfor
                            </div>
                        </article>
                    @endfor
                </div>

                <div class="unit05-show__related__carousel__nav">
                    <div class="unit05-show__related__carousel__nav__swiper-button-prev swiper-button-prev"></div>
                    <div class="unit05-show__related__carousel__nav__swiper-button-next swiper-button-next"></div>
                </div>
            </div>
        </section>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
