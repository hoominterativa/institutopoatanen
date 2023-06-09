@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <div class="sche01-page">
        <section class="sche01-page__banner w-100"
            style="background-image: url({{ asset('storage/uploads/tmp/bg-banner-inner.jpg') }})">
            <header
                class="sche01-page__banner__content container d-flex flex-column align-items-center justify-content-center">
                <h1 class="sche01-page__banner__title text-center">Título do banner</h1>
                <h2 class="sche01-page__banner__subtitle text-center">Subtítulo</h2>
                <hr class="sche01-page__banner__line">
            </header>
        </section>

        <section class="sche01-page__cont">
            <div class="sche01-page__cont__body container">

                <main class="sche01-page__cont__main d-flex flex-column align-items-stretch">

                    <div class="sche01-page__cont__top d-flex flex-column align-items-start">
                        <h2 class="sche01-page__cont__title">Título do banner</h2>
                        <h3 class="sche01-page__cont__subtitle">Subtítulo</h3>
                        <hr class="sche01-page__cont__line">
                    </div>

                    <div class="sche01-page__cont__list w-100 d-flex flex-column">

                        @for ($i = 0; $i < 2; $i++)
                            <article class="sche01-page__cont__item d-flex flex-column">

                                <header class="sche01-page__cont__item__header w-100 d-flex flex-row">
                                    <div
                                        class="sche01-page__cont__item__date d-flex flex-column align-items-center justify-content-center">
                                        <span class="sche01-page__cont__item__day">Dia</span>
                                        <span class="sche01-page__cont__item__month">Mês</span>
                                        <span class="sche01-page__cont__item__year">Ano</span>
                                    </div>

                                    <div
                                        class="sche01-page__cont__item__right d-flex flex-column align-items-start justify-content-start">
                                        <h3 class="sche01-page__cont__item__title">Título</h3>

                                        <hr class="sche01-page__cont__item__line">

                                        <ul class="sche01-page__cont__item__header__topics">
                                            <li class="sche01-page__cont__item__header__topics__item">
                                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                    alt=""
                                                    class="sche01-page__cont__item__header__topics__item__icon">
                                                Horário
                                            </li>
                                            <li class="sche01-page__cont__item__header__topics__item">
                                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                    alt=""
                                                    class="sche01-page__cont__item__header__topics__item__icon">
                                                Descrição
                                            </li>
                                        </ul>
                                    </div>
                                </header>

                                <main class="sche01-page__cont__item__main d-flex flex-column">

                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="sche01-page__cont__item__img">

                                    <div class="sche01-page__cont__item__desc">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus
                                            gravida
                                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium
                                            sed.
                                            In
                                            et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem
                                            ipsum
                                            dolor
                                            sit amet, consecteturpretium sed. In et arcu eget purus mattis posuere. Donec
                                            tincidunt
                                            dignissim faucibus. Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>

                                    <a href="#" class="sche01-page__cont__item__cta">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                            class="sche01-page__cont__item__cta__icon">
                                        CTA
                                    </a>
                                </main>

                            </article>
                        @endfor

                    </div>

                </main>

                <aside class="sche01-page__cont__aside"></aside>

            </div>
        </section>
    </div>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
