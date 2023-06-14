<section class="cont11" id="CONT11">
    <div class="cont11__carousel owl-carousel">

        @for ($i = 0; $i < 3; $i++)
            <div class="cont11__corousel__item">
                <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" alt="">
            </div>
        @endfor

    </div>

    <div class="cont11__right d-flex flex-column align-items-start justify-content-center">

        <h2 class="cont11__title">Título</h2>
        <h3 class="cont11__subtitle">Subtítulo</h3>
        <hr class="cont11__line">

        <div class="cont11__text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin
                vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis
                posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi
                pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin
                vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis
                posuere. Donec tincidunt dignissim faucibus.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin
                vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis
                posuere. Donec tincidunt dignissim faucibus.
            </p>
        </div>

        <a href="#" class="cont11__cta">
            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="cont11__cta__icon">
            CTA
        </a>

    </div>
</section>
