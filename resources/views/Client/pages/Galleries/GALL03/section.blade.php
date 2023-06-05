<section id="GALL03" class="gall03 container-fluid">
    <div class="container">

        <header class="gall03__header w-100 d-flex flex-column align-items-center">
            <h2 class="gall03__header__title text-center">Título</h2>
            <h3 class="gall03__header__subtitle text-center">Subtítulo</h3>
            <hr class="gall03__header__line">
        </header>

        <main class="gall03__carousel owl-carousel">

            @for ($i = 0; $i < 5; $i++)
                <div class="gall03__carousel__item">
                    <a href="#lightbox-gall03" data-fancybox class="link-full"></a>

                    <img src="{{ asset('storage/uploads/tmp/bg-slide-dark.png') }}" alt=""
                        class="gall03__carousel__item__image">

                    <h4 class="gall03__carousel__item__title">
                        Título {{ $i }}
                    </h4>
                </div>
            @endfor

            @include('Client.pages.Galleries.GALL03.show')

        </main>

    </div>
</section>
