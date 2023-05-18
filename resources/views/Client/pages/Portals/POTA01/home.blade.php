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
                            @foreach ($podcasts as $podcast)
                                <article class="pota01-home__podcast__item">
                                    <div class="pota01-home__podcast__item__content">
                                        <a href="{{route('pota01.podcast',['playing' => Str::slug($podcast->title)])}}" class="">
                                            @if ($podcast->path_image_thumbnail)
                                                <div class="pota01-home__podcast__item__image">
                                                    <img src="{{asset('storage/'.$podcast->path_image_thumbnail)}}" class="pota01-home__podcast__item__image__img" alt="">
                                                </div>
                                            @endif
                                        </a>
                                        <div class="pota01-home__podcast__item__description" {{!$podcast->path_image_thumbnail?'style=width:100%;':''}}>
                                            <a href="{{route('pota01.podcast',['playing' => Str::slug($podcast->title)])}}" class="">
                                                @if ($podcast->title)
                                                    <h2 class="pota01-home__podcast__item__title">{{$podcast->title}}</h2>
                                                @endif
                                                @if ($podcast->duration)
                                                    <span class="pota01-home__podcast__item__duration">Duração: {{$podcast->duration}}min</span>
                                                @endif
                                                @if ($podcast->publishing)
                                                    <span class="pota01-home__podcast__item__publish">{{dateFormat($podcast->publishing, 'd', 'M', 'Y', '')}}</span>
                                                @endif
                                            </a>
                                            @if ($podcast->embed && !$podcast->path_image_thumbnail)
                                                <div class="mt-3">
                                                    {!! $podcast->embed !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                        <a href="{{route('pota01.podcast')}}" class="pota01-home__podcast__link">Todos os Podcasts</a>
                    </div>
                    {{-- END .pota01-home__podcast --}}

                    <div class="pota01-home__adverts pota01-home__adverts--homeBottomPodcast">
                        @forelse ($advertsBottomPodcast as $advertBottomPodcast)
                            <div class="pota01-home__adverts__item {{!$advertsBottomPodcast->count()?'pota01-home__adverts__item--advertiseHere':''}}">
                                @if ($advertsBottomPodcast->count())
                                    @if ($advertBottomPodcast->path_image)
                                        @if ($advertBottomPodcast->link)
                                            <a href="{{$advertBottomPodcast->link}}" target="{{$advertBottomPodcast->link_target}}" class="link-full"></a>
                                        @endif
                                        <img src="{{asset('storage/'.$advertBottomPodcast->path_image)}}" width="100%" class="pota01-home__adverts__item__image" alt="">
                                    @elseif($advertBottomPodcast->adsense)
                                        {!! $advertBottomPodcast->adsense !!}
                                    @else
                                        <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                                    @endif
                                @else
                                    <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                                @endif
                            </div>
                        @empty
                            <div class="pota01-home__adverts__item pota01-home__adverts__item--advertiseHere">
                                <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                            </div>
                            <div class="pota01-home__adverts__item pota01-home__adverts__item--advertiseHere">
                                <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                            </div>
                        @endforelse
                    </div>
                    {{-- END .pota01-home__adverts --}}
                </div>
                {{-- END .pota01-home__news__end --}}
            </div>
            {{-- END .row --}}

            <div class="pota01-home__adverts pota01-home__adverts--bottomLatestNews">
                <div class="pota01-home__adverts__item {{!$advertsBottomLatestNews?'pota01-home__adverts__item--advertiseHere':''}}">
                    @if ($advertsBottomLatestNews)
                        @if ($advertsBottomLatestNews->path_image)
                            @if ($advertsBottomLatestNews->link)
                                <a href="{{$advertsBottomLatestNews->link}}" target="{{$advertsBottomLatestNews->link_target}}" class="link-full"></a>
                            @endif
                            <img src="{{asset('storage/'.$advertsBottomLatestNews->path_image)}}" width="100%" class="pota01-home__adverts__item__image" alt="">
                        @elseif($advertsBottomLatestNews->adsense)
                            {!! $advertsBottomLatestNews->adsense !!}
                        @else
                            <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                        @endif
                    @else
                        <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                    @endif
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
                    <div class="pota01-home__adverts__item {{!$categoryFeaturedHome->adverts?'pota01-home__adverts__item--advertiseHere':''}}">
                        @if ($categoryFeaturedHome->adverts)
                            @if ($categoryFeaturedHome->adverts->path_image)
                                @if ($categoryFeaturedHome->adverts->link)
                                    <a href="{{$categoryFeaturedHome->adverts->link}}" target="{{$categoryFeaturedHome->adverts->link_target}}" class="link-full"></a>
                                @endif
                                <img src="{{asset('storage/'.$categoryFeaturedHome->adverts->path_image)}}" width="100%" class="pota01-home__adverts__item__image" alt="">
                            @elseif($categoryFeaturedHome->adverts->adsense)
                                {!! $categoryFeaturedHome->adverts->adsense !!}
                            @else
                                <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                            @endif
                        @else
                            <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                        @endif
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
