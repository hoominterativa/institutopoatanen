<section class="bran02">
    <header class="bran02__header">
        <h2 class="bran02__header__title">Title</h2>
        <h3 class="bran02__header__subtitle">Subtitle</h3>
        <div class="bran02__header__description">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam corporis optio dolore accusamus ex
                harum.
                At, ab hic nisi ex quam quasi enim quisquam, eius, deleniti ducimus architecto? Quos, quisquam?
            </p>
        </div>
    </header>
    <aside class="bran02__categories">
        <menu class="bran02__categories__swiper-wrapper swiper-wrapper">
            <a href="#" class="bran02__categories__item swiper-slide active">Category</a>

            @for ($i = 0; $i < 20; $i++)
                <a href="#" class="bran02__categories__item swiper-slide">Category</a>
            @endfor
        </menu>

    </aside>
    <div class="bran02__products">
        <div class="bran02__products__swiper-wrapper swiper-wrapper">
            <img class="bran02__products__item swiper-slide" src="{{ asset('storage/uploads/tmp/thumbnail-b.png') }}"
                alt="Imagem referente a seção {{-- TITLE --}}">
            @for ($i = 0; $i < 6; $i++)
                <img class="bran02__products__item swiper-slide"
                    src="{{ asset('storage/uploads/tmp/thumbnail-b.png') }}"
                    alt="Imagem referente a seção {{-- TITLE --}}">
            @endfor
        </div>
    </div>
    <a href="http://" target="_blank" class="bran02__cta">CTA</a>
</section>
