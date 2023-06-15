<section id="SERV05" class="serv05">
    <div class="container">
        <header class="serv05__header d-flex flex-column align-items-center">
            <h2 class="serv05__title">Título</h2>
            <h3 class="serv05__subtitle">Subtítulo</h3>
            <hr class="serv05__line">

            <p class="serv05__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus
                gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                eget purus mattis posuere. Donec tincidunt dignissim faucibus.</p>

            <div class="serv05-categories">

                <ul class="serv05-categories__list w-100">
                    @for ($i = 0; $i < 3; $i++)
                        <li class="serv05-categories__list__item">
                            <a href="">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="serv05-categories__list__item__icon">
                                Categoria
                            </a>
                        </li>
                    @endfor
                </ul>

                <div class="serv05-categories__dropdown-mobile">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header serv05-categories__dropdown-mobile__item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="serv05-categories__dropdown-mobile__item__icon">
                                    Categoria
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        @for ($i = 0; $i < 3; $i++)
                                            <li class="serv05-categories__dropdown-mobile__item">
                                                <a href="">
                                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                        alt=""
                                                        class="serv05-categories__dropdown-mobile__item__icon">
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

        </header>

        <main class="serv05__main w-100 d-flex flex-column align-items-stretch">

            <div class="serv05__carousel owl-carousel">

                @for ($i = 0; $i < 6; $i++)
                    <article class="serv05__carousel__item serv05-box"
                        style="background-image: url({{ asset('storage/uploads/tmp/bg-boxitem.png') }})">

                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                            class="serv05-box__icon">

                        <div class="serv05-box__content w-100 d-flex flex-column align-items-stretch">
                            <div class="serv05-box__top w-100 d-flex align-items-center justify-content-between">
                                <div
                                    class="serv05-box__top__left d-flex flex-column align-items-start justify-content-start ">

                                    <h3 class="serv05-box__top__title">Título</h3>
                                    <h4 class="serv05-box__top__subtitle">Subtitulo</h4>

                                </div>

                                <div
                                    class="serv05-box__top__right d-flex flex-column align-items-end justify-content-start ">
                                    <h4 class="serv05-box__top__subtitle">Subtitulo</h4>
                                    <h3 class="serv05-box__top__title">00,00</h3>
                                </div>
                            </div>

                            <hr class="serv05-box__line">

                            <p class="serv05-box__desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. olor sit amet, consectetur
                                adipiscing elit.
                            </p>

                            <a href="#" class="serv05-box__cta">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="serv05-box__cta__icon">
                                CTA
                            </a>
                        </div>

                    </article>
                @endfor

            </div>

            <a href="#" class="serv05__cta">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv05__cta__icon">
                CTA
            </a>

        </main>
    </div>
</section>
