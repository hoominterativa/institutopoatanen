<section class="port06" id="PORT06">
    <header class="port06__header">
        <h3 class="port06__header__subtitle">Subtítulo</h3>
        <h2 class="port06__header__title">Título</h2>
        <div class="port06__header__paragraph">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin
                vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis
                posuere. Donec tincidunt dignissim faucibus. Vestibulum </p>
        </div>
    </header>

    <div class="port06__main">
        <div class="port06__main__carousel">
            <div class="port06__main__carousel__swiper-wrapper swiper-wrapper">
                @for ($i = 0; $i < 6; $i++)
                    <article class="port06__main__carousel__item swiper-slide">
                        <img src="{{ asset('images/imageServ.png') }}" alt="Imagem do [título do item]"
                            class="port06__main__carousel__item__image">
                        <span class="port06__main__carousel__item__category">Categoria</span>
                        <h4 class="port06__main__carousel__item__title">Título do item</h4>
                        <p class="port06__main__carousel__item__paragraph">Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. </p>
                    </article>
                @endfor
            </div>
        </div>

        <a href="" class="port06__main__cta">CTA</a>
    </div>

</section>
