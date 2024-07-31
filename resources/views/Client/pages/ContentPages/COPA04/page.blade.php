{{-- BEGIN Page content --}}
@extends('Client.Core.client')
@section('content')
    <main id="root" class="copa04-page">
        {{-- BEGIN Page content --}}
        <style>
            /* BACKEND: Imprimir as variaveis de cor aqui ❤ */
            :root {
                --bg-hero-primary: {{ $sectionHeros ? $sectionHeros->color_one : 'lightgray' }};
                --bg-hero-secondary: {{ $sectionHeros ? $sectionHeros->color_two : 'lightblue' }};
                --bg-hero-tertiary: {{ $sectionHeros ? $sectionHeros->color_three : 'white' }};
                --bg-video-section: green;
                --bg-higlighted: purple;
                --bg-topics: lightblue;
                --bg-topics-carousel: pink;
                --bg-gallery-topics: lightgray;
                --bg-additional-content: lightgreen;
                --bg-faq: lightyellow;
                --bg-products: gray;


            }/
        </style>
        {{-- Seção Hero --}}
        {{-- {{ $sectionHeros ? $sectionHeros->color_one : 'default_primary_value' }}; --}}
        @if ($sectionHeros)
        
        <section class="copa04-page__hero ">
            <aside class="copa04-page__hero__aside">
                <img class="copa04-page__hero__aside__logo" src="{{ asset('images/gray.png') }}"
                    alt="icone referente a seção {{-- title  --}}">
                <a class="copa04-page__hero__aside__cta" href="#">CTA</a>
            </aside>

            <div class="copa04-page__hero__information">
                <header class="copa04-page__hero__information__header">
                    <img class="copa04-page__hero__information__header__icon" src="{{ asset('images/icon.png') }}"
                        alt="ícone do {{-- title --}}">
                    <h1 class="copa04-page__hero__information__header__title">{{ $sectionHeros->title }}</h1>
                </header>
                <p class="copa04-page__hero__information__paragraph">
                    
                    {!! $sectionHeros->description  !!}

                </p>

                <a href="{{ $sectionHeros->link }}" class="copa04-page__hero__information__cta">{{ $sectionHeros->title_btn }}</a>
            </div>
            <img class="copa04-page__hero__image" src="{{ asset('storage/'.$sectionHeros->path_image) }}"
                alt="Imagem ilustrativa da seção {{-- title --}}">
        </section>
        @endif
        {{-- Seção Video --}}
        @if($sectionVideo)
        <section class="copa04-page__video-section">
            @if($sectionVideo->title)
            <h2 class="copa04-page__video-section__title">{{ $sectionVideo->title }}</h2>
            @endif

            @if($sectionVideo->subtitle)
            <h3 class="copa04-page__video-section__subtitle">{{ $sectionVideo->subtitle }}</h3>
            @endif
            @if($sectionVideo->text)
            <div class="copa04-page__video-section__paragraph">
                {!! $sectionVideo->text !!}
            </div>
            @endif
            @if($sectionVideo->link)
            <div data-src="{{ $sectionVideo->link ?? "Error" }}" class="copa04-page__video-section__video"
                style="background-image: url({{ asset('images/bg-colorido.svg') }})">
                <button id="video_play" class="copa04-page__video-section__video__button">
                    <img class="copa04-page__video-section__video__button__icon"
                        src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                </button>
            </div>
            @endif
        </section>
        @endif
        {{-- Seção Highlighted --}}
        @if($sectionHighlighted)
        <section class="copa04-page__highlighted">
            <div class="copa04-page__highlighted__information">
                <h2 class="copa04-page__highlighted__information__title">{{ $sectionHighlighted->title }}</h2>
                <h3 class="copa04-page__highlighted__information__subtitle">{{ $sectionHighlighted->subtitle }}</h3>
                <div class="copa04-page__highlighted__information__paragraph">

                        {!! $sectionHighlighted->text !!}

                </div>
                <a href="#" class="copa04-page__highlighted__information__cta">{{ $sectionHighlighted->btn_title }}</a>
            </div>

            <img class="copa04-page__highlighted__image" src="{{ asset('storage/'.$sectionHighlighted->path_image) }}"
                alt="Imagem referente a seção {{-- TITLE --}}">

        </section>
        @endif

        {{-- Seção Topics --}}
        <section class="copa04-page__topics">
            <header class="copa04-page__topics__header">
                <h2 class="copa04-page__topics__header__title">Title</h2>
                <h3 class="copa04-page__topics__header__subtitle">Subtitle</h3>
                <div class="copa04-page__topics__header__paragraph">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum
                        quia
                        aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis.</p>
                </div>
            </header>


            <div class="copa04-page__topics__main">
                @for ($i = 0; $i < 4; $i++)
                    <div class="copa04-page__topics__main__item">
                        <img class="copa04-page__topics__main__item__icon" src="{{ asset('images/icon.svg') }}"
                            alt="ícone do tópico {{-- title --}}">
                        <h4 class="copa04-page__topics__main__item__title">Title {{ $i }}</h4>
                        <div class="copa04-page__topics__main__item__paragraph">
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed distinctio ullam voluptas nihil
                                maiores est labore fuga minima dolore vitae eaque inventore, corrupti laborum expedita vel
                                neque
                                molestias eum iusto.</p>
                        </div>
                    </div>
                @endfor
            </div>
            <a href="#" class="copa04-page__topics__cta">CTA</a>
        </section>

        {{-- Seção Topics - Carousel --}}
        <section class="copa04-page__topics-carousel">
            <header class="copa04-page__topics-carousel__header">
                <h2 class="copa04-page__topics-carousel__header__title">Title</h2>
                <h3 class="copa04-page__topics-carousel__header__subtitle">Subtitle</h3>
                <div class="copa04-page__topics-carousel__header__paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae pariatur distinctio unde
                        similique. Animi itaque minima eius dolor voluptatem nulla, laboriosam porro officiis, ducimus
                        necessitatibus iure sequi tenetur quaerat? Temporibus.</p>
                </div>
            </header>
            <div class="copa04-page__topics-carousel__carousel">
                <div class="copa04-page__topics-carousel__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="copa04-page__topics-carousel__carousel__item swiper-slide">
                            <img class="copa04-page__topics-carousel__carousel__item__icon"
                                src="{{ asset('images/icon.svg') }}" alt="ícone do tópico {{-- title --}}">
                            <h4 class="copa04-page__topics-carousel__carousel__item__title">Title {{ $i }}</h4>
                            <div class="copa04-page__topics-carousel__carousel__item__paragraph">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed distinctio ullam voluptas
                                    nihil
                                    maiores est labore fuga minima dolore vitae eaque inventore, corrupti laborum expedita
                                    vel
                                    neque
                                    molestias eum iusto.</p>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
            <a href="#" class="copa04-page__topics-carousel__cta">CTA</a>
        </section>

        {{-- Seção Gallery Topics --}}
        <section class="copa04-page__gallery-topics">
            <header class="copa04-page__gallery-topics__header">
                <h2 class="copa04-page__gallery-topics__header__title">Title</h2>
                <h3 class="copa04-page__gallery-topics__header__subtitle">Subtitle</h3>
                <div class="copa04-page__gallery-topics__header__paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae pariatur distinctio unde
                        similique. Animi itaque minima eius dolor voluptatem nulla, laboriosam porro officiis, ducimus
                        necessitatibus iure sequi tenetur quaerat? Temporibus.</p>
                </div>
            </header>
            <div class="copa04-page__gallery-topics__carousel">
                <div class="copa04-page__gallery-topics__carousel__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="copa04-page__gallery-topics__carousel__item swiper-slide">
                            {{-- se image usar essa estrutura --}}
                            {{-- <img class="copa04-page__gallery-topics__carousel__item__image"
                                src="{{ asset('images/bg-colorido.svg') }}" alt="Imagem do tópico {{-- title "> --}}

                            {{-- se video --}}
                            <div data-fancybox data-src="https://www.youtube.com/embed/EDnIEWyVIlE"
                                class="copa04-page__gallery-topics__carousel__item__video"
                                style="background-image: url('{{ asset('images/bg-colorido.svg') }}')">
                                <button id="video_play" class="copa04-page__gallery-topics__carousel__item__video__button">
                                    <img class="copa04-page__gallery-topics__carousel__item__video__button__icon"
                                        src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                                </button>
                            </div>

                            <div class="copa04-page__gallery-topics__carousel__item__information">
                                <h4 class="copa04-page__gallery-topics__carousel__item__information__title">Title
                                    {{ $i }}</h4>
                                <p class="copa04-page__gallery-topics__carousel__item__information__paragraph">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed distinctio ullam voluptas
                                    nihil
                            </div>
                        </div>
                    @endfor
                </div>
        </section>

        {{-- Seção Additional Content --}}
        <section class="copa04-page__additional-content">
            <div class="copa04-page__additional-content__header">
                <div class="copa04-page__additional-content__header__title"> title</div>
                <div class="copa04-page__additional-content__header__subtitle"> Subtitle</div>
                <div class="copa04-page__additional-content__header__paragraph">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Expedita eaque ducimus cumque culpa! Obcaecati expedita accusamus ratione eligendi sint,
                    nemo sapiente soluta saepe rem alias nobis ad voluptate. Incidunt, expedita.</div>
                <a class="copa04-page__additional-content__header__cta" href="">CTA</a>
            </div>
            <div class="copa04-page__additional-content__carousel">
                <div class="copa04-page__additional-content__carousel__swiper-wrapper swiper-wrapper">
                    {{-- if image --}}
                    <img class="copa04-page__additional-content__carousel__item swiper-slide"
                        src="{{ asset('images/bg-colorido.svg') }}" alt="{Image}">
                    {{-- if video --}}
                    <div data-fancybox data-src="https://www.youtube.com/embed/EDnIEWyVIlE"
                        class="copa04-page__additional-content__carousel__item--video swiper-slide"
                        style="background-image: url('{{ asset('images/bg-colorido.svg') }}')">
                        <button id="video_play" class="copa04-page__additional-content__carousel__item--video__button">
                            <img class="copa04-page__additional-content__carousel__item--video__button__icon"
                                src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                        </button>
                    </div>
                </div>

            </div>

        </section>

        {{-- Seção Additional Topics Carousel --}}
        <section class="copa04-page__additional-topics">
            <div class="copa04-page__additional-topics__carousel">
                <div class="copa04-page__additional-topics__carousel__swiper-wrapper swiper-wrapper">
                    {{-- if image --}}
                    @for ($i = 0; $i < 2; $i++)
                        <figure class="copa04-page__additional-topics__carousel__item swiper-slide">
                            <img class="copa04-page__additional-topics__carousel__item__image"
                                src="{{ asset('images/bg-colorido.svg') }}" alt=" {{-- title --}}">

                            <figcaption class="copa04-page__additional-topics__carousel__item__title">Title
                                {{ $i }}</figcaption>

                            <a href="#" class="copa04-page__additional-topics__carousel__item__cta">cta</a>
                        </figure>
                    @endfor

                    {{-- if video --}}
                    @for ($i = 0; $i < 6; $i++)
                        <div class="copa04-page__additional-topics__carousel__item--video swiper-slide">
                            <div data-fancybox data-src="https://www.youtube.com/embed/EDnIEWyVIlE"
                                class="copa04-page__additional-topics__carousel__item--video__video"
                                style="background-image: url('{{ asset('images/bg-colorido.svg') }}')">
                                <button id="video_play"
                                    class="copa04-page__additional-topics__carousel__item--video__video__button">
                                    <img class="copa04-page__additional-topics__carousel__item--video__video__button__icon"
                                        src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                                </button>
                            </div>
                            <p class="copa04-page__additional-topics__carousel__item--video__title">
                                Título com video {{ $i }}
                            </p>
                            <a href="" class="copa04-page__additional-topics__carousel__item--video__cta">cta</a>

                        </div>
                    @endfor
                </div>
            </div>
        </section>

        {{-- Seção FAQ --}}
        <section class="copa04-page__faq">
            <header class="copa04-page__faq__header">
                <h2 class="copa04-page__faq__header__title">Title</h2>
                <h3 class="copa04-page__faq__header__subtitle">Subtitle</h3>
                <div class="copa04-page__faq__header__paragraph">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum
                        quia
                        aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis.</p>
                </div>
            </header>
            @for ($i0; $i < 10; $i++)
                <details class="copa04-page__faq__item">
                    <summary class="copa04-page__faq__item__title" aria-level="3" role="heading">
                        Título
                    </summary>
                    <p class="copa04-page__faq__item__paragraph details-content">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur, vel sunt aperiam nam dolores
                        atque.
                    </p>
                </details>
            @endfor
        </section>

        {{-- Seção Section Products --}}
        <section class="copa04-page__section-products">
            <header class="copa04-page__section-products__header">
                <h2 class="copa04-page__section-products__header__title">Title</h2>
                <h3 class="copa04-page__section-products__header__subtitle">Subtitle</h3>
                <div class="copa04-page__section-products__header__paragraph">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum
                        quia
                        aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis.</p>
                </div>
            </header>
            <div class="copa04-page__section-products__carousel">
                <div class="copa04-page__section-products__carousel__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="copa04-page__section-products__carousel__item swiper-slide">
                            {{-- if tag --}}
                            <span class="copa04-page__section-products__carousel__item__tag">Promoção</span>
                            <h4 class="copa04-page__section-products__carousel__item__title">Title</h4>
                            <h5 class="copa04-page__section-products__carousel__item__subtitle">Subtitle</h5>
                            <div class="copa04-page__section-products__carousel__item__paragraph">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur quam esse et, debitis
                                    magnam tempore placeat aperiam dignissimos illo, ipsam nesciunt omnis quis nam odit
                                    nihil
                                    animi tenetur nobis velit.
                                </p>
                            </div>
                            <div class="copa04-page__section-products__carousel__item__price">
                                <h6 class="copa04-page__section-products__carousel__item__price__title">Subtitle</h6>
                                <p class="copa04-page__section-products__carousel__item__price__paragraph">R$ <b>00,00</b>
                                </p>

                            </div>
                            <a class="copa04-page__section-products__carousel__item__cta" href="#">CTA</a>


                        </div>
                    @endfor
                </div>
            </div>

        </section>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
