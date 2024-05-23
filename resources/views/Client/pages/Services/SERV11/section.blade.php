<section id="serv11" class="serv11">
    <header class="serv11__header">
        <h2 class="serv11__header__title">Titulo</h2>
        <h3 class="serv11__header__subtitle">Subtitulo</h3>
        <div class="serv11__header__paragraph">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin
                vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis
                posuere. Donec tincidunt dignissim faucibus.
            </p>
        </div>
    </header>

    <div class="serv11__services">
        <div class="serv11__services__carousel">
            <div class="serv11__services__carousel__swiper-wrapper swiper-wrapper">
                @for ($i = 0; $i < 15; $i++)
                    <article class="serv11__services__item swiper-slide">
                        <img src="{{asset('images/icon.svg')}}" loading="lazy" class="serv11__services__item__icon" alt="Ícone do item ">
                        <h3 class="serv11__services__item__title">Titulo Topico</h3>
                        <p class="serv11__services__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                    </article>
                @endfor

                @include('Client.pages.Services.SERV11.show')
            </div>

            <div class="serv11__services__carousel__swiper-pagination"></div>
        </div>

        <a href="{{route('serv11.page')}}" title="página de serviços" class="serv11__services__cta">CTA</a>
    </div>

</section>
