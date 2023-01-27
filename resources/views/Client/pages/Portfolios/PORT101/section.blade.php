<section id="PORT101" class="port101 container-fluid px-0" style="background-image:url({{asset('storage/uploads/tmp/bg-section-gray.jpg')}});">
    <div class="container container--pd">
        <header class="port101__emcompass text-center">
            <h4 class="port101__emcompass__title">Título Tópico</h4>
            <h5 class="port101__emcompass__subtitle">Subtitulo</h5>
            <hr class="port101__emcompass__line"/>
        </header>
        <div class="port101__content carousel-port101 owl-carousel">
            <div class="port101__content__box">
                <a rel="next" data-fancybox data-src="#lightbox-port101-1" href="javascript:;" data-options='{"touch" : false, "dragToClose": false}'>
                    <div class="port101__content__box__image">
                        <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" alt="Título Tópico">
                    </div>
                    <div class="port101__content__box__description">
                        <h4 class="port101__content__box__description__title">Título Tópico</h4>
                        <div class="port101__content__box__description__paragraph">
                            <p>
                                Lorem ipsum dolor sit amet, consectur adipiscing elitLorem ipsum dolor sit ame
                            </p>
                        </div>
                        
                    </div>
                </a>
                @include('Client.pages.Portfolios.PORT101.show')
            </div>
           
        </div>
    </div>
</section>
