{{-- BEGIN Page content --}}
@extends('Client.Core.client')
@section('content')
    <main id="root" class="copa04-page">
        {{-- BEGIN Page content --}}
        <style>
            :root {
                --color-bgcolor: red;
                --topicsCarousel: #EFEFEF;
                --bg-topicsCarousel: rgb(159, 159, 255);
                /* --bg-test: @php echo isset($cor) && !empyt($cor) ? $cor :'#65ff00'; @endphp
                */
            }
        </style>
        <section class="copa04-page__hero">
            <aside class="copa04-page__hero__aside">
                <img class="copa04-page__hero__aside__logo" src="{{ asset('images/gray.png') }}"
                    alt="icone referente a seção {{-- title  --}}">
                <a class="copa04-page__hero__aside__cta" href="#">CTA</a>
            </aside>

            <div class="copa04-page__hero__information">
                <header class="copa04-page__hero__information__header">
                    <img class="copa04-page__hero__information__header__icon" src="{{ asset('images/icon.png') }}"
                        alt="ícone do {{-- title --}}">
                    <h1 class="copa04-page__hero__information__header__title">Title</h1>
                </header>
                <p class="copa04-page__hero__information__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing
                    elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel
                    tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem
                    ipsum dolor sit amet, consectetur adipiscing elit.

                </p>

                <a href="#" class="copa04-page__hero__information__cta">CTA</a>
            </div>
            <img class="copa04-page__hero__image" src="{{ asset('images/bg-colorido.svg') }}"
                alt="Imagem ilustrativa da seção {{-- title --}}">
        </section>

        {{-- Seção Video --}}
        <section class="copa04-page__video-section">
            <h2 class="copa04-page__video-section__title">Title</h2>
            <h3 class="copa04-page__video-section__subtitle">Subtitlo</h3>
            <p class="copa04-page__video-section__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Architecto
                voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum quia aut! Quibusdam nobis
                qui laudantium commodi aut minus reiciendis.</p>
            <div data-src="https://www.youtube.com/embed/EDnIEWyVIlE" class="copa04-page__video-section__video"
                style="background-image: url({{ asset('images/bg-colorido.svg') }})">
                <button id="video_play" class="copa04-page__video-section__video__button">
                    <img class="copa04-page__video-section__video__button__icon"
                        src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                </button>
            </div>
        </section>

        {{-- Seção Highlighted --}}
        <section class="copa04-page__highlighted">
            <div class="copa04-page__highlighted__information">
                <h2 class="copa04-page__highlighted__information__title">Title</h2>
                <h3 class="copa04-page__highlighted__information__subtitle">Subtitle</h3>
                <div class="copa04-page__highlighted__information__paragraph">
                    <p>Lorem ipsum dolor sit amet consectetur
                        adipisicing elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti
                        tempore
                        rerum quia aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis
                    </p>
                </div>
                <a href="#" class="copa04-page__highlighted__information__cta">CTA</a>
            </div>

            <img class="copa04-page__highlighted__image" src="{{ asset('images/bg-colorido.svg') }}"
                alt="Imagem referente a seção {{-- TITLE --}}">

        </section>

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
            <div class="copa04-page__additional-topics__swiper-wrapper swiper-wrapper">
                {{-- if image --}}
                @for ($i = 0; $i < 2; $i++)
                    <figure class="copa04-page__additional-topics__item swiper-slide">
                        <img class="copa04-page__additional-topics__item__image"
                            src="{{ asset('images/bg-colorido.svg') }}" alt=" {{-- title --}}">

                        <figcaption class="copa04-page__additional-topics__item__title">Title
                            {{ $i }}</figcaption>

                        <a href="#" class="copa04-page__additional-topics__item__cta">cta</a>
                    </figure>
                @endfor

                {{-- if video --}}
                @for ($i = 0; $i < 6; $i++)
                    <div class="copa04-page__additional-topics__item--video swiper-slide">
                        <div data-fancybox data-src="https://www.youtube.com/embed/EDnIEWyVIlE"
                            class="copa04-page__additional-topics__item--video__video"
                            style="background-image: url('{{ asset('images/bg-colorido.svg') }}')">
                            <button id="video_play" class="copa04-page__additional-topics__item--video__video__button">
                                <img class="copa04-page__additional-topics__item--video__video__button__icon"
                                    src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                            </button>
                        </div>
                        <p class="copa04-page__additional-topics__item--video__title">
                            Título com video {{ $i }}
                        </p>
                        <a href="" class="copa04-page__additional-topics__item--video__cta">cta</a>

                    </div>
                @endfor
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
                            <h5 class="copa04-page__section-products__carousel__item__subtitle">Title</h5>
                            <div class="copa04-page__section-products__carousel__item__paragraph">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur quam esse et, debitis
                                    magnam tempore placeat aperiam dignissimos illo, ipsam nesciunt omnis quis nam odit
                                    nihil
                                    animi tenetur nobis velit.
                                </p>
                            </div>
                            <div class="copa04-page__section-products__carousel__item__price">
                                <h6 class="copa04-page__section-products__carousel__item__price__title">Subtitulo</h6>
                                <p class="copa04-page__section-products__carousel__item__price__paragraph">R$ <b>00,00</b>
                                </p>

                            </div>
                            <a class="copa04-page__section-products__carousel__item__cta" href="#">CTA</a>


                        </div>
                    @endfor
                </div>
            </div>

        </section>
    </main>

    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
    </div>
@endsection

{{-- Finish Content page Here --}}
