<section class="feed05 w-100" id="FEED05">
    <div class="container">

        <header class="feed05__header d-flex flex-column align-items-center">
            <h1 class="feed05__title">Título</h1>
            <hr class="feed05__line">
        </header>

        <main class="feed05__main w-100 d-flex flex-column align-items-center">

            <div class="feed05__carousel owl-carousel">

                @for ($i = 0; $i < 4; $i++)
                    <article class="feed05__item">

                        <header class="feed05__item__header d-flex flex-column align-items-center w-100">

                            <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" alt=""
                                class="feed05__item__avatar">

                            <h3 class="feed05__item__title">Nome do usuário {{ $i }}</h3>

                            <ul class="feed05__item__stars d-flex justify-content-center align-items-center">
                                <li class="feed05__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                </li>
                                <li class="feed05__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                </li>
                                <li class="feed05__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                </li>
                                <li class="feed05__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                </li>
                                <li class="feed05__item__stars__item">
                                    <img src="{{ asset('storage/uploads/tmp/star-outline.png') }}"
                                        alt="Contorno de estrela">
                                </li>
                            </ul>
                        </header>

                        <main class="feed05__item__text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                                sollicitudin vel non libero. Vivamus commodo porta velit</p>
                        </main>
                    </article>
                @endfor

            </div>

        </main>

    </div>
</section>
