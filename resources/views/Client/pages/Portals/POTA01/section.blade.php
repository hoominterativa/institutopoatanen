@if ($portals->count())
    <section id="POTA01" class="pota01 container-fluid">
        <div class="container">
            @if ($section)
                @if ($section->title??false || $section->subtitle??false || $section->description??false)
                    <header class="pota01__header">
                        <h3 class="pota01__header__hypertext">
                            @if ($section->title??false)
                                <span class="pota01__header__title">{{$section->title}}</span>
                            @endif
                            @if ($section->subtitle??false)
                                <span class="pota01__header__subtitle">{{$section->subtitle}}</span>
                            @endif
                        </h3>
                        @if ($section->description??false)
                            <hr class="pota01__header__line">
                            <p class="pota01__header__paragraph">{{$section->description}}</p>
                        @endif
                    </header>
                @endif
            @endif
            <div class="pota01__boxs row pota01__boxs__carousel">
                @foreach ($portals as $portal)
                    <article class="pota01__boxs__item col-12">
                        <div itemscope itemtype="http://schema.org/Article" class="pota01__boxs__item__content transition">
                            <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portal->category->slug, 'POTA01Portals' => $portal->slug])}}">
                                <figure class="pota01__boxs__item__image">
                                    <img itemprop="image" src="{{asset('storage/'.$portal->path_image_thumbnail)}}" class="pota01__boxs__item__image__img" width="100%" alt="{{$portal->title}}"/>
                                </figure>
                                <div class="pota01__boxs__item__description d-flex align-items-center justify-content-between">
                                    <h2 itemprop="name" class="pota01__boxs__item__title">{{$portal->title}}</h2>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="pota01__boxs__item__icon" alt="{{$portal->title}}"/>
                                </div>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
