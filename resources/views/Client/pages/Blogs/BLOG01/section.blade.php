<section id="BLOG01" class="blog01 container-fluid">
    <div class="container">
        <header class="blog01__header">
            <h3 class="blog01__header__hypertext">
                <span class="blog01__header__title">Título</span>
                <span class="blog01__header__subtitle">Subtítulo</span>
            </h3>
            <hr class="blog01__header__line">
            <p class="blog01__header__paragraph">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
            </p>
        </header>
        <div class="blog01__boxs row blog01__boxs__carousel">
            <article class="blog01__boxs__item col-12 col-sm-3">
                <div itemscope itemtype="http://schema.org/Article" class="blog01__boxs__item__content transition">
                    <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                        <figure class="blog01__boxs__item__image">
                            <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                        </figure>
                        <div class="blog01__boxs__item__description d-flex align-items-center justify-content-between">
                            <h2 itemprop="name" class="blog01__boxs__item__title">Titulo Topico</h2>
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01__boxs__item__icon" alt="Titulo Topico"/>
                        </div>
                    </a>
                </div>
            </article>
            {{-- END .blog01__boxs__item --}}
            <article class="blog01__boxs__item col-12 col-sm-3">
                <div itemscope itemtype="http://schema.org/Article" class="blog01__boxs__item__content transition">
                    <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                        <figure class="blog01__boxs__item__image">
                            <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                        </figure>
                        <div class="blog01__boxs__item__description d-flex align-items-center justify-content-between">
                            <h2 itemprop="name" class="blog01__boxs__item__title">Titulo Topico</h2>
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01__boxs__item__icon" alt="Titulo Topico"/>
                        </div>
                    </a>
                </div>
            </article>
            {{-- END .blog01__boxs__item --}}
            <article class="blog01__boxs__item col-12 col-sm-3">
                <div itemscope itemtype="http://schema.org/Article" class="blog01__boxs__item__content transition">
                    <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                        <figure class="blog01__boxs__item__image">
                            <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                        </figure>
                        <div class="blog01__boxs__item__description d-flex align-items-center justify-content-between">
                            <h2 itemprop="name" class="blog01__boxs__item__title">Titulo Topico</h2>
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01__boxs__item__icon" alt="Titulo Topico"/>
                        </div>
                    </a>
                </div>
            </article>
            {{-- END .blog01__boxs__item --}}
            <article class="blog01__boxs__item col-12 col-sm-3">
                <div itemscope itemtype="http://schema.org/Article" class="blog01__boxs__item__content transition">
                    <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                        <figure class="blog01__boxs__item__image">
                            <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                        </figure>
                        <div class="blog01__boxs__item__description d-flex align-items-center justify-content-between">
                            <h2 itemprop="name" class="blog01__boxs__item__title">Titulo Topico</h2>
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01__boxs__item__icon" alt="Titulo Topico"/>
                        </div>
                    </a>
                </div>
            </article>
            {{-- END .blog01__boxs__item --}}
        </div>
    </div>
</section>
