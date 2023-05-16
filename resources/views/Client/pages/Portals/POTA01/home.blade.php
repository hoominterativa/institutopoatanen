<div id="POTA01">
    <section class="pota01-home container-fluid">
        <div class="pota01-home__container container-fluid">
            <nav class="pota01-home__categories d-flex justify-content-center align-items-center">
                @foreach ($categories as $category)
                    <a href="{{route('pota01.category.page', ['POTA01PortalsCategory' => $category->slug])}}" class="pota01-home__categories__item">{{$category->title}}</a>
                @endforeach
            </nav>
            {{-- END .pota01-home__categories --}}
        </div>

        <div class="pota01-home__containerFeaturedHome container">
            <div class="pota01-home__featuredHome">
                <div class="pota01-home__featuredHome__caroussel">
                    @foreach ($portalsFeatureHome as $portalFeatureHome)
                        <article class="pota01-home__featuredHome__item position-relative">
                            <div class="h-100 w-100" itemscope itemtype="http://schema.org/Article">
                                <img itemprop="image" src="{{asset('storage/'.$portalFeatureHome->path_image_thumbnail)}}"  alt="{{$portalFeatureHome->title}}" width="100%" height="100%" class="position-absolute top-0 start-0 pota01-home__featuredHome__item__image">
                                <a itemprop="url" href="{{route('pota01.show.content',['POTA01PortalsCategory'=> $portalFeatureHome->category->slug, 'POTA01Portals' => $portalFeatureHome->slug])}}" class="link-full"></a>
                                <div class="pota01-home__featuredHome__item__description">
                                    <h2 itemprop="name" class="pota01-home__featuredHome__item__title">{{$portalFeatureHome->title}}</h2>
                                    <span class="pota01-home__featuredHome__item__publishing">{{dateFormat($portalFeatureHome->publishing, 'd', 'M', 'Y', '')}}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                {{-- END .pota01-home__featuredHome__caroussel --}}
            </div>
            {{-- END .pota01-home__featuredHome --}}
        </div>
        {{-- .pota01-home__containerFeaturedHome --}}
    </section>
    {{-- END .pota01-home --}}

    <section class="pota01-home__news">
        <div class="pota01-home__news__container container">
            <div class="row">
                <div class="pota01-home__news__start col-12 col-sm-8">
                    <h4 class="pota01-home__news__start__titleSection">
                        <span>Últimas noticias</span>
                    </h4>
                    <div class="pota01-home__news__start__row pota01-home__boxs row">
                        @foreach ($portals as $portal)
                            <article class="pota01-home__boxs__item col-12 col-sm-6">
                                <div itemscope itemtype="http://schema.org/Article" class="pota01-home__boxs__item__content transition">
                                    <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portal->category->slug, 'POTA01Portals' => $portal->slug])}}">
                                        <figure class="pota01-home__boxs__item__image mb-0">
                                            <img itemprop="image" src="{{asset('storage/'.$portal->path_image_thumbnail)}}" class="pota01-home__boxs__item__image__img" width="100%" alt="{{$portal->title}}"/>
                                        </figure>
                                        <div class="pota01-home__boxs__item__description">
                                            <span class="pota01-home__boxs__item__publish">{{dateFormat($portal->publishing, 'd', 'M', 'Y', '')}}</span>
                                            <h2 itemprop="name" class="pota01-home__boxs__item__title">{{$portal->title}}</h2>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    {{-- END .pota01-home__news__start__row --}}
                </div>
                {{-- END .pota01-home__news__start --}}
                <div class="pota01-home__news__end col-12 col-sm-4">
                    <div class="pota01-home__podcast">
                        <h4 class="pota01-home__podcast__titleSection">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="pota01-home__podcast__titleSection__icon" width="45" alt="Podcast">
                            PODCAST
                        </h4>
                        <div class="pota01-home__podcast__tracks">
                            <article class="pota01-home__podcast__item">
                                <div class="pota01-home__podcast__item__content">
                                    <div class="pota01-home__podcast__item__image">
                                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="pota01-home__podcast__item__image__img" alt="">
                                    </div>
                                    <div class="pota01-home__podcast__item__description">
                                        <h2 class="pota01-home__podcast__item__title">Ouça o que esta acontecendo na sua região com Liborio News</h2>
                                        <span class="pota01-home__podcast__item__duration">Duração: 30min</span>
                                        <span class="pota01-home__podcast__item__publish">{{dateFormat(date('Y-m-d'), 'd', 'M', 'Y', '')}}</span>
                                    </div>
                                </div>
                            </article>
                            <article class="pota01-home__podcast__item">
                                <div class="pota01-home__podcast__item__content">
                                    <div class="pota01-home__podcast__item__image">
                                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="pota01-home__podcast__item__image__img" alt="">
                                    </div>
                                    <div class="pota01-home__podcast__item__description">
                                        <h2 class="pota01-home__podcast__item__title">Ouça o que esta acontecendo na sua região com Liborio News</h2>
                                        <span class="pota01-home__podcast__item__duration">Duração: 30min</span>
                                        <span class="pota01-home__podcast__item__publish">{{dateFormat(date('Y-m-d'), 'd', 'M', 'Y', '')}}</span>
                                    </div>
                                </div>
                            </article>
                            <article class="pota01-home__podcast__item">
                                <div class="pota01-home__podcast__item__content">
                                    <div class="pota01-home__podcast__item__image">
                                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="pota01-home__podcast__item__image__img" alt="">
                                    </div>
                                    <div class="pota01-home__podcast__item__description">
                                        <h2 class="pota01-home__podcast__item__title">Ouça o que esta acontecendo na sua região com Liborio News</h2>
                                        <span class="pota01-home__podcast__item__duration">Duração: 30min</span>
                                        <span class="pota01-home__podcast__item__publish">{{dateFormat(date('Y-m-d'), 'd', 'M', 'Y', '')}}</span>
                                    </div>
                                </div>
                            </article>
                            <article class="pota01-home__podcast__item">
                                <div class="pota01-home__podcast__item__content">
                                    <div class="pota01-home__podcast__item__image">
                                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="pota01-home__podcast__item__image__img" alt="">
                                    </div>
                                    <div class="pota01-home__podcast__item__description">
                                        <h2 class="pota01-home__podcast__item__title">Ouça o que esta acontecendo na sua região com Liborio News</h2>
                                        <span class="pota01-home__podcast__item__duration">Duração: 30min</span>
                                        <span class="pota01-home__podcast__item__publish">{{dateFormat(date('Y-m-d'), 'd', 'M', 'Y', '')}}</span>
                                    </div>
                                </div>
                            </article>
                            <article class="pota01-home__podcast__item">
                                <iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/31Cf5jVqLfzMM8WM15nOJB?utm_source=generator" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
                            </article>
                        </div>
                        <a href="{{route('pota01.podcast')}}" class="pota01-home__podcast__link">Todos os Podcasts</a>
                    </div>
                    {{-- END .pota01-home__podcast --}}

                    <div class="pota01-home__adverts pota01-home__adverts--bottomPodcast">
                        <div class="pota01-home__adverts__item pota01-home__adverts__item--advertiseHere">
                            <a href="#" class="link-full"></a>
                            <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                        </div>
                        <div class="pota01-home__adverts__item">
                            <a href="#" class="link-full"></a>
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" class="pota01-home__adverts__item__image" alt="">
                        </div>
                    </div>
                    {{-- END .pota01-home__adverts --}}
                </div>
                {{-- END .pota01-home__news__end --}}
            </div>
            {{-- END .row --}}

            <div class="pota01-home__adverts pota01-home__adverts--bottomLatestNews">
                <div class="pota01-home__adverts__item pota01-home__adverts__item--advertiseHere">
                    <a href="#" class="link-full"></a>
                    <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                </div>
            </div>
            {{-- END .pota01-home__adverts --}}
        </div>
        {{-- END .pota01-home__news --}}
    </section>
    {{-- END .pota01-home__news --}}
    @if ($portalsVideoFeatured || $portalsVideo->count())
        <section class="pota01-home__videos">
            <div class="container">
                <h4 class="pota01-home__videos__titleSection">
                    <span>Vídeos</span>
                    <a href="{{route('pota01.category.page', ['POTA01PortalsCategory' => $categoryVideo->slug])}}" class="pota01-home__videos__titleSection__link">Ver Todos</a>
                </h4>
                {{-- END .pota01-home__videos__titleSection --}}
                <div class="pota01-home__videos__items row">
                    <div class="pota01-home__videos__wrapFetured col-12 col-sm-7">
                        <article class="pota01-home__videos__item position-relative">
                            <div class="h-100 w-100" itemscope itemtype="http://schema.org/Article">
                                <img itemprop="image" src="{{asset('storage/'.$portalsVideoFeatured->path_image_thumbnail)}}" alt="{{$portalsVideoFeatured->title}}" width="100%" height="100%" class="position-absolute top-0 start-0 pota01-home__videos__item__image">
                                <a itemprop="url" href="{{route('pota01.show.content',['POTA01PortalsCategory'=> $portalsVideoFeatured->category->slug, 'POTA01Portals' => $portalsVideoFeatured->slug])}}" class="link-full"></a>
                                <div class="pota01-home__videos__item__description">
                                    <svg class="pota01-home__videos__play" width="47" height="46" viewBox="0 0 47 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="23.5835" cy="22.948" r="21.292" fill="white" fill-opacity="0.1" stroke="white" stroke-width="3"/>
                                        <path d="M33.6118 22.4922L19.2529 30.7823V14.202L33.6118 22.4922Z" fill="white"/>
                                    </svg>
                                    <h2 itemprop="name" class="pota01-home__videos__item__title">{{$portalsVideoFeatured->title}}</h2>
                                    <span class="pota01-home__videos__item__publishing">{{dateFormat($portalsVideoFeatured->publishing, 'd', 'M', 'Y', '')}}</span>
                                </div>
                            </div>
                        </article>
                    </div>
                    {{-- END .pota01-home__videos__wrapFetured --}}
                    <div class="col-12 col-sm-5 row">
                        @foreach ($portalsVideo as $portalVideo)
                            <article class="pota01-home__videos__boxs__item col-12 col-sm-6">
                                <div itemscope itemtype="http://schema.org/Article" class="pota01-home__videos__boxs__item__content transition">
                                    <a itemprop="url" href="{{route('pota01.show.content',['POTA01PortalsCategory'=> $portalVideo->category->slug, 'POTA01Portals' => $portalVideo->slug])}}">
                                        <figure class="pota01-home__videos__boxs__item__image mb-0">
                                            <img itemprop="image" src="{{asset('storage/'.$portalVideo->path_image_thumbnail)}}" class="pota01-home__videos__boxs__item__image__img" width="100%" alt="{{$portalVideo->title}}"/>
                                            <svg class="pota01-home__videos__play" width="47" height="46" viewBox="0 0 47 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="23.5835" cy="22.948" r="21.292" fill="white" fill-opacity="0.1" stroke="white" stroke-width="3"/>
                                                <path d="M33.6118 22.4922L19.2529 30.7823V14.202L33.6118 22.4922Z" fill="white"/>
                                            </svg>
                                        </figure>
                                        <div class="pota01-home__videos__boxs__item__description">
                                            <h2 itemprop="name" class="pota01-home__videos__boxs__item__title">{{$portalVideo->title}}</h2>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    {{-- END .row --}}
                </div>
                {{-- END .pota01-home__videos__items --}}
            </div>
            {{-- END .container --}}
        </section>
        {{-- END .pota01-home__videos --}}
    @endif

    <section class="pota01-home__categoriesFeatured">
        @foreach ($categoriesFeaturedHome as $categoryFeaturedHome)
            <div class="pota01-home__categoriesFeatured__container container">
                <h4 class="pota01-home__categoriesFeatured__titleSection">
                    <span>{{$categoryFeaturedHome->title}}</span>
                    <a href="{{route('pota01.category.page', ['POTA01PortalsCategory' => $categoryFeaturedHome->slug])}}" class="pota01-home__categoriesFeatured__titleSection__link">Ver Todos</a>
                </h4>
                {{-- END .pota01-home__videos__titleSection --}}
                <div class="pota01-home__categoriesFeatured__news row">
                    @foreach ($categoryFeaturedHome->portals as $portal)
                        <article class="pota01-home__categoriesFeatured__news__item col-12 col-sm-4 col-md-3">
                            <div itemscope itemtype="http://schema.org/Article" class="pota01-home__categoriesFeatured__news__item__content transition">
                                <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portal->category->slug, 'POTA01Portals' => $portal->slug])}}">
                                    <figure class="pota01-home__categoriesFeatured__news__item__image mb-0">
                                        <img itemprop="image" src="{{asset('storage/'.$portal->path_image_thumbnail)}}" class="pota01-home__categoriesFeatured__news__item__image__img" width="100%" alt="{{$portal->title}}"/>
                                    </figure>
                                    <div class="pota01-home__categoriesFeatured__news__item__description">
                                        <span class="pota01-home__categoriesFeatured__news__item__publish">{{dateFormat($portal->publishing, 'd', 'M', 'Y', '')}}</span>
                                        <h2 itemprop="name" class="pota01-home__categoriesFeatured__news__item__title">{{$portal->title}}</h2>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="pota01-home__adverts pota01-home__adverts--category">
                    <div class="pota01-home__adverts__item pota01-home__adverts__item--advertiseHere">
                        <a href="#" class="link-full"></a>
                        <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                    </div>
                </div>
                {{-- END .pota01-home__adverts --}}
            </div>
            {{-- END .container --}}
        @endforeach
    </section>
    {{-- END .pota01-home__categoriesFeatured --}}
</div>
{{-- END #POTA01 --}}
