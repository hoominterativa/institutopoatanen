<section id="PROD02" class="prod02 container-fluid px-0">
    <div class="container container--edit">
        <header class="prod02__navigation">
            <div class="prod02__navigation__content d-flex justify-content-between w-100">
                <div class="prod02__navigation__content__encompass">
                    <h1 class="prod02__navigation__content__encompass__title">Titulo</h1>
                    <h2 class="prod02__navigation__content__encompass__subtitle mb-0">Subtitulo</h2>
                </div>
                {{-- Finish prod02__navigation__content__encompass --}}
                <nav class="prod02__navigation__content__nav__desktop justify-content-between align-items-center">
                    <ul class="d-flex align-content-center mb-0 px-0">
                        <li><a href="#">Categorias</a></li>
                        {{-- Finish prod02__navigation__content__ul__li --}}
                        <li><a href="#">Categorias</a></li>
                        {{-- Finish prod02__navigation__content__ul__li --}}
                        <li><a href="#">Categorias</a></li>
                        {{-- Finish prod02__navigation__content__ul__li --}}
                        <li><a href="#">Categorias</a></li>
                        {{-- Finish prod02__navigation__content__ul__li --}}
                        <li><a href="#">Categorias</a></li>
                        {{-- Finish prod02__navigation__content__ul__li --}}
                    </ul>
                    {{-- Finish prod02__navigation__content__ul --}}
                    <a href="{{route('prod02.page')}}" class="prod02__navigation__content__nav__desktop__cta transition d-flex justify-content-center align-items-center">
                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__navigation__content__nav__desktop__cta__icon me-3 transition">
                        CTA
                    </a>
                    {{-- Finish prod02__navigation__content__nav__desktop__cta --}}
                </nav>
                {{-- Finish prod02__navigation__content__nav__desktop --}}
            </div>
            {{-- Finish prod02__navigation__content --}}
            <ul class="prod02__navigation__nav__mobile align-content-center mb-0 px-0">
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Categorias</a></li>
            </ul>
            {{-- Finish prod02__navigation__nav__mobile --}}
            <div class="prod02__navigation__paragraph">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                </p>
            </div>
            {{-- Finish prod02__navigation__paragraph --}}
        </header>
        {{-- Finish prod02__navigation --}}
        <div class="prod02__content__product">
            <div class="carousel-prod02 owl-carousel">
                <article class="prod02__content__product__item w-100">
                    <div class="prod02__content__product__item__image w-100 h-100">
                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="prod02__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                        <h2 class="prod02__content__product__item__description__title mx-0 px-0">Titulo Topico</h2>
                        <div class="prod02__content__product__item__description_paragraph mx-0 px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            </p>
                        </div>
                        <a rel="next" href="javascript-void(0);" data-fancybox="" data-src="#lightbox-prod02-1" class="prod02__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__content__product__item__cta__icon me-3 transition">
                            CTA
                        </a>
                    </div>
                    @include('Client.pages.Products.PROD02.show')
                </article>
                {{-- Finish prod02__content__product__item --}}
            </div>
            {{-- Finish carousel-prod02 --}}
        </div>
        {{-- Finish prod02__content__product --}}
    </div>
    {{-- Finish container --}}
</section>
{{-- Finish prod02 --}}