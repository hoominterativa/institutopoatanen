<section id="serv10" class="serv10">
    <div class="container container--edit px-0">
        <div class="serv10__header">
            <h2 class="serv10__header__title">Titulo</h2>
            <h3 class="serv10__header__subtitle">Subtitulo</h3>
            <hr class="serv10__header__line">
            <div class="serv10__header__paragraph">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida 
                    sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. 
                    In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                </p>
            </div>
        </div>
        {{-- END serv10__header --}}
        <div class="serv10__main carousel-serv10 owl-carousel">
            <div class="serv10__main__box">
                <div class="serv10__main__box__content">
                    <div class="serv10__main__box__bg">
                        <img src="{{asset('storage/uploads/tmp/bg-boxitem.png')}}" alt="Bg">
                    </div>
                    <div class="serv10__main__box__description">
                        <div class="serv10__main__box__description__icon">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="ícone">
                        </div>
                        <h4 class="serv10__main__box__description__title">Titulo Topico</h4>
                        <div class="serv10__main__box__description__paragraph">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div>
                        <a href="#" class="serv10__main__box__description__btn">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="ícone Button">
                            CTA
                        </a>
                    </div>
                </div>
            </div>
            {{-- END serv10__main__box --}}
        </div>
        {{-- END carousel-serv10 --}}
    </div>
</section>
{{-- END serv10 --}}