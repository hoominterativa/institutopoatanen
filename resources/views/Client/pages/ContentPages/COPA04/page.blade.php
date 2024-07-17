{{-- BEGIN Page content --}}
@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <style>
       {{-- --color-bgcolor: #f5f5f5; --}}
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
      ---
      7 - additional content
      8 - additional topics carousel
      9 - faq
      --
      10 - section products
      
      --}}
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
        {{-- Seção Topics --}}
        <section class="copa04-page__topics">
            <div class="copa04-page__topics__information">
                <h1 class="copa04-page__topics__information__title">Title</h1>
                <h4 class="copa04-page__topics__information__subtitle">Olá mundo</h4>
                <p class="copa04-page__topics__information__paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto voluptatum cumque a doloribus, deleniti totam quod omnis, corrupti tempore rerum quia aut! Quibusdam nobis qui laudantium commodi aut minus reiciendis.</p>
            </div>
        </section>
        {{-- Seção Topics - Carousel --}}
        <section class="copa04-page__topics-carousel">
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
    </div>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </div>
@endsection

{{-- Finish Content page Here --}}
