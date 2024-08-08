@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="bran02-page">
        <section class="bran02-page__banner" style="background-image: url({{ asset('images/bg-colorido.svg') }})">
            <h1 class="bran02-page__banner__title">title</h1>
            <h2 class="bran02-page__banner__subtitle">Subtitle</h2>
        </section>
        <header class="bran02-page__header">
            <h2 class="bran02-page__header__title">Idiota</h2>
            <h3 class="bran02-page__header__subtitle">Subtitle</h3>
            <div class="bran02-page__header__description">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam corporis optio dolore accusamus ex
                    harum.
                    At, ab hic nisi ex quam quasi enim quisquam, eius, deleniti ducimus architecto? Quos, quisquam?
                </p>
            </div>
        </header>
        <aside class="bran02-page__categories">
            <menu class="bran02-page__categories__swiper-wrapper swiper-wrapper">
                <a href="#" class="bran02-page__categories__item swiper-slide active">Category</a>

                @for ($i = 0; $i < 20; $i++)
                    <a href="#" class="bran02-page__categories__item swiper-slide">Category</a>
                @endfor
            </menu>

        </aside>
        <div class="bran02-page__products">
            @for ($i = 0; $i < 6; $i++)
                <img class="bran02-page__products__item" src="{{ asset('storage/uploads/tmp/thumbnail-b.png') }}"
                    alt="Imagem referente a seção {{-- TITLE --}}">
            @endfor
        </div>
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
    {{-- Finish Content page Here --}}
@endsection
