@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="serv05-show__header w-100">

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

                <ul class="serv05-show__nav w-100">
                    @for ($i = 1; $i < 3; $i++)
                        <li class="serv05-show__nav__item">
                            <a href="#sec{{ $i }}">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="serv05-show__nav__item__icon">
                                Seção
                            </a>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>

    </section>

    @for ($i = 1; $i < 3; $i++)
        <article id="sec{{ $i }}" class="serv05-show__item w-100">
            <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" alt="" class="serv05-show__item__image">

            <div class="serv05-show__item__right">
                <h4 class="serv05-show__item__subtitle">Subtítulo</h4>
                <h3 class="serv05-show__item__title">Título</h3>
                <hr class="serv05-show__item__line">

                <div class="serv05-show__item__text">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                        eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                        Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                        Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel
                        tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec </p>
                </div>

            </div>
        </article>
    @endfor

    <section class="serv05-show__topics">
        <div class="container d-flex flex-column align-items-streach">

            <header class="serv05-show__topics__header w-100 d-flex flex-column align-items-center">
                <h4 class="serv05-show__topics__subtitle">Subtítulo</h4>
                <h3 class="serv05-show__topics__title">Título</h3>
                <hr class="serv05-show__topics__line">
            </header>

            <main class="serv05-show__topics__main w-100 d-flex flex-column align-items-stretch">

                <div class="serv05-show__topics__carousel w-100 owl-carousel">

                    @for ($i = 0; $i < 5; $i++)
                        <article class="serv05-show__topics__item"
                            style="background-image: url({{ asset('storage/uploads/tmp/bg-boxitem-light.png') }})">
                            <header
                                class="serv05-show__topics__item__header w-100 d-flex flex-row align-items-center justify-content-start">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="serv05-show__topics__item__icon">

                                <div
                                    class="serv05-show__topics__item__header__right d-flex flex-column align-items-start justify-content-center">
                                    <h3 class="serv05-show__topics__item__title">Título Tópico</h3>
                                    <h4 class="serv05-show__topics__item__subtitle">Subtítulo</h4>
                                </div>
                            </header>

                            <hr class="serv05-show__topics__item__line">

                            <div class="serv05-show__topics__item__desc">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit.</p>
                            </div>
                        </article>
                    @endfor

                </div>

                <a href="#" class="serv05-show__topics__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                        class="serv05-show__topics__cta__icon">
                    CTA
                </a>
            </main>

        </div>
    </section>

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
