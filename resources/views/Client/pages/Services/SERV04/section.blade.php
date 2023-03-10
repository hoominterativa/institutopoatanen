<section id="SERV04" class="serv04 container-fluid" style="background-image: url({{asset('storage/uploads/tmp/image-box-white.jpg')}})">
    <header class="serv04__header" >
        <h2 class="container container--serv04 d-block text-center">
            <span class="serv04__header__title d-block">Titulo</span>
            <span class="serv04__header__subtitle d-block">Subtitulo</span>
            <hr class="serv04__header__line mb-0">
        </h2>
        <div class="serv04__header__paragraph mx-auto text-center">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                eu purus gravida sollicitudin vel non libero. Vivamus commodo porta 
                velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
            </p>
        </div>
    </header>   
    <main class="serv04__content">
        <div class="container">
            <div class="row row--serv04 w-100 mx-auto">
                <div class="serv04__box col-sm-3">
                    <div class="serv04__box__content">
                        <div class="serv04__box__bg">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" alt="Logo" loading="lazy">
                        </div>
                        <div class="serv04__box__description">
                            <div class="serv04__box__image">
                                <img src="{{asset('storage/uploads/tmp/logo.svg')}}" alt="Logo" loading="lazy">
                            </div>
                            <h4 class="serv04__box__title">Titulo Topico</h4>
                            <div class="serv04__box__paragraph">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                                    eu purus gravida sollicitudin vel non libero. Vivamus commodo porta 
                                    velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                                </p>
                            </div>
                            <a rel="first" href="sobre" class="serv04__box__cta transition justify-content-center align-items-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="serv04__box__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                </div>
                {{-- END .serv04__box --}}
            </div>
            <a rel="first" href="sobre" class="serv04__ctaPrincipal transition justify-content-center align-items-center">
                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="serv04__ctaPrincipal__icon me-3 transition">
                CTA
            </a>
        </div>
    </main>
</section>  