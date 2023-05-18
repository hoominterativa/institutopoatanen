@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <section id="POTA01" class="pota01-page container-fluid px-0">
        <div class="pota01-page__container container-fluid">
            <nav class="pota01-page__categories d-flex justify-content-center align-items-center">
                @foreach ($categories as $category)
                    <a href="{{route('pota01.category.page', ['POTA01PortalsCategory' => $category->slug])}}" class="pota01-page__categories__item {{$categoryCurrent->id==$category->id?'active':''}}">{{$category->title}}</a>
                @endforeach
            </nav>
            {{-- END .pota01-page__categories --}}
        </div>
        <header class="pota01-page__header">
            <div class="container d-flex align-items-center h-100">
                @if ($categoryCurrent->exists)
                    <h1 class="pota01-page__header__title">{{$categoryCurrent->title}}</h1>
                @else
                    <h3 class="pota01-page__header__title">Blog</h3>
                @endif
                <div class="pota01-home__adverts pota01-home__adverts--categoryInnerBeginPage ms-auto">
                    <div class="pota01-home__adverts__item {{!$advertsInnerBeginPage?'pota01-home__adverts__item--advertiseHere':''}}">
                        @if ($advertsInnerBeginPage)
                            @if ($advertsInnerBeginPage->path_image)
                                @if ($advertsInnerBeginPage->link)
                                    <a href="{{$advertsInnerBeginPage->link}}" target="{{$advertsInnerBeginPage->link_target}}" class="link-full"></a>
                                @endif
                                <img src="{{asset('storage/'.$advertsInnerBeginPage->path_image)}}" width="100%" class="pota01-home__adverts__item__image" alt="">
                            @elseif($advertsInnerBeginPage->adsense)
                                {!! $advertsInnerBeginPage->adsense !!}
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
        </header>
        <div class="container">
            <div class="pota01-page__boxs row">
                <div class="pota01-page__boxs__featured pota01-page__boxs__featured__carousel col-12 {{$portalsFeatured->count()<=0?'p-5':''}}">
                    @foreach ($portalsFeatured as $portalFeatured)
                        <article class="pota01-page__boxs__featured__item">
                            <div itemscope itemtype="http://schema.org/Article" class="pota01-page__boxs__featured__item__content transition row align-items-center">
                                <figure class="pota01-page__boxs__featured__item__image col-12 col-sm-6">
                                    <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portalFeatured->category->slug, 'POTA01Portals' => $portalFeatured->slug])}}">
                                        <img itemprop="image" src="{{asset('storage/'.$portalFeatured->path_image)}}" class="pota01-page__boxs__featured__item__image__img" width="100%" alt="{{$portalFeatured->title}}"/>
                                    </a>
                                </figure>
                                <div class="pota01-page__boxs__featured__item__description col-12 col-sm-6">
                                    <span class="pota01-page__boxs__featured__item__category">{{$portalFeatured->category->title}}</span>
                                    <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portalFeatured->category->slug, 'POTA01Portals' => $portalFeatured->slug])}}">
                                        <h2 itemprop="name" class="pota01-page__boxs__featured__item__title">{{$portalFeatured->title}}</h2>
                                    </a>
                                    <span class="pota01-page__boxs__featured__item__date-publish">
                                        Data: <span itemprop="datePublished" content="{{$portalFeatured->publishing}}" class="pota01-page__boxs__featured__item__date">{{dateFormat($portalFeatured->publishing, 'd', 'M', 'Y', '')}}</span>
                                    </span>
                                    <p itemprop="articleBody" class="pota01-page__boxs__featured__item__paragraph">{{$portalFeatured->description}}</p>
                                    <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portalFeatured->category->slug, 'POTA01Portals' => $portalFeatured->slug])}}" class="pota01-page__boxs__featured__item__cta d-flex align-items-center justify-content-center ms-auto">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="pota01-page__boxs__featured__item__cta__icon me-3" alt="{{$portalFeatured->title}}"/>
                                        CTA
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    {{-- END .pota01-page__boxs__featured__item --}}
                </div>
                {{-- END .pota01-page__boxs__featured --}}

                @foreach ($portals as $portal)
                    <article class="pota01-page__boxs__item col-12 col-sm-4 col-md-3">
                        <div itemscope itemtype="http://schema.org/Article" class="pota01-page__boxs__item__content transition">
                            <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portal->category->slug, 'POTA01Portals' => $portal->slug])}}">
                                <figure class="pota01-page__boxs__item__image mb-0">
                                    <img itemprop="image" src="{{asset('storage/'.$portal->path_image_thumbnail)}}" class="pota01-page__boxs__item__image__img" width="100%" alt="{{$portal->title}}"/>
                                </figure>
                                <div class="pota01-page__boxs__item__description">
                                    <span class="pota01-page__boxs__item__publish">{{dateFormat($portal->publishing, 'd', 'M', 'Y', '')}}</span>
                                    <h2 itemprop="name" class="pota01-page__boxs__item__title">{{$portal->title}}</h2>
                                </div>
                            </a>
                        </div>
                    </article>
                @endforeach
                {{-- END .pota01-page__boxs__item --}}

                <div class="pota01-page__pagination">
                    {{$portals->links()}}
                </div>
                <div class="pota01-home__adverts pota01-home__adverts--categoryInnerEndPage">
                    <div class="pota01-home__adverts__item {{!$advertsInnerEndPage?'pota01-home__adverts__item--advertiseHere':''}}">
                        @if ($advertsInnerEndPage)
                            @if ($advertsInnerEndPage->path_image)
                                @if ($advertsInnerEndPage->link)
                                    <a href="{{$advertsInnerEndPage->link}}" target="{{$advertsInnerEndPage->link_target}}" class="link-full"></a>
                                @endif
                                <img src="{{asset('storage/'.$advertsInnerEndPage->path_image)}}" width="100%" class="pota01-home__adverts__item__image" alt="">
                            @elseif($advertsInnerEndPage->adsense)
                                {!! $advertsInnerEndPage->adsense !!}
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
            {{-- END .pota01-page__boxs --}}
        </div>
        {{-- END .container --}}
    </section>
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
