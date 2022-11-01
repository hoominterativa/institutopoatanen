@extends('Client.Core.client')
@section('content')
    <main id="root">
        <section id="SERV01" class="serv01-show container-fluid">
            <header class="serv01-show__header" style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}})">
                <div class="container">
                    <h2 class="serv01-show__header__title">Título Banner</h2>
                    <nav class="serv01-show__header__links carousel-serv01-show__links d-flex align-items-center justify-content-center">
                        <a href="#" class="serv01-show__header__link-item serv01-show__header__link-item--active">Serviço 1</a>
                        <a href="#" class="serv01-show__header__link-item ">Serviço 2</a>
                        <a href="#" class="serv01-show__header__link-item ">Serviço 3</a>
                        <a href="#" class="serv01-show__header__link-item ">Serviço 4</a>
                        <a href="#" class="serv01-show__header__link-item ">Serviço 5</a>
                    </nav>
                </div>
            </header>
            {{-- END .serv01-show__header --}}

            <div class="container serv01-show__content">
                <div class="serv01-show__content__info">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="36px" class="serv01-show__content__icon" alt="Título Subtítulo">
                    <h1>
                        <span class="serv01-show__content__subtitle">Subtítulo</span>
                        <span class="serv01-show__content__title">Título</span>
                    </h1>
                    <a href="#" class="serv01-show__content__info__link">
                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="26px" class="serv01-show__content__link_icon" alt="">
                    </a>
                </div>
                <hr class="serv01-show__content__line">
                <div class="serv01-show__content__description">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                        Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                        Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed.
                        In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed.
                        In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectet
                    </p>
                </div>
            </div>
            {{-- END .serv01-show__content --}}

            <div class="serv01-show__topics">
                <div class="container">
                    <header class="serv01-show__topics__header">
                        <h3 class="serv01-show__topics__header__container">
                            <span class="serv01-show__topics__header__title">Título</span>
                            <span class="serv01-show__topics__header__subtitle">Subtítulo</span>
                        </h3>
                        <hr class="serv01-show__topics__header__line">
                        <p class="serv01-show__topics__header__paragraph">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                            Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                        </p>
                    </header>
                    <div class="serv01-show__topics__container-box carousel-serv01-show__topics row">
                        <article class="serv01-show__topics__container-box__item col-12 col-sm-4 col-lg-3">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box-white.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                <a href="#">
                                    <div class="serv01-show__topics__container-box__info d-flex flex-column justify-content-center align-items-center">
                                        <figure class="serv01-show__topics__container-box__image">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                        </figure>
                                        <div class="serv01-show__topics__container-box__description">
                                            <h3 class="serv01-show__topics__container-box__title">Título Serviço</h3>
                                            <p class="serv01-show__topics__container-box__paragraph mx-auto">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .box-service --}}
                        <article class="serv01-show__topics__container-box__item col-12 col-sm-4 col-lg-3">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box-white.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                <a href="#">
                                    <div class="serv01-show__topics__container-box__info d-flex flex-column justify-content-center align-items-center">
                                        <figure class="serv01-show__topics__container-box__image">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                        </figure>
                                        <div class="serv01-show__topics__container-box__description">
                                            <h3 class="serv01-show__topics__container-box__title">Título Serviço</h3>
                                            <p class="serv01-show__topics__container-box__paragraph mx-auto">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .box-service --}}
                        <article class="serv01-show__topics__container-box__item col-12 col-sm-4 col-lg-3">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box-white.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                <a href="#">
                                    <div class="serv01-show__topics__container-box__info d-flex flex-column justify-content-center align-items-center">
                                        <figure class="serv01-show__topics__container-box__image">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                        </figure>
                                        <div class="serv01-show__topics__container-box__description">
                                            <h3 class="serv01-show__topics__container-box__title">Título Serviço</h3>
                                            <p class="serv01-show__topics__container-box__paragraph mx-auto">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .box-service --}}
                        <article class="serv01-show__topics__container-box__item col-12 col-sm-4 col-lg-3">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box-white.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                <a href="#">
                                    <div class="serv01-show__topics__container-box__info d-flex flex-column justify-content-center align-items-center">
                                        <figure class="serv01-show__topics__container-box__image">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon" width="50px" alt="">
                                        </figure>
                                        <div class="serv01-show__topics__container-box__description">
                                            <h3 class="serv01-show__topics__container-box__title">Título Serviço</h3>
                                            <p class="serv01-show__topics__container-box__paragraph mx-auto">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .box-service --}}
                    </div>
                    {{-- END .serv01-show__topics__container-box --}}
                </div>
                {{-- END .container --}}
            </div>
            {{-- END .serv01-show__topics --}}

            <div class="serv01-show__portfolios">
                <div class="container">
                    <header class="serv01-show__portfolios__header">
                        <h3 class="serv01-show__portfolios__header__container">
                            <span class="serv01-show__portfolios__header__title">Busca de Projetos</span>
                            <span class="serv01-show__portfolios__header__subtitle">Subtítulo</span>
                        </h3>
                        <hr class="serv01-show__portfolios__header__line">
                        <p class="serv01-show__portfolios__header__paragraph">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                            Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                        </p>
                    </header>
                    <div class="serv01-show__portfolios__container-box carousel-serv01-show__portfolios row">
                        <article class="serv01-show__portfolios__container-box__item col">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                <a href="#">
                                    <div class="serv01-show__portfolios__container-box__info d-flex flex-column justify-content-end">
                                        <div class="serv01-show__portfolios__container-box__description">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-sm-8">
                                                    <h3 class="serv01-show__portfolios__container-box__title">Título Serviço</h3>
                                                    <p class="serv01-show__portfolios__container-box__paragraph mx-auto">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon mx-auto" width="36px" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .box-service --}}
                        <article class="serv01-show__portfolios__container-box__item col">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                <a href="#">
                                    <div class="serv01-show__portfolios__container-box__info d-flex flex-column justify-content-end">
                                        <div class="serv01-show__portfolios__container-box__description">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-sm-8">
                                                    <h3 class="serv01-show__portfolios__container-box__title">Título Serviço</h3>
                                                    <p class="serv01-show__portfolios__container-box__paragraph mx-auto">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon mx-auto" width="36px" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .box-service --}}
                        <article class="serv01-show__portfolios__container-box__item col">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                <a href="#">
                                    <div class="serv01-show__portfolios__container-box__info d-flex flex-column justify-content-end">
                                        <div class="serv01-show__portfolios__container-box__description">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-sm-8">
                                                    <h3 class="serv01-show__portfolios__container-box__title">Título Serviço</h3>
                                                    <p class="serv01-show__portfolios__container-box__paragraph mx-auto">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon mx-auto" width="36px" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .box-service --}}
                        <article class="serv01-show__portfolios__container-box__item col">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                <a href="#">
                                    <div class="serv01-show__portfolios__container-box__info d-flex flex-column justify-content-end">
                                        <div class="serv01-show__portfolios__container-box__description">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-sm-8">
                                                    <h3 class="serv01-show__portfolios__container-box__title">Título Serviço</h3>
                                                    <p class="serv01-show__portfolios__container-box__paragraph mx-auto">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon mx-auto" width="36px" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .box-service --}}
                        <article class="serv01-show__portfolios__container-box__item col">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                <a href="#">
                                    <div class="serv01-show__portfolios__container-box__info d-flex flex-column justify-content-end">
                                        <div class="serv01-show__portfolios__container-box__description">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-sm-8">
                                                    <h3 class="serv01-show__portfolios__container-box__title">Título Serviço</h3>
                                                    <p class="serv01-show__portfolios__container-box__paragraph mx-auto">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon mx-auto" width="36px" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                        {{-- END .box-service --}}
                    </div>
                    {{-- END .serv01-show__portfolios__container-box --}}
                </div>
                {{-- END .container --}}
            </div>
            {{-- END .serv01-show__portfolios --}}
        </section>
        {{-- END #SERV01 --}}
    </main>
    {{-- END #root --}}
@endsection
