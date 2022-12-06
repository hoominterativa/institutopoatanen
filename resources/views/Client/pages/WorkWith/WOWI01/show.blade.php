@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
    <main id="root">
        <div id="WOWI01" class="wowi01-show">
            <section class="container-fluid px-0">
                <header class="wowi01-show__header" style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}})">
                    <div class="container d-flex flex-column justify-content-center align-items-center">
                        <h3 class="wowi01-show__header__container">
                            <span class="wowi01-show__header__title">Trabalhe Conosco</span>
                        </h3>
                    </div>
                </header>
            </section>

            <section class="wowi01-show__content__wrapper">
                <div class="container">
                    <div class="wowi01-show__content">
                        <div class="">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="36" alt="Titulo Subtitulo" class="wowi01-show__content__icon">
                            <h2 class="wowi01-show__content__container">
                                <span class="wowi01-show__content__subtitle">Titulo</span>
                                <span class="wowi01-show__content__title">Subtitulo</span>
                            </h2>
                        </div>
                        <hr class="wowi01-show__content__line">
                        <div class="wowi01-show__content__paragraph ck-content">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit,
                                vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec
                                tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectet
                            </p>
                        </div>
                    </div>
                    {{-- END .wowi01-show__content --}}
                </div>
                {{-- END .container --}}
            </section>
            {{-- END .wowi01-show__content__wrapper --}}

            <section class="wowi01-show__container-box__wrapper">
                <div class="container">
                    <header class="wowi01-show__container-box__header">
                        <h3 class="wowi01-show__container-box__header__container">
                            <span class="wowi01-show__container-box__header__title">Categorias de Trabalhe Conosco</span>
                            <span class="wowi01-show__container-box__header__subtitle">Subtitulo</span>
                        </h3>
                        <hr class="wowi01-show__container-box__header__line">
                        <p class="wowi01-show__container-box__header__paragraph">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                            Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                        </p>
                    </header>
                    <div class="wowi01-show__container-box wowi01-show__container-box__carousel row">
                        <article class="wowi01-show__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                            <div class="content transition">
                                <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}">
                                    <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="wowi01-show__container-box__image d-block" alt="Titulo Topico">
                                    <div class="wowi01-show__container-box__info">
                                        <figure class="wowi01-show__container-box__icon">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="60px" alt="Titulo Topico">
                                        </figure>
                                        <div class="wowi01-show__container-box__description">
                                            <h3 class="wowi01-show__container-box__title">Titulo Topico</h3>
                                            <p class="wowi01-show__container-box__paragraph mx-auto">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .wowi01-show__container-box__item --}}
                        <article class="wowi01-show__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                            <div class="content transition">
                                <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}">
                                    <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="wowi01-show__container-box__image d-block" alt="Titulo Topico">
                                    <div class="wowi01-show__container-box__info">
                                        <figure class="wowi01-show__container-box__icon">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="60px" alt="Titulo Topico">
                                        </figure>
                                        <div class="wowi01-show__container-box__description">
                                            <h3 class="wowi01-show__container-box__title">Titulo Topico</h3>
                                            <p class="wowi01-show__container-box__paragraph mx-auto">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .wowi01-show__container-box__item --}}
                        <article class="wowi01-show__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                            <div class="content transition">
                                <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}">
                                    <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="wowi01-show__container-box__image d-block" alt="Titulo Topico">
                                    <div class="wowi01-show__container-box__info">
                                        <figure class="wowi01-show__container-box__icon">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="60px" alt="Titulo Topico">
                                        </figure>
                                        <div class="wowi01-show__container-box__description">
                                            <h3 class="wowi01-show__container-box__title">Titulo Topico</h3>
                                            <p class="wowi01-show__container-box__paragraph mx-auto">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .wowi01-show__container-box__item --}}
                        <article class="wowi01-show__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                            <div class="content transition">
                                <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}">
                                    <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="wowi01-show__container-box__image d-block" alt="Titulo Topico">
                                    <div class="wowi01-show__container-box__info">
                                        <figure class="wowi01-show__container-box__icon">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="60px" alt="Titulo Topico">
                                        </figure>
                                        <div class="wowi01-show__container-box__description">
                                            <h3 class="wowi01-show__container-box__title">Titulo Topico</h3>
                                            <p class="wowi01-show__container-box__paragraph mx-auto">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .wowi01-show__container-box__item --}}
                    </div>
                    {{-- END .wowi01-show__container-box --}}
                </div>
            </section>
            {{-- END .wowi01-show__container-box__wrapper --}}

            <section class="wowi01-show__content-section container-fluid">
                <div class="container wowi01-show__content-section__container">
                    <header class="wowi01-show__content-section__header">
                        <h3 class="wowi01-show__content-section__header__container">
                            <span class="wowi01-show__content-section__header__title">Título</span>
                            <span class="wowi01-show__content-section__header__subtitle">Subtitulo</span>
                        </h3>
                        <hr class="wowi01-show__content-section__header__line">
                        <p class="wowi01-show__content-section__header__paragraph">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                            Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                        </p>
                    </header>
                    {{-- END .wowi01-show__content-section__header --}}

                    <div class="wowi01-show__content-section__info row">
                        <div class="wowi01-show__content-section__info__image col-12 col-lg-6">
                            <img src="{{asset('storage/uploads/tmp/png-slide.png')}}" width="429" class="wowi01-show__content-section__info__image__item" alt="Título Subtitulo">
                        </div>
                        <div class="wowi01-show__content-section__info__description col-12 col-lg-6">
                            <h3 class="wowi01-show__content-section__info__container">
                                <span class="wowi01-show__content-section__info__title">Título</span>
                                <span class="wowi01-show__content-section__info__subtitle">Subtitulo</span>
                            </h3>
                            <hr class="wowi01-show__content-section__info__line">
                            <p class="wowi01-show__content-section__info__paragraph">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                            </p>

                            <a href="#" class="wowi01-show__content-section__info__cta float-end d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 wowi01-show__content-section__info__cta__icon">
                                CTA
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {{-- END #WOWI01 --}}

        <section id="WOWI01" class="wowi01 container-fluid">''
            <div class="container">
                <header class="wowi01__header">
                    <h3 class="wowi01__header__container">
                        <span class="wowi01__header__title">Categorias de Trabalhe Conosco</span>
                        <span class="wowi01__header__subtitle">Subtitulo</span>
                    </h3>
                    <hr class="wowi01__header__line">
                    <p class="wowi01__header__paragraph">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                        Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                    </p>
                </header>
                <div class="wowi01__container-box carousel-wowi01 row">
                    <article class="wowi01__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="Titulo Topico">
                            <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}">
                                <div class="wowi01__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="wowi01__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="60px" alt="Titulo Topico">
                                    </figure>
                                    <div class="wowi01__container-box__description">
                                        <h3 class="wowi01__container-box__title">Titulo Topico</h3>
                                        <p class="wowi01__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}" class="wowi01__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 wowi01__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .wowi01__container-box__item --}}
                    <article class="wowi01__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="Titulo Topico">
                            <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}">
                                <div class="wowi01__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="wowi01__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="60px" alt="Titulo Topico">
                                    </figure>
                                    <div class="wowi01__container-box__description">
                                        <h3 class="wowi01__container-box__title">Titulo Topico</h3>
                                        <p class="wowi01__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}" class="wowi01__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 wowi01__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .wowi01__container-box__item --}}
                    <article class="wowi01__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="Titulo Topico">
                            <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}">
                                <div class="wowi01__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="wowi01__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="60px" alt="Titulo Topico">
                                    </figure>
                                    <div class="wowi01__container-box__description">
                                        <h3 class="wowi01__container-box__title">Titulo Topico</h3>
                                        <p class="wowi01__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}" class="wowi01__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 wowi01__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .wowi01__container-box__item --}}
                    <article class="wowi01__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="Titulo Topico">
                            <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}">
                                <div class="wowi01__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="wowi01__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="60px" alt="Titulo Topico">
                                    </figure>
                                    <div class="wowi01__container-box__description">
                                        <h3 class="wowi01__container-box__title">Titulo Topico</h3>
                                        <p class="wowi01__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{route('wowi01.show', ['WOWI01WorkWith' => 's'])}}" class="wowi01__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 wowi01__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .wowi01__container-box__item --}}
                </div>
                {{-- END .wowi01__container-box --}}
            </div>
        </section>
        {{-- END #WOWI01 --}}
    </main>
    {{-- END #root --}}

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
