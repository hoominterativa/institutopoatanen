{{-- BEGIN Page content --}}
@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <style>
<<<<<<< Updated upstream
       {{-- --color-bgcolor: #f5f5f5; --}}
=======
        {{-- --color-bgcolor: #f5f5f5; --}}
>>>>>>> Stashed changes
    </style>
    <div id="root" class="copa04-page">

        {{-- 
      1 - section-hero
      2 - section-video
      3 - section-highlighted
      ---
      4 - topics 
      5 - topics - carousel
      6 - gallery topics
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
      ---
      7 - additional content
      8 - additional topics carousel
      9 - faq
      --
      10 - section products
      
      --}}
<<<<<<< Updated upstream
        <section class="copa04-page__hero" >
            <div class="copa04-page__hero__information">
            <div>
                <header class="copa04-page__hero__information__header">
                    <img class="copa04-page__hero__information__header__icon" src="" alt="">
                    <h1 class="copa04-page__hero__information__header__title"> title</h1>
                </header>
                <p class="copa04-page__hero__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt earum, facilis cum veritatis molestias
                    facere quisquam magni. Officia expedita accusantium corporis omnis similique earum maxime, optio quo
                    nulla, fuga esse!</p>
            </div>
            <a href="#" class="copa04-page__hero__information__cta">Olá</a>
        </div>
            <img class="copa04-page__hero__image" src="" alt="">
        </section>
        {{-- Seção Video --}}
        <section class="copa04-page__video">
                <h1 class="copa04-page__video__title">Title</h1>
                <h4 class="copa04-page__video__subtitle">Olá mundo</h4>
                <p class="copa04-page__video__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum quia aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis.</p>
                <iframe class="copa04-page__video__container__video" src="https://www.youtube.com/embed/EDnIEWyVIlE"></iframe>
        </section>
        {{-- Seção Highlighted --}}
        <section class="copa04-page__highlighted">
                <div class="copa04-page__highlighted__information">
                    <h1 class="copa04-page__highlighted__information__title">Title</h1>
                    <p class="copa04-page__highlighted__information__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum quia aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis.</p>
                </div>
                <div>
                <img class="copa04-page__highlighted__image" src="" height="" alt="">
                <a href="#" class="copa04-page__highlighted__information__cta">Olá</a>
            </div>
            </section>
=======
        <section class="copa04-page__hero">
            <div class="copa04-page__hero__information">
                <div>
                    <header class="copa04-page__hero__information__header">
                        <img class="copa04-page__hero__information__header__icon" src="{{ asset('storage/uploads/tmp/cta.png') }}" alt="">
                        <h1 class="copa04-page__hero__information__header__title"> title</h1>
                    </header>
                    <p class="copa04-page__hero__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt
                        earum, facilis cum veritatis molestias
                        facere quisquam magni. Officia expedita accusantium corporis omnis similique earum maxime, optio quo
                        nulla, fuga esse!</p>
                </div>
                <a href="#" class="copa04-page__hero__information__cta">Olá</a>
            </div>
            <img class="copa04-page__hero__image" src="{{ asset('storage/uploads/tmp/oi.png') }}" alt="">
        </section>
        {{-- Seção Video --}}
        <section class="copa04-page__video">
            <h1 class="copa04-page__video__title">Title</h1>
            <h4 class="copa04-page__video__subtitle">Olá mundo</h4>
            <p class="copa04-page__video__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto
                voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum quia aut! Quibusdam nobis
                qui laudantium commodi aut minus reiciendis.</p>
            <img id="video_play" src="{{ asset('storage/uploads/tmp/box-port02.png') }}" alt="">
        </section>
        {{-- Seção Highlighted --}}
        <section class="copa04-page__highlighted">
            <div class="copa04-page__highlighted__information">
                <h1 class="copa04-page__highlighted__information__title">Title</h1>
                <p class="copa04-page__highlighted__information__paragraph">Lorem ipsum dolor sit amet consectetur
                    adipisicing elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore
                    rerum quia aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis.</p>
            </div>
            <div>
                <img class="copa04-page__highlighted__image" src="{{ asset('storage/uploads/tmp/box-port02.png') }}"
                    height="" alt="">
                <a href="#" class="copa04-page__highlighted__information__cta">Olá</a>
            </div>
        </section>
>>>>>>> Stashed changes
        {{-- Seção Topics --}}
        <section class="copa04-page__topics">
            <div class="copa04-page__topics__information">
                <h1 class="copa04-page__topics__information__title">Title</h1>
                <h4 class="copa04-page__topics__information__subtitle">Olá mundo</h4>
<<<<<<< Updated upstream
                <p class="copa04-page__topics__information__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum quia aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis.</p>
=======
                <p class="copa04-page__topics__information__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum quia
                    aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis.</p>
            </div>
            <div class="copa04-page__topics__group-cards">
                <div>
                    <div class="copa04-page__topics__group-cards__card">
                        <h2>Olá Mundo</h2>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed distinctio ullam voluptas nihil maiores est labore fuga minima dolore vitae eaque inventore, corrupti laborum expedita vel neque molestias eum iusto.</p>
                    </div>
                    <div class="copa04-page__topics__group-cards__card">
                        <h2>Olá Mundo</h2>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed distinctio ullam voluptas nihil maiores est labore fuga minima dolore vitae eaque inventore, corrupti laborum expedita vel neque molestias eum iusto.</p>
                    </div>
                </div>
                <div>
                    <div class="copa04-page__topics__group-cards__card">
                        <h2>Olá Mundo</h2>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed distinctio ullam voluptas nihil maiores est labore fuga minima dolore vitae eaque inventore, corrupti laborum expedita vel neque molestias eum iusto.</p>
                    </div>
                    <div class="copa04-page__topics__group-cards__card">
                        <h2>Olá Mundo</h2>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed distinctio ullam voluptas nihil maiores est labore fuga minima dolore vitae eaque inventore, corrupti laborum expedita vel neque molestias eum iusto.</p>
                    </div>
            </div>
>>>>>>> Stashed changes
            </div>
        </section>
        {{-- Seção Topics - Carousel --}}
        <section class="copa04-page__topics-carousel">
<<<<<<< Updated upstream
=======
            <div class="copa04-page__topics-carousel__information">
                <h2 class="copa04-page__topics-carousel__information__title">Title</h2>
                <h4 class="copa04-page__topics-carousel__information__subtitle">Subtitle</h4>
                <p class="copa04-page__topics-carousel__information__paragraph">Olá Mundos</p>
            </div>
            <div>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                      <div class="swiper-slide">
                        <img class="swiper-slide__icon"src="{{ asset('storage/uploads/tmp/cta.png') }}" alt="">
                       <h5>Slide 01</h5>
                       <p>Olá Mundo</p>
                    </div>
                      <div class="swiper-slide">                        <img class="swiper-slide__icon"src="{{ asset('storage/uploads/tmp/cta.png') }}" alt="">
                        <h5>Slide 01</h5>
                        <p>Olá Mundo</p></div>
                      <div class="swiper-slide">                        <img class="swiper-slide__icon"src="{{ asset('storage/uploads/tmp/cta.png') }}" alt="">
                        <h5>Slide 01</h5>
                        <p>Olá Mundo</p></div>
                      <div class="swiper-slide">                        <img class="swiper-slide__icon"src="{{ asset('storage/uploads/tmp/cta.png') }}" alt="">
                        <h5>Slide 01</h5>
                        <p>Olá Mundo</p></div>
                      <div class="swiper-slide">                        <img class="swiper-slide__icon"src="{{ asset('storage/uploads/tmp/cta.png') }}" alt="">
                        <h5>Slide 01</h5>
                        <p>Olá Mundo</p></div>
                      <div class="swiper-slide">                        <img class="swiper-slide__icon"src="{{ asset('storage/uploads/tmp/cta.png') }}" alt="">
                        <h5>Slide 01</h5>
                        <p>Olá Mundo</p></div>
                      <div class="swiper-slide">Slide 7</div>
                      <div class="swiper-slide">Slide 8</div>
                      <div class="swiper-slide">Slide 9</div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                  </div>

            </div>
>>>>>>> Stashed changes
        </section>
        {{-- Seção Gallery Topics --}}
        <section class="copa04-page__gallery-topics">
        </section>
        {{-- Seção Additional Content --}}
        <section class="copa04-page__additional-content">
        </section>
        {{-- Seção Additional Topics Carousel --}}
        <section class="copa04-page__additional-topics-carousel">
        </section>
        {{-- Seção FAQ --}}
        <section class="copa04-page__faq">
        </section>
        {{-- Seção Section Products --}}
        <section class="copa04-page__section-products">
        </section>
<<<<<<< Updated upstream
    </div>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
=======
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    </div>

    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
>>>>>>> Stashed changes
    </div>
@endsection

{{-- Finish Content page Here --}}
