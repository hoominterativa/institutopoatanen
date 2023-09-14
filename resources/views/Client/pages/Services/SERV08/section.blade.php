<section id="SERV08" class="serv08">
    <div class="container">
        <header class="serv08__header d-flex flex-column align-items-center">
            <h2 class="serv08__title">Titulo</h2>
            <h3 class="serv08__subtitle">Subtitulo</h3>
            <hr class="serv08__line">
            <p class="serv08__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
            </p>
            <div class="serv08-categories">
                <ul class="serv08-categories__list w-100 serv08__categories owl-carousel">
                    @for ($i = 0; $i < 7; $i++) <li class="serv08-categories__list__item">
                        <a href="">
                            <img src="{{ asset('images/cta.png') }}" alt="Icone categoria" class="serv08-categories__list__item__icon">
                            categoria
                        </a>
                        </li>
                        @endfor
                </ul>
            </div>
        </header>
        <main class="serv08__main w-100 d-flex flex-column align-items-stretch">
            <div class="serv08__carousel owl-carousel">
                <article class="serv08__carousel__item serv08-box" style="background-image: url({{ asset('images/gray.png') }}); background-color: #ffffff;">
                    <div class="serv08-box__promotion">
                        <h4 class="serv08-box__promotion__titulo">Promoção</h4>
                    </div>
                    <div class="serv08-box__content w-100 d-flex flex-column align-items-stretch">
                        <div class="serv08-box__top w-100 d-flex align-items-center justify-content-between">
                            <div class="serv08-box__top__left d-flex flex-column align-items-start justify-content-start ">
                                <h3 class="serv08-box__top__title">Titulo Topico</h3>
                                <h4 class="serv08-box__top__subtitle">subtítulo</h4>
                                <hr class="serv08-box__line">
                            </div>
                            <div class="serv08-box__top__center d-flex flex-column align-items-start justify-content-start ">
                                <h3 class="serv08-box__top__center__title">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur veritatis qui error odi.</h3>
                                <ul class="serv08-box__top__center__list">
                                    @for ($i = 0; $i < 4; $i++) <li class="serv08-box__top__center__list__item"><span><img src="{{ asset('images/cta.png') }}" alt="Icone check"></span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo veritatis.</li>
                                        @endfor
                                </ul>
                            </div>

                        </div>
                        <div class="serv08-box__top__right d-flex flex-column align-items-end justify-content-start ">
                            <h4 class="serv08-box__top__subtitle">subtítulo</h4>
                            <h3 class="serv08-box__top__title"><span>R$</span> 00,00</h3>
                        </div>
                        <a href="" class="serv08-box__cta">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv08-box__cta__icon">
                            CTA
                        </a>
                    </div>
                </article>
            </div>
            <a href="" class="serv08__cta">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv08__cta__icon">
                CTA
            </a>
        </main>

    </div>
</section>