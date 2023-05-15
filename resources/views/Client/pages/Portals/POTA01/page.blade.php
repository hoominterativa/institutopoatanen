@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <section id="POTA01" class="pota01-page container-fluid px-0">
        <header class="pota01-page__header bg-light" style="background-image: url({{asset('images/image-blog.jpg')}})">
            <div class="container d-flex flex-column justify-content-center h-100">
                <h1 class="pota01-page__header__title">Título página</h1>
                <nav class="pota01-page__header__category pota01-page__header__category__carousel d-flex justify-content-center">
                    @foreach ($categories as $category)
                        <a href="{{route('pota01.category.page', ['POTA01PortalsCategory' => $category->slug])}}" class="pota01-page__header__category__item {{isset($category->selected)?'pota01-page__header__category__item--active':''}}">{{$category->title}}</a>
                    @endforeach
                </nav>
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
                                        Data: <span itemprop="datePublished" content="{{$portalFeatured->publishing}}" class="pota01-page__boxs__featured__item__date">{{Carbon\Carbon::parse($portalFeatured->publishing)->formatLocalized('%d de %B de %Y')}}</span>
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
                    <article class="pota01-page__boxs__item col-12 col-sm-3">
                        <div itemscope itemtype="http://schema.org/Article" class="pota01-page__boxs__item__content transition">
                            <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portal->category->slug, 'POTA01Portals' => $portal->slug])}}">
                                <figure class="pota01-page__boxs__item__image">
                                    <img itemprop="image" src="{{asset('storage/'.$portal->path_image_thumbnail)}}" class="pota01-page__boxs__item__image__img" width="100%" alt="{{$portal->title}}"/>
                                </figure>
                                <div class="pota01-page__boxs__item__description">
                                    <span class="pota01-page__boxs__item__date-publish">
                                        Data: <span itemprop="datePublished" content="{{$portal->publishing}}" class="pota01-page__boxs__item__date">{{Carbon\Carbon::parse($portal->publishing)->formatLocalized('%d de %B de %Y')}}</span>
                                    </span>
                                    <h3 itemprop="name" class="pota01-page__boxs__item__title">{{$portal->title}}</h3>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p itemprop="articleBody" class="pota01-page__boxs__item__paragraph">{{$portal->description}}</p>
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="pota01-page__boxs__item__icon ms-3" alt="{{$portal->title}}"/>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </article>
                @endforeach
                {{-- END .pota01-page__boxs__item --}}

                <div class="pota01-page__pagination">
                    {{$portals->links()}}
                </div>
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
