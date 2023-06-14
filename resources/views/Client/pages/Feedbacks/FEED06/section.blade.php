<section class="feed06 w-100" id="FEED06"
    style="background-image: url({{ asset('storage/uploads/tmp/bg-section-dark-gray.jpg') }})">
    <div class="container">

        <header class="feed06__header d-flex flex-column align-items-center">
            <h1 class="feed06__title">Título</h1>
            <hr class="feed06__line">
        </header>

        <main class="feed06__main w-100 d-flex flex-column align-items-stretch">

            <div class="feed06__carousel owl-carousel">

                @for ($i = 0; $i < 4; $i++)
                    <article class="feed06__item">

                        <header class="feed06__item__header d-flex flex-column align-items-start w-100">
                            <h3 class="feed06__item__title">Nome do usuário</h3>

                            <ul class="feed06__item__stars d-flex justify-content-start align-items-center">
                                <li class="feed06__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                </li>
                                <li class="feed06__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                </li>
                                <li class="feed06__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                </li>
                                <li class="feed06__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                </li>
                                <li class="feed06__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-outline.png') }}"
                                        alt="Contorno de estrela">
                                </li>
                            </ul>
                        </header>

                        <main class="feed06__item__text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                                sollicitudin vel non libero. Vivamus commodo porta velit</p>
                        </main>
                    </article>
                @endfor

            </div>

            <a href="#" class="feed06__cta">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="feed06__cta__icon">
                CTA
            </a>

        </main>

    </div>
</section>
