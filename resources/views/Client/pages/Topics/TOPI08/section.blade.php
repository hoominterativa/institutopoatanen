<section id="TOPI08" class="topi08 container-fluid" style="{{ asset('storage/uploads/tmp/bg-section-gray.jpg') }}">
    <div class="container">

        <header class="topi08__header w-100">
            <h2 class="topi08__header__title">Título</h2>
            <h3 class="topi08__header__subtitle">Subtítulo</h3>
            <hr class="topi08__header__line">
        </header>

        <main class="topi08__main topi08__carousel">

            @for ($i = 0; $i < 5; $i++)
                <article class="topi08__item d-flex align-items-end flex-column">
                    <img src="{{ asset('storage/uploads/tmp/bg-slid-mobile.jpg') }}" alt="imagem de fundo do tópico"
                        class="topi08__item__bg">

                    <div class="topi08__item__content d-flex flex-column w-100">
                        <h3 class="topi08__item__title">Título</h3>
                        <div class="topi08__item__desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus</p>

                            <a href="#" class="topi08__item__cta">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícone do botão"
                                    class="topi08__item__cta__icon">
                                CTA
                            </a>
                        </div>
                    </div>

                </article>
            @endfor

        </main>

    </div>
</section>
