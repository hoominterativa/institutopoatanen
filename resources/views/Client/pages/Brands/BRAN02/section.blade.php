<section class="bran02">
    <header class="bran02__header">
        <h2 class="bran02__header__title">Title</h2>
        <h3 class="bran02__header__subtitle">SubTitle</h3>
        <div class="bran02__header__description">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam corporis optio dolore accusamus ex harum.
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
        @for ($i = 0; $i < 3; $i++)
        <div class="bran02__products__cards">
           
                <img class="bran02__products__cards"
                src="{{ asset('storage/' ) }}"
                alt="Imagem referente a seção {{-- TITLE --}}">
            
        </div>
        @endfor
    </div>
</section>

