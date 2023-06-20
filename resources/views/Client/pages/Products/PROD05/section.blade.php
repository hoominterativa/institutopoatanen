<section id="PROD05" class="prod05">
    <div class="container">
        <header class="prod05__header d-flex flex-column align-items-center">
            <h2 class="prod05__title">Título</h2>
            <h3 class="prod05__subtitle">Subtítulo</h3>
            <hr class="prod05__line">

            <p class="prod05__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus
                gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                eget purus mattis posuere. Donec tincidunt dignissim faucibus.</p>

            <div class="prod05-categories">

                <ul class="prod05-categories__list w-100">
                    @for ($i = 0; $i < 3; $i++)
                        <li class="prod05-categories__list__item">
                            <a href="">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="prod05-categories__list__item__icon">
                                Categoria
                            </a>
                        </li>
                    @endfor
                </ul>

                <div class="prod05-categories__dropdown-mobile">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header prod05-categories__dropdown-mobile__item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="prod05-categories__dropdown-mobile__item__icon">
                                    Categoria
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        @for ($i = 0; $i < 3; $i++)
                                            <li class="prod05-categories__dropdown-mobile__item">
                                                <a href="">
                                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                        alt=""
                                                        class="prod05-categories__dropdown-mobile__item__icon">
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

        <main class="prod05__main w-100 d-flex flex-column align-items-start">

            <div class="prod05__carousel owl-carousel">

                @for ($i = 0; $i < 6; $i++)
                    <article class="prod05__carousel__item prod05-box">

                        <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" alt=""
                            class="prod05-box__image">

                        <div class="prod05-box__content w-100 d-flex flex-column align-items-center">
                            <div class="prod05-box__top w-100 d-flex flex-column align-items-center">

                                <h3 class="prod05-box__top__title">Título</h3>
                                <h4 class="prod05-box__top__subtitle">Subtitulo</h4>

                            </div>

                            <hr class="prod05-box__line">

                            <p class="prod05-box__desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>

                            <a href="#" class="prod05-box__cta">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="prod05-box__cta__icon">
                                CTA
                            </a>
                        </div>

                    </article>
                @endfor

            </div>

            <a href="#" class="prod05__cta">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="prod05__cta__icon">
                CTA
            </a>

        </main>
    </div>
</section>
