@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="prod05-page">

        <header class="prod05-page__header w-100">

            <div class="prod05-banner w-100"
                style="background-image: url({{ asset('storage/uploads/tmp/bg-banner-inner.jpg') }})">
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    <h3 class="prod05-banner__title text-center">Título Banner</h3>
                    <h4 class="prod05-banner__subtitle text-center">Subtítulo</h4>
                    <hr class="prod05-banner__line">

                    {{-- CATEGORIAS --}}
                    <div class="prod05-categories">

                        <ul class="prod05-categories__list w-100">
                            <li class="active prod05-categories__list__item">
                                <a href="">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="prod05-categories__list__item__icon">
                                    Categoria
                                </a>
                            </li>
                            @for ($i = 0; $i < 3; $i++)
                                <li class="prod05-categories__list__item">
                                    <a href="">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                            class="prod05-categories__list__item__icon">
                                        Categoria
                                    </a>
                                </li>
                            @endfor
                        </ul>

                        <div class="prod05-categories__dropdown-mobile">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header prod05-categories__dropdown-mobile__item">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseOne" aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                                class="prod05-categories__dropdown-mobile__item__icon">
                                            Categoria
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <ul>
                                                @for ($i = 0; $i < 3; $i++)
                                                    <li class="prod05-categories__dropdown-mobile__item">
                                                        <a href="">
                                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                                alt=""
                                                                class="prod05-categories__dropdown-mobile__item__icon">
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
                </div>
            </div>

            <div class="prod05-top w-100">
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    <h1 class="prod05-top__title text-center">Título Página</h1>
                    <h2 class="prod05-top__subtitle text-center">Subtítulo</h2>
                    <hr class="prod05-top__line">
                    <div class="prod05-top__desc">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                            eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vel tortor</p>
                    </div>

                    {{-- SUBCATEGORIAS --}}
                    <div class="prod05-categories">

                        <ul class="prod05-categories__list w-100">
                            @for ($i = 0; $i < 3; $i++)
                                <li class="prod05-categories__list__item">
                                    <a href="">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                            class="prod05-categories__list__item__icon">
                                        Subcategoria
                                    </a>
                                </li>
                            @endfor
                        </ul>

                        <div class="prod05-categories__dropdown-mobile">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header prod05-categories__dropdown-mobile__item">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseOne" aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                                class="prod05-categories__dropdown-mobile__item__icon">
                                            Categoria
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <ul>
                                                @for ($i = 0; $i < 3; $i++)
                                                    <li class="prod05-categories__dropdown-mobile__item">
                                                        <a href="">
                                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                                alt=""
                                                                class="prod05-categories__dropdown-mobile__item__icon">
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
                </div>
            </div>

        </header>

        <main class="prod05-page__main">
            <div class="container d-flex flex-column align-items-center">


                <div class="prod05-page__main__list">

                    @for ($i = 0; $i < 6; $i++)
                        <article class=" prod05-box">

                            <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" alt=""
                                class="prod05-box__image">

                            <div class="prod05-box__content w-100 d-flex flex-column align-items-center">
                                <div class="prod05-box__top w-100 d-flex flex-column align-items-center">

                                    <h3 class="prod05-box__top__title">Título</h3>
                                    <h4 class="prod05-box__top__subtitle">Subtitulo</h4>

                                </div>

                                <hr class="prod05-box__line">

                                <p class="prod05-box__desc">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>

                                <a href="#" class="prod05-box__cta">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="prod05-box__cta__icon">
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
