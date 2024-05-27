<section class="sche01" id="SCHE01">
    <header class="sche01__header">
        <h2 class="sche01__header__title">Título</h2>
        <h3 class="sche01__header__sutbtitle">Subtítulo</h3>
    </header>

    <div class="sche01__carousel">
        <div class="sche01__carousel__swiper-wrapper swiper-wrapper">

            @for ($i = 0; $i < 5; $i++)
                <article class="sche01__carousel__item swiper-slide">
                    <img loading='lazy' src="{{ asset('storage/uploads/tmp/bloco.png') }}"
                        alt="Imagem do evento: {{-- BACKEND ADD TÍTULO DO EVENTO AQUI --}}" class="sche01__carousel__item__image">

                    <div class="sche01__carousel__item__information">
                        <h4 class="sche01__carousel__item__information__title">Título Evento</h4>
                        <h5 class="sche01__carousel__item__information__subtitle">Subtítulo</h5>

                        <div class="sche01__carousel__item__information__paragraph">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>

                        <a href="#" class="sche01__carousel__item__information__cta"
                            title="{{-- BACKEND ADD TÍTULO DO EVENTO AQUI --}}">CTA</a>
                    </div>
                </article>
            @endfor

        </div>

        <div class="sche01__carousel__nav">
            <div class="sche01__carousel__nav__swiper-button-prev swiper-button-prev"></div>
            <div class="sche01__carousel__nav__swiper-button-next swiper-button-next"></div>
        </div>
    </div>

    <a href="#" class="sche01__cta" title='Ir para página interna de eventos'>CTA</a>
</section>
