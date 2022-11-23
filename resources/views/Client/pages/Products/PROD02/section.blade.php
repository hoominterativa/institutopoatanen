<section id="PROD02" class="prod02 container-fluid px-0">
    <div class="container container--edit">
        <header class="prod02__navigation">
            <div class="prod02__navigation__content d-flex justify-content-between w-100">
                <div class="prod02__navigation__content__encompass">
                    <h1 class="prod02__navigation__content__encompass__title">Titulo</h1>
                    <h2 class="prod02__navigation__content__encompass__subtitle mb-0">Subtitulo</h2>
                </div>
                <nav class="prod02__navigation__content__nav__desktop justify-content-between align-items-center">
                    <ul class="d-flex align-content-center mb-0 px-0">
                        <li><a href="#">Categorias</a></li>
                        <li><a href="#">Categorias</a></li>
                        <li><a href="#">Categorias</a></li>
                        <li><a href="#">Categorias</a></li>
                        <li><a href="#">Categorias</a></li>
                    </ul>
                    <a href="{{route('prod02.page')}}" class="prod02__navigation__content__nav__desktop__cta transition d-flex justify-content-center align-items-center">
                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__navigation__content__nav__desktop__cta__icon me-3 transition">
                        CTA
                    </a>
                </nav>
            </div>
            <ul class="prod02__navigation__nav__mobile d-flex align-content-center mb-0 px-0">
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Categorias</a></li>
            </ul>
            <div class="prod02__navigation__paragraph">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                </p>
            </div>
        </header>
        <div class="prod02__content_product">
            <div class="caroussel-prod02">
                <article class="prod02__content_item">
                    <div class="prod02__content_item_image">
                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" alt="Titulo Topico">
                    </div>
                    <div class="prod02__content_item_description">
                        <h2 class="prod02__content_item_description__title">Titulo Topico</h2>
                        <div class="prod02__content_item_description_paragraph">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            </p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>