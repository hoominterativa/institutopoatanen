<section class="unit05">
    <menu class="unit05__categories">
        <div class="unit05__categories__swiper-wrapper swiper-wrapper">
            @for ($i = 0; $i < 5; $i++)
                <a href="{{ route('unit05.page') }}" class="unit05__categories__item swiper-slide">Categoria
                    {{ $i }}</a>
            @endfor
        </div>
    </menu>

    <div class="unit05__content">
        <div class="unit05__content__gallery">
            <div class="unit05__content__gallery__swiper-wrapper swiper-wrapper">
                @for ($i = 0; $i < 4; $i++)
                    <img src="{{ asset('storage/uploads/tmp/bloco.png') }}" loading='lazy'
                        alt="Banner da seção [BACKEND add título da seção aqui]"
                        class="unit05__content__gallery__item swiper-slide">
                @endfor
            </div>

            <div class="unit05__content__gallery__nav__swiper-button-prev swiper-button-prev"></div>
            <div class="unit05__content__gallery__nav__swiper-button-next swiper-button-next"></div>
            {{-- <div class="unit05__content__gallery__nav">
            </div> --}}
        </div>

        <div class="unit05__content__information">
            <h3 class="unit05__content__information__subtitle">Subtítle</h3>
            <h2 class="unit05__content__information__title">Títle</h2>
            <div class="unit05__content__information__paragraph">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                    sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget
                    purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ip Lorem ipsum dolor sit amet,
                    consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus
                    commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec
                    tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel
                    tortorLorem ipsum dolor </p>
            </div>

            <div class="unit05__content__information__subcategories">
                <div class="unit05__content__information__subcategories__swiper-wrapper swiper-wrapper">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="unit05__content__information__subcategories__item swiper-slide">
                            <img src="{{ asset('storage/uploads/tmp/bloco.png') }}"
                                alt="Ícone de [BACKEND ADD TITULO DA SUBCATEGORIA AQUI]" loading='lazy'
                                class="unit05__content__information__subcategories__item__icon">
                            <h4 class="unit05__content__information__subcategories__item__title">Subcategoria</h4>
                            <p class="unit05__content__information__subcategories__item__paragraph">Lorem ipsum dolor
                                sit amet, consectetur adipiscing elit.</p>
                        </div>
                    @endfor
                </div>

                <div class="unit05__content__information__subcategories__nav">
                    <div
                        class="unit05__content__information__subcategories__nav__swiper-button-prev swiper-button-prev">
                    </div>
                    <div
                        class="unit05__content__information__subcategories__nav__swiper-button-next swiper-button-next">
                    </div>
                </div>
            </div>

            <a href="{{ route('unit05.page') }}" class="unit05__content__information__cta">CTA</a>
        </div>
    </div>

    <img src="{{ asset('storage/uploads/tmp/bloco.png') }}" loading='lazy'
        alt="Banner da seção [BACKEND add título da seção aqui]" class="unit05__section-banner">
</section>
