@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section class="port03-page popa">
    <header class="popa__banner container-fluid px-0">
        <div class="popa__banner__container">
            <div class="popa__banner__image"
                style="background-image: url();  background-color: ;">
                    <div class="container popa__banner__header text-center">
                        <h4 class="popa__banner__header__title">Titulo da Página</h4>
                        <hr class="popa__banner__header__line">
                    </div>
            </div>
        </div>
    </header>
    <main class="popa__portfolio">
            <div class="popa__portfolio__header">
                <div class="container">
                    <div class="popa__portfolio__header__top">
                        <div class="popa__portfolio__header__top__left">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícone da categoria"
                            class="popa__portfolio__header__top__left__icon">
                        </div>
                        <div class="popa__portfolio__header__top__right">
                            <h2 class="popa__portfolio__header__top__right__title">Titulo</h2>
                            <h1 class="popa__portfolio__header__top__right__subtitle">Subtitulo</h1>
                        </div>
                    </div>
                    <div class="popa__portfolio__header__bottom">
                        <hr class="popa__portfolio__header__bottom__line">
                        <div class="popa__portfolio__header__bottom__description">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin
                                vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                Donec tincidunt dignissim faucibus.
                                Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="popa__portfolio__categories">
                <div class="container">
                    <ul class="popa__portfolio__categories__list w-100  mb-0 px-0">
                        <div class="popa__portfolio__categories__carousel">
                                @for ($i = 0; $i <= 16; $i++)
                                <li
                                    class="popa__portfolio__categories__list__item">
                                    <a class=" d-flex w-100 h-100 justify-content-between align-items-center" href="#">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícone da categoria"
                                                class="popa__portfolio__categories__list__item__icon">
                                            Categoria
                                    </a>
                                </li>
                                @endfor
                        </div>
                    </ul>

                    <div class="popa__portfolio__categories__dropdown-mobile">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2
                                    class="accordion-header popa__portfolio__categories__dropdown-mobile__item">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                            alt=""
                                            class="popa__portfolio__categories__dropdown-mobile__item__icon">
                                        Categorias
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul>

                                                <li
                                                    class="popa__portfolio__categories__dropdown-mobile__item">
                                                    <a class=" d-flex w-100 h-100 justify-content-start align-items-center"
                                                        href="#">
                                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                                alt="Ícone da categoria"
                                                                class="popa__portfolio__categories__dropdown-mobile__item__icon">
                                                            Categoria
                                                    </a>
                                                </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="popa__portfolio__content container px-0">
                <div class="row">
                @for ($i = 0; $i <= 16; $i++)
                <article class="popa__portfolio__content__item col-sm-4 position-relative">
                    <a class="link-full" href="#"></a>
                    <div class="popa__portfolio__content__item__encompass">
                        <div class="popa__portfolio__content__item__images mx-auto">
                            <div class="carousel-box-image owl-carousel">
                                <div class="popa__portfolio__content__item__images__image">
                                    {{-- <span class="before-text">Antes</span> --}}
                                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" alt="Imagem">
                                </div>
                                {{-- fim popa__portfolio__content__item__images__image --}}
                                <div class="popa__portfolio__content__item__images__image">
                                    {{-- <span class="after-text">Depois</span> --}}
                                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" alt="Imagem">
                                </div>
                                {{-- fim popa__portfolio__content__item__images__image --}}
                            </div>
                        </div>
                        <div class="popa__portfolio__content__item__description">
                            <h4 class="popa__portfolio__content__item__description__title">Título</h4>
                            <div class="popa__portfolio__content__item__description__paragraph">
                                <p>Descrição</p>
                            </div>
                        </div>
                    </div>
                </article>
                {{-- fim popa__portfolio__content__item --}}
                @endfor
                </div>
            </div>
    </main>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
