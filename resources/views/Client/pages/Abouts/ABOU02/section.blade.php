<section id="ABOU02" class="abou02 container-fluid" style="background-image: url({{asset('storage/uploads/tmp/bg-section-gray.jpg')}})">
    <div class="row abou02__container ">
        <div class="abou02__boxLeft col-md-4 d-flex row align-items-start m-0">
            <div class="abou02__boxLeft__description p-0">
                <h4 class="abou02__boxLeft__subtitle text-center">subtitulo</h4>
                <h5 class="abou02__boxLeft__title mb-0">Titulo</h5>
                <hr class="abou02__boxLeft__line">
                <div class="abou02__boxLeft__paragraph">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                        eu purus gravida sollicitudin vel non libero. Vivamus commodo porta 
                        velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                    </p>
                </div>
                <a href="sobre" class="abou02__boxLeft__cta transition justify-content-center align-items-center">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="abou02__boxLeft__cta__icon me-3 transition">
                    CTA
                </a>
            </div>
        </div>
        <div class="abou02__boxRight col-md-8">
            <div class="carousel_abou02 owl-carousel">
                    <article class="abou02__boxRight__item">
                        <a href="sobre">
                        <div class="abou02__boxRight__content transition w-100 h-100">
                            <div class="abou02__boxRight__header position-relative w-100 h-100">
                                <div class="abou02__boxRight__image w-100 h-100">
                                    <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="">
                                </div>
                                <div class="abou02__boxRight__description text-center flex-column w-100 h-100 position-absolute d-flex justify-content-end align-items-center">
                                    <h3 class="abou02__topic__title">Titulo Topico</h3>
                                    <div class="abou02__boxRight__paragraph">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                    </div>
                                    
                                </div>
                            </div>
                            @include('Client.pages.Abouts.ABOU02.show')
                        </div>
                    </a>
                </article>
            </div>
        </div>
    </div>
</section>
{{-- END .abou02 --}}