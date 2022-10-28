@extends('Client.Core.client')
@section('content')
    <main class="root">
        <section id="SERV01" class="serv01-page">
            <header class="serv01-page__header">
                <h3 class="serv01-page__header__container">
                    <span class="serv01-page__header__title">Título</span>
                </h3>
                <hr class="serv01-page__header__line">
                <p class="serv01-page__header__paragraph">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                </p>
            </header>
            {{-- END .serv01-page__header --}}
            <div class="container">

                <div class="serv01-page__container-box row">
                    <article class="serv01-page__container-box__item col-12 col-sm-4 col-lg-3">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            <a href="#">
                                <div class="serv01-page__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="serv01-page__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                    </figure>
                                    <div class="serv01-page__container-box__description">
                                        <h3 class="serv01-page__container-box__title">Título Serviço</h3>
                                        <p class="serv01-page__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="serv01-page__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01-page__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .box-service --}}
                    <article class="serv01-page__container-box__item col-12 col-sm-4 col-lg-3">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            <a href="#">
                                <div class="serv01-page__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="serv01-page__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                    </figure>
                                    <div class="serv01-page__container-box__description">
                                        <h3 class="serv01-page__container-box__title">Título Serviço</h3>
                                        <p class="serv01-page__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="serv01-page__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01-page__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .box-service --}}
                    <article class="serv01-page__container-box__item col-12 col-sm-4 col-lg-3">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            <a href="#">
                                <div class="serv01-page__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="serv01-page__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                    </figure>
                                    <div class="serv01-page__container-box__description">
                                        <h3 class="serv01-page__container-box__title">Título Serviço</h3>
                                        <p class="serv01-page__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="serv01-page__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01-page__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .box-service --}}
                    <article class="serv01-page__container-box__item col-12 col-sm-4 col-lg-3">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            <a href="{{route('serv01.show',['SERV01Services' => 1])}}">
                                <div class="serv01-page__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="serv01-page__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                    </figure>
                                    <div class="serv01-page__container-box__description">
                                        <h3 class="serv01-page__container-box__title">Título Serviço</h3>
                                        <p class="serv01-page__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{route('serv01.show',['SERV01Services' => 1])}}" class="serv01-page__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01-page__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .box-service --}}
                    <article class="serv01-page__container-box__item col-12 col-sm-4 col-lg-3">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            <a href="#">
                                <div class="serv01-page__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="serv01-page__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                    </figure>
                                    <div class="serv01-page__container-box__description">
                                        <h3 class="serv01-page__container-box__title">Título Serviço</h3>
                                        <p class="serv01-page__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="serv01-page__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01-page__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .box-service --}}
                    <article class="serv01-page__container-box__item col-12 col-sm-4 col-lg-3">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            <a href="#">
                                <div class="serv01-page__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="serv01-page__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                    </figure>
                                    <div class="serv01-page__container-box__description">
                                        <h3 class="serv01-page__container-box__title">Título Serviço</h3>
                                        <p class="serv01-page__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="serv01-page__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01-page__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .box-service --}}
                    <article class="serv01-page__container-box__item col-12 col-sm-4 col-lg-3">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            <a href="#">
                                <div class="serv01-page__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="serv01-page__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                    </figure>
                                    <div class="serv01-page__container-box__description">
                                        <h3 class="serv01-page__container-box__title">Título Serviço</h3>
                                        <p class="serv01-page__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="serv01-page__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01-page__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .box-service --}}
                    <article class="serv01-page__container-box__item col-12 col-sm-4 col-lg-3">
                        <div class="content transition">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            <a href="{{route('serv01.show',['SERV01Services' => 1])}}">
                                <div class="serv01-page__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="serv01-page__container-box__image">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                    </figure>
                                    <div class="serv01-page__container-box__description">
                                        <h3 class="serv01-page__container-box__title">Título Serviço</h3>
                                        <p class="serv01-page__container-box__paragraph mx-auto">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{route('serv01.show',['SERV01Services' => 1])}}" class="serv01-page__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01-page__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                    {{-- END .box-service --}}
                </div>
                {{-- END .serv01-page__container-box --}}
            </div>
            {{-- END .container --}}
        </section>
        {{-- END #SERV01 --}}
    </main>
    {{-- END #ROOT --}}

    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
