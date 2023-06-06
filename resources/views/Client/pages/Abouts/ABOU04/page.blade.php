@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <div class="abou04-page" id="abou04-page">

        <section class="abou04-page__banner w-100"
            style="background-image: url({{ asset('storage/uploads/tmp/bg-banner-inner.jpg') }})">

            <header
                class="abou04-page__banner__content container d-flex flex-column align-items-center justify-content-center">

                <h1 class="abou04-page__banner__title">Título do banner</h1>
                <div class="abou04-page__banner__subtitle">Subtítulo</div>
                <hr class="abou04-page__banner__line">

            </header>
        </section>

        <section class="abou04-page__cont w-100">

            <main class="abou04-page__cont__main container">

                <img src="{{ asset('storage/uploads/tmp/image-pmg.png') }}" alt="" class="abou04-page__cont__image">

                <div class="abou04-page__cont__content d-flex flex-column align-items-start">
                    <h2 class="abou04-page__cont__title">Título</h2>
                    <h3 class="abou04-page__cont__subtitle">Subtítulo</h3>
                    <hr class="abou04-page__cont__line">

                    <div class="abou04-page__cont__desc">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                            eget
                            purus mattis posuere. Donec tincidunt dignissim faucibus.</p>
                    </div>

                </div>

            </main>

        </section>

        <section class="abou04-page__gallery w-100 d-flex flex-column align-items-center">
            <header class="abou04-page__gallery__header container d-flex flex-column align-items-center">
                <h2 class="abou04-page__gallery__header__title text-center">Título</h2>
                <h2 class="abou04-page__gallery__header__subtitle text-center">Subtítulo</h2>
                <hr class="abou04-page__gallery__header__line" />
            </header>

            <main class="abou04-page__gallery__main d-flex flex-column align-items-center">
                <div class="abou04-page__gallery__list"></div>

                <a href="#" class="abou04-page__gallery__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                        class="abou04-page__gallery__cta__icon">
                    CTA
                </a>
            </main>
        </section>

    </div>

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
