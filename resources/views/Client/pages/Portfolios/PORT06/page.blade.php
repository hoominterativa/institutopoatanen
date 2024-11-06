@extends('Client.Core.client')
@section('content')
    <main id="root">

        <section class="port06-page__banner" style="background-image: url({{ asset('images/banner.png') }})">
            <h2 class="port06-page__banner__subtitle">Subtítulo</h2>
            <h1 class="port06-page__banner__title">Título</h1>
        </section>

        <aside class="port06-page__categories">
            <menu class="port06-page__categories__swiper-wrapper swiper-wrapper">
                @for ($i = 0; $i < 5; $i++)
                    <a class="port06-page__categories__item swiper-slide" href="#" title="[título da categoria]">
                        Categoria
                    </a>
                @endfor
            </menu>
        </aside>

        <section class="port06-page__list">

            @for ($i = 0; $i < 12; $i++)
                <article class="port06-page__list__item">
                    <img src="{{ asset('images/imageServ.png') }}" alt="Imagem do [título do item]"
                        class="port06-page__list__item__image">
                    <span class="port06-page__list__item__category">Categoria</span>
                    <h4 class="port06-page__list__item__title">Título do item</h4>
                    <p class="port06-page__list__item__paragraph">Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. </p>
                </article>
            @endfor

        </section>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
