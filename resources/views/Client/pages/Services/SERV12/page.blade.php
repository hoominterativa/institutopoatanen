@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="serv12-page">
        <section class="serv12-page__banner" {{-- BACKEND: INSERIR BG NO SECTION --}}
            style="background-image: url({{ asset('images/banner.png') }});">
            <h1 class="serv12-page__banner__title">Título do banner</h1>
            <h2 class="serv12-page__banner__subtitle">Subtitulo do banner</h2>
        </section>
        <aside class="serv12-page__categories">
            <menu class="serv12-page__categories__swiper-wrapper swiper-wrapper">
                @for ($i = 1; $i < 5; $i++)
                    {{-- BACKEND: ACTIVE PARA OS ELEMENTOS SELECIONADOS
                    --}}
                    <li class="serv12-page__categories__item active swiper-slide {{-- isset($category->selected) ? 'active' : '' --}}">
                        <a href="#" class="link-full" title="categoria{{ $i }}"></a>
                        categoria {{ $i }}
                    </li>
                @endfor
            </menu>
        </aside>
        <section class="serv12-page__category-section">
            <img src="{{ asset('images/imageServ.png') }}" loading="lazy" alt="Imagem da categoria {{-- BACKEND inserir titulo da categoria --}}"
                class="serv12-page__category-section__img">
            <div class="serv12-page__category-section__information">
                <h2 class="serv12-page__category-section__information__title">Categoria</h2>
                <div class="serv12-page__category-section__information__paragraph">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget
                        purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta
                        velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim
                        faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget
                        purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectet
                    </p>
                </div>
            </div>

        </section>

        <section class="serv12-page__services-section">
            <div class="serv12-page__services-section__carousel">
                <div class="serv12-page__services-section__carousel__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="serv12-page__services-section__carousel__item swiper-slide">
                            <a href="#" class="link-full"></a>
                            <img class="serv12-page__services-section__carousel__item__img"
                                src="{{ asset('images/icon.svg') }}" alt="Ícone do {{-- BACKEND: Título do tópico --}}">
                            <h4 class="serv12-page__services-section__carousel__item__title">Título</h4>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="serv12-page__services-section__main">
                <img src="{{ asset('images/imageServ.png') }}" alt="{{-- Imagem ilustrativa da seção do título --}}"
                    class="serv12-page__services-section__main__img">
                <div class="serv12-page__services-section__main__information">
                    <h2 class="serv12-page__services-section__main__information__title">Serviços</h2>
                    <h3 class="serv12-page__services-section__main__information__subtitle">Subtitulo</h3>
                    <div class="serv12-page__services-section__main__information__paragraph">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                            eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                            Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                            Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel
                            tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                            Lorem ipsum dolor sit amet, consectetvLorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel
                            tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                            ege
                        </p>
                    </div>
                </div>
            </div>
            <div class="serv12-page__services-section__topics">
                <div class="serv12-page__services-section__topics__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="serv12-page__services-section__topics__item swiper-slide" data-fancybox
                            data-src='#M{{ $i }}'>
                            <img class="serv12-page__services-section__topics__item__icon"
                                src="{{ asset('images/icon.svg') }}" alt="icone do tópico {{-- BACKEND Titulo do tópico --}}">
                            <h4 class="serv12-page__services-section__topics__item__title">Titulo Topico</h4>
                            <p class="serv12-page__services-section__topics__item__paragraph">Lorem ipsum dolor sit amet,
                                consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem
                                ipsum dolor sit amet, consectetur adipiscing</p>

                            {{-- BACKEND A SUA SHOW É A DIV ABAIXO. PODE RECORTAR E COLAR NA SHOW.BLADE --}}
                            <div class="serv12-show" id="M{{ $i }}">
                                <div class="serv12-show__information">
                                    <h2 class="serv12-show__information__title">Título do tópico {{ $i }}</h2>
                                    <h3 class="serv12-show__information__subtitle">Subtítulo do tópico {{ $i }}
                                    </h3>
                                    <div class="serv12-show__information__paragraph">
                                        <p>descrição especifica do tópico</p>
                                    </div>
                                </div>

                                <div class="serv12-show__gallery">
                                    <div class="serv12-show__gallery__carousel">
                                        <div class="serv12-show__gallery__carousel__swiper-wrapper swiper-wrapper">
                                            @for ($j = 0; $j < 10; $j++)
                                                <img class="serv12-show__gallery__carousel__item swiper-slide"
                                                    src="{{ asset('images/imageServ.png') }}" alt="{{-- Título do tópico --}}">
                                            @endfor
                                            {{-- BACKEND: PARA QUANDO HOUVER VIDEO --}}
                                            <div class="serv12-show__gallery__carousel__item swiper-slide"
                                                data-src="https://www.youtube.com/embed/MfZDZpY9Oog"
                                                style="background-image: url({{ asset('images/banner.png') }});">

                                                <button class="serv12-show__gallery__carousel__item__button" title="Play">
                                                    <img class="serv12-show__gallery__carousel__item__button__icon"
                                                        src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                                                </button>

                                            </div>

                                        </div>
                                        <div class="serv12-show__gallery__carousel__swiper-button-prev swiper-button-prev">
                                        </div>
                                        <div class="serv12-show__gallery__carousel__swiper-button-next swiper-button-next">
                                        </div>

                                        <div class="serv12-show__gallery__thumbs">
                                            <div class="serv12-show__gallery__thumbs__swiper-wrapper swiper-wrapper">
                                                @for ($j = 0; $j < 10; $j++)
                                                    <img class="serv12-show__gallery__thumbs__item swiper-slide"
                                                        src="{{ asset('images/imageServ.png') }}"
                                                        alt="{{-- Título do tópico --}}">
                                                @endfor
                                                {{-- BACKEND: PARA QUANDO HOUVER VIDEO --}}
                                                <div class="serv12-show__gallery__thumbs__item swiper-slide"
                                                    data-src="https://www.youtube.com/embed/MfZDZpY9Oog"
                                                    style="background-image: url({{ asset('images/banner.png') }});">
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            {{-- BACKEND END-SHOW --}}
                        </div>
                    @endfor
                </div>
            </div>
            {{-- BACKEND: SUBSTITUIR O DATA-SRC E O BG PELAS VARIÁVEIS --}}
            <div class="serv12-page__services-section__video" data-src="https://www.youtube.com/embed/MfZDZpY9Oog"
                style="background-image: url({{ asset('images/banner.png') }});">
                <button class="serv12-page__services-section__video__button" title="Play">
                    <img class="serv12-page__services-section__video__button__icon"
                        src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                </button>
            </div>
            <div class="serv12-page__services-section__gallery">
                @for ($i = 0; $i < 9; $i++)
                    <figure class="serv12-page__services-section__gallery__item">
                        <img class="serv12-page__services-section__gallery__item__img"
                            src="{{ asset('images/imageServ.png') }}">
                        <figcaption class="serv12-page__services-section__gallery__item__description">Descrição da figura
                        </figcaption>
                    </figure>
                @endfor
            </div>
        </section>
    </main>

    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
