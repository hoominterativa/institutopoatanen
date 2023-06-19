@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <section class="serv06-page">
        <header class="serv06-page__header"
            style="background-image: url({{ asset('storage/uploads/tmp/bg-section-gray.jpg') }})">
            <div class="container d-flex flex-column align-items-center">

                <h1 class="serv06-page__title">Título</h1>

                <h3 class="serv06-page__subtitle">Subtítulo</h3>

                <hr class="serv06-page__line">

                <div class="serv06-categories">

                    <ul class="serv06-categories__list w-100">
                        @for ($i = 0; $i < 3; $i++)
                            <li class="serv06-categories__list__item">
                                <a href="">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="serv06-categories__list__item__icon">
                                    Categoria
                                </a>
                            </li>
                        @endfor
                    </ul>

                    <div class="serv06-categories__dropdown-mobile">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header serv06-categories__dropdown-mobile__item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                            class="serv06-categories__dropdown-mobile__item__icon">
                                        Categoria
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @for ($i = 0; $i < 3; $i++)
                                                <li class="serv06-categories__dropdown-mobile__item">
                                                    <a href="">
                                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                            alt=""
                                                            class="serv06-categories__dropdown-mobile__item__icon">
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
        </header>

        <main class="serv06-page__main">

            @for ($i = 1; $i < 3; $i++)
                <article id="sec{{ $i }}" class="serv06-page__item w-100">
                    <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" alt=""
                        class="serv06-page__item__image">

                    <div class="serv06-page__item__right">
                        <h4 class="serv06-page__item__subtitle">Subtítulo</h4>
                        <h3 class="serv06-page__item__title">Título</h3>
                        <hr class="serv06-page__item__line">

                        <div class="serv06-page__item__text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                                sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et
                                arcu
                                eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                                consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis
                                posuere.
                                Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit,
                                vel
                                tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec </p>
                        </div>

                    </div>
                </article>
            @endfor

        </main>
    </section>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
