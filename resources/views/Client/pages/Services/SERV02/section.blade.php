<section id="SERV02" class="serv02">
    <header class="serv02__header">
        <h2 class="serv02__title">Título</h2>

        <h3 class="serv02__subtitle">Subtítulo</h3>

        <hr class="serv02__line">

        <div class="serv02__paragraph">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin
                vel
                non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis
                posuere.
                Donec tincidunt dignissim faucibus.</p>
        </div>
    </header>

    <main class="serv02__main">
        <div class="serv02__carousel owl-carousel">

            @for ($i = 0; $i < 8; $i++)
                <div class="serv02__item">

                    <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" alt="Imagem de fundo [ttl do topic]"
                        class="serv02__item__bg">

                    <div class="serv02__item__information">

                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                            alt="Imagem de fundo [ttl do topic]" class="serv02__item__information__icon">

                        <h4 class="serv02__item__information__title">Título do tópico</h4>

                        <p class="serv02__item__information__description">Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. </p>

                    </div>

                    <a href="#" class="serv02__item__cta">

                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                            alt="Imagem de fundo [ttl do topic]" class="serv02__item__cta__icon">

                        CTA

                    </a>

                </div>
            @endfor

        </div>
    </main>
</section>
