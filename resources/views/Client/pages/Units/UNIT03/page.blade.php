@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <section class="unit03-page w-100">
        <header class="unit03-page__banner"
            style="background-image: url({{ asset('storage/uploads/tmp/bg-section-dark-gray.jpg') }})">
            <div class="unit03-page__banner__content container d-flex flex-column align-items-center justify-content-center">
                <h1 class="unit03-page__banner__title text-center">Título da Página</h1>
                <h2 class="unit03-page__banner__subtitle text-center">Subtítulo</h2>
                <hr class="unit03-page__banner__line">
            </div>
        </header>

        <main class="unit03-page__main w-100 d-flex flex-column">
            <div class="container d-flex flex-column align-items-stretch">

                <ul class="unit03-page__categories w-100">
                    @for ($i = 0; $i < 3; $i++)
                        <li class="unit03-page__categories__item">
                            <a href="">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="unit03-page__categories__item__icon">
                                Categoria
                            </a>
                        </li>
                    @endfor
                </ul>

                <div class="unit03-page__categories__dropdown-mobile">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header unit03-page__categories__dropdown-mobile__item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="unit03-page__categories__dropdown-mobile__item__icon">
                                    Categoria
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        @for ($i = 0; $i < 3; $i++)
                                            <li class="unit03-page__categories__dropdown-mobile__item">
                                                <a href="">
                                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                        alt=""
                                                        class="unit03-page__categories__dropdown-mobile__item__icon">
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

                <div class="unit03-page__list w-100">

                    @for ($i = 0; $i < 8; $i++)
                        <article class="unit03-page__list__item">
                            <a href="#" class="link-full"></a>

                            <div class="unit03-page__list__item__top">
                                <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" alt=""
                                    class="unit03-page__list__item__img">
                                <h2 class="unit03-page__list__item__title">Título</h2>
                            </div>

                            <div class="unit03-page__list__item__bottom">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="unit03-page__list__item__icon">
                            </div>
                        </article>
                    @endfor

                </div>

            </div>
        </main>

    </section>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
