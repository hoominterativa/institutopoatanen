@extends('Client.Core.client')
@section('content')
    <main id="root">

        <section class="copa03__banner" style="background-image: url({{ asset('storage/uploads/tmp/boxAn.png') }})">

            <div class="copa03__banner__categories quedinha">
                <button class="copa03__banner__categories__btn quedinha__btn">Categoria</button>

                <ul class="copa03__banner__categories__content quedinha__content">
                    @for ($i = 0; $i < 5; $i++)
                        <li class="copa03__banner__categories__content__item">
                            <a href="#" class="copa03__banner__categories__content__item__link">Categoria
                                {{ $i }} </a>
                        </li>
                    @endfor
                </ul>
            </div>

        </section>

        <section class="copa03__topics">
            <header class="copa03__topics__header">
                <h1 class="copa03__topics__header__title">Título</h1>
                <h2 class="copa03__topics__header__subtitle">Subtítulo</h2>
                <hr class="copa03__topics__header__line">
            </header>

            <nav class="copa03__topics__subcategories">

                <ul class="copa03__topics__subcategories__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 4; $i++)
                        <li class="copa03__topics__subcategories__item swiper-slide">

                            <a href="#" class="link-full"></a>

                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                alt="Ícone do tópico [BACKEND: ADD TITULO AQUI]" loading="lazy"
                                class="copa03__topics__subcategories__item__icon">

                            Subcategoria {{ $i }}
                        </li>
                    @endfor

                </ul>
            </nav>

            <main class="copa03__topics__main">
                <div class="copa03__topics__main__swiper-wrapper swiper-wrapper">

                    @for ($i = 0; $i < 7; $i++)
                        <article class="copa03__topics__main__item swiper-slide">

                            <img src="{{ asset('storage/uploads/tmp/bg-boxitem-light.png') }}"
                                alt="Imagem de fundo do tópico [BACKEND: ADD TITULO AQUI]" loading="lazy"
                                class="copa03__topics__main__item__bg">

                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                alt="Ícone do tópico [BACKEND: ADD TITULO AQUI]" loading="lazy"
                                class="copa03__topics__main__item__icon">

                            <h3 class="copa03__topics__main__item__title">Título Tópico</h3>

                            <div class="copa03__topics__main__item__paragraph">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>

                            {{-- TODO: TESTE PARA VERIFICAR DOWNLOAD --}}
                            <a href="#" class="copa03__topics__main__item__cta">
                                CTA
                            </a>

                        </article>
                    @endfor

                </div>

                <div class="copa03__topics__main__nav">
                    <div class="copa03__topics__main__nav__swiper-button-prev swiper-button-prev"></div>
                    <div class="copa03__topics__main__nav__swiper-button-next swiper-button-next"></div>
                </div>
            </main>
        </section>

        <section class="copa03__videos">
            <header class="copa03__videos__header">
                <h2 class="copa03__videos__header__title">Título</h2>
                <h3 class="copa03__videos__header__subtitle">Subtítulo</h3>
                <hr class="copa03__videos__header__line">
            </header>

            <nav class="copa03__videos__subcategories">

                <ul class="copa03__videos__subcategories__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 4; $i++)
                        <li class="copa03__videos__subcategories__item swiper-slide">

                            <a href="#" class="link-full"></a>

                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                alt="Ícone do tópico [BACKEND: ADD TITULO AQUI]" loading="lazy"
                                class="copa03__videos__subcategories__item__icon">

                            Subcategoria {{ $i }}
                        </li>
                    @endfor
                </ul>
            </nav>

            <main class="copa03__videos__main">

                @for ($i = 0; $i < 9; $i++)
                    <article class="copa03__videos__main__item" data-fancybox
                        data-src="https://www.youtube.com/watch?v=X1uaOtiJ9Vc">

                        <img src="{{ asset('storage/uploads/tmp/bloco2.png') }}"
                            alt="Thumbnail do [BACKEND: ADD TITULO AQUI]" loading="lazy"
                            class="copa03__videos__main__item__bg">

                        <h3 class="copa03__videos__main__item__title">Título Vídeo</h3>

                    </article>
                @endfor

            </main>
        </section>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
