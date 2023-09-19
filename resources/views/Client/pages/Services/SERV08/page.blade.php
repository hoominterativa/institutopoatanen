@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

<section class="serv08-page">
    <header class="serv08-page__header w-100">
        <div class="serv08-banner-carousel owl-carousel w-100">

            <div class="serv08-banner-carousel__item" style="background-image: url({{ asset('images/banner.png') }});  background-color: #ffffff;">
                <div class="container d-flex flex-column align-items-center justify-content-center">

                    <h3 class="serv08-banner-carousel__title text-center">Titulo do banner</h3>
                    <h4 class="serv08-banner-carousel__subtitle text-center">Subtítulo</h4>
                    <hr class="serv08-banner-carousel__line">

                </div>
            </div>

        </div>
        <div class="serv08-top w-100">
            <div class="container d-flex flex-column align-items-center justify-content-center">

                <h1 class="serv08-top__title text-center">Subtitulo</h1>
                <h2 class="serv08-top__subtitle text-center">Título</h2>
                <hr class="serv08-top__line">
                <div class="serv08-top__desc">
                    <p>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Similique ipsa possimus quidem rerum vel ratione reiciendis culpa blanditiis eligendi animi.
                    </p>
                </div>
                <div class="serv08-categories">
                    <ul class="serv08-categories__list w-100 serv08__categories owl-carousel">
                        @for ($i = 0; $i < 5; $i++) <li class="serv08-categories__list__item ">
                            <a href="">
                                <img src="{{ asset('images/cta.png') }}" alt="" class="serv08-categories__list__item__icon">
                                Categoria
                            </a>
                            </li>
                            @endfor
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <main class="serv08-page__main">
        <div class="container d-flex flex-column align-items-center">
            <div class="serv08-page__main__list">
                @for ($i = 0; $i < 10; $i++) <article class="serv08-box" style="background-image: url({{ asset('images/gray.png') }}); background-color: #ffffff;">
                    <div class="serv08-box__promotion">
                        <h4 class="serv08-box__promotion__titulo">Promoção</h4>
                    </div>
                    <div class="serv08-box__content w-100 d-flex flex-column align-items-stretch">
                        <div class="serv08-box__top w-100 d-flex align-items-center justify-content-between">
                            <div class="serv08-box__top__left d-flex flex-column align-items-start justify-content-start ">
                                <h3 class="serv08-box__top__title">Titulo Topico</h3>
                                <h4 class="serv08-box__top__subtitle">subtítulo</h4>
                                <hr class="serv08-box__line">
                            </div>
                            <div class="serv08-box__top__center d-flex flex-column align-items-start justify-content-start ">
                                <h3 class="serv08-box__top__center__title">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur veritatis qui error odi.</h3>
                                <ul class="serv08-box__top__center__list">

                                    <li class="serv08-box__top__center__list__item">
                                        <span><img src="{{ asset('images/cta.png') }}" alt="Icone check"></span>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo veritatis.
                                    </li>
                                    <li class="serv08-box__top__center__list__item">
                                        <span><img src="{{ asset('images/cta.png') }}" alt="Icone check"></span>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo veritatis.
                                    </li>
                                    <li class="serv08-box__top__center__list__item">
                                        <span><img src="{{ asset('images/cta.png') }}" alt="Icone check"></span>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo veritatis.
                                    </li>
                                    <li class="serv08-box__top__center__list__item">
                                        <span><img src="{{ asset('images/cta.png') }}" alt="Icone check"></span>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo veritatis.
                                    </li>
                                    <li class="serv08-box__top__center__list__item">
                                        <span><img src="{{ asset('images/cta.png') }}" alt="Icone check"></span>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo veritatis.
                                    </li>

                                </ul>
                            </div>
                            <div class="serv08-box__top__right d-flex flex-column align-items-end justify-content-start ">
                                <h4 class="serv08-box__top__subtitlee">subtítulo</h4>
                                <h3 class="serv08-box__top__title"><span>R$</span>00,00</h3>
                            </div>
                        </div>
                        <div class="serv08-box__desc">
                            <p></p>
                        </div>
                        @include('Client.pages.Services.SERV08.show',[
                            'service'=>$service,
                            'compliance' => $compliance,
                            'inputs'=>$inputs,
                        ])
                        <a rel="next" class="serv08-box__cta" href="#lightbox-serv08" data-fancybox="" data-src="#lightbox-serv08">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv08-box__cta__icon">
                            CTA
                        </a>
                    </div>
                    </article>
                    @endfor

            </div>
            <ul class="serv08-page__pagination w-100 d-flex flex-row align-items-center justify-content-center">
                @for ($i = 1; $i < 4; $i++) <li class="serv08-page__pagination__item">
                    <a href="#">01</a>
                    </li>
                    @endfor
            </ul>
            <nav aria-label="..." class="serv08-page__pagination">

            </nav>
        </div>
    </main>
</section>


{{-- Finish Content page Here --}}
@foreach ($sections as $section)
{!!$section!!}
@endforeach
@endsection
