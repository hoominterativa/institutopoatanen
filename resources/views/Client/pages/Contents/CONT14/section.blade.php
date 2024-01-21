<section id="cont13" class="cont13">
    <div class="container container--cont13">
        <div class="row row---cont13  mx-auto">
            <div class="cont13__left col-auto px-0">
                <h4 class="cont13__left__titleDest">Título Seção</h4>   
                <nav class="cont13__left__navigation">
                    <ul class="cont13__left__navigation__list">
                        <li class="cont13__left__navigation__list__item"><button class="cont13__left__navigation__list__item__link">Título Categoria</button></li>
                        <li class="cont13__left__navigation__list__item"><button class="cont13__left__navigation__list__item__link">Título Categoria</button></li>
                        <li class="cont13__left__navigation__list__item"><button class="cont13__left__navigation__list__item__link">Título Categoria</button></li>
                        <li class="cont13__left__navigation__list__item"><button class="cont13__left__navigation__list__item__link">Título Categoria</button></li>
                        <li class="cont13__left__navigation__list__item"><button class="cont13__left__navigation__list__item__link">Título Categoria</button></li>
                    </ul>
                </nav> 
            </div>
            <div class="cont13__right col">
                <div class="cont13__right__box">
                    <h4 class="cont13__right__box__title">Título Conteúdo</h4>
                    <h5 class="cont13__right__box__subtitle">Subtítulo Conteúdo</h5>
                    <div class="carousel-gallery-cont13 owl-carousel">
                        @for($i=0; $i <= 2; $i++)
                        <div class="cont13__right__box__image">
                            <img src="{{asset('storage/uploads/tmp/thumbnail-b.png')}}" class="h-100 w-100" alt="Imagem">
                        </div>
                        @endfor
                    </div>
                    <div class="cont13__right__box__paragraph">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus 
                            gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. 
                        </p>
                    </div>
                </div>
                <!-- Fim-cont13__right__box -->
            </div>
        </div>
    </div>
</section>