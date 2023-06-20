@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="prod05-page">

        <header class="prod05-page__header w-100">

            <div class="serv05-banner-carousel owl-carousel w-100">

                @for ($i = 0; $i < 3; $i++)
                    <div class="serv05-banner-carousel__item"
                        style="background-image: url({{ asset('storage/uploads/tmp/bg-banner-inner.jpg') }})">
                        <div class="container d-flex flex-column align-items-center justify-content-center">
                            <h3 class="serv05-banner-carousel__title text-center">Título Página {{ $i }}</h3>
                            <h4 class="serv05-banner-carousel__subtitle text-center">Subtítulo</h4>
                            <hr class="serv05-banner-carousel__line">
                        </div>
                    </div>
                @endfor

            </div>

            <div class="serv05-top w-100">
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    <h1 class="serv05-top__title text-center">Título Página {{ $i }}</h1>
                    <h2 class="serv05-top__subtitle text-center">Subtítulo</h2>
                    <hr class="serv05-top__line">
                    <div class="serv05-top__desc">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                            eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vel tortor</p>
                    </div>
                </div>
            </div>

        </header>

        <main class="prod05-page__main">
            <div class="container d-flex flex-column align-items-center">

                <div class="serv05-categories">

                    <ul class="serv05-categories__list w-100">
                        @for ($i = 0; $i < 3; $i++)
                            <li class="serv05-categories__list__item">
                                <a href="">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="serv05-categories__list__item__icon">
                                    Categoria
                                </a>
                            </li>
                        @endfor
                    </ul>

                    <div class="serv05-categories__dropdown-mobile">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header serv05-categories__dropdown-mobile__item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                            class="serv05-categories__dropdown-mobile__item__icon">
                                        Categoria
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @for ($i = 0; $i < 3; $i++)
                                                <li class="serv05-categories__dropdown-mobile__item">
                                                    <a href="">
                                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                            alt=""
                                                            class="serv05-categories__dropdown-mobile__item__icon">
                                                        Categoria
                                                    </a>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="prod05-page__main__list">

                    @for ($i = 0; $i < 8; $i++)
                        <article class="serv05-box"
                            style="background-image: url({{ asset('storage/uploads/tmp/bg-boxitem.png') }})">

                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                class="serv05-box__icon">

                            <div class="serv05-box__content w-100 d-flex flex-column align-items-stretch">
                                <div class="serv05-box__top w-100 d-flex align-items-center justify-content-between">
                                    <div
                                        class="serv05-box__top__left d-flex flex-column align-items-start justify-content-start ">

                                        <h3 class="serv05-box__top__title">Título</h3>
                                        <h4 class="serv05-box__top__subtitle">Subtitulo</h4>

                                    </div>

                                    <div
                                        class="serv05-box__top__right d-flex flex-column align-items-end justify-content-start ">
                                        <h4 class="serv05-box__top__subtitle">Subtitulo</h4>
                                        <h3 class="serv05-box__top__title">00,00</h3>
                                    </div>
                                </div>

                                <hr class="serv05-box__line">

                                <p class="serv05-box__desc">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. olor sit amet, consectetur
                                    adipiscing elit.
                                </p>

                                <a href="#" class="serv05-box__cta">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="serv05-box__cta__icon">
                                    CTA
                                </a>
                            </div>

                        </article>
                    @endfor

                </div>

                <ul class="prod05-page__pagination w-100 d-flex flex-row align-items-center justify-content-center">
                    @for ($i = 1; $i < 4; $i++)
                        <li class="prod05-page__pagination__item">
                            <a href="#">{{ $i }}</a>
                        </li>
                    @endfor
                </ul>

            </div>
        </main>

    </section>

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
