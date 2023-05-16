@extends('Client.Core.client')
@section('content')
    <main id="root">
        <div class="pota01-page__container container-fluid">
            <nav class="pota01-page__categories d-flex justify-content-center align-items-center">
                @foreach ($categories as $category)
                    <a href="{{route('pota01.category.page', ['POTA01PortalsCategory' => $category->slug])}}" class="pota01-page__categories__item {{$categoryCurrent->id==$category->id?'active':''}}">{{$category->title}}</a>
                @endforeach
            </nav>
            {{-- END .pota01-page__categories --}}
        </div>
        <section id="POTA01" class="pota01-show container-fluid">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="pota01-show__col-start col-12 col-sm-8">
                        <article itemscope itemtype="http://schema.org/Article" class="pota01-show__item">
                            <h1 itemprop="name" class="pota01-show__item__title">{{$portal->title}}</h1>
                            <span class="pota01-show__item__published">
                                Data: <span itemprop="datePublished" content="{{$portal->publishing}}" class="pota01-show__item__date">{{dateFormat($portal->publishing, 'd', 'M', 'Y', '')}}</span>
                            </span>
                            <p itemprop="articleSection" class="pota01-show__item__paragraph">{{$portal->description}}</p>
                            <figure class="pota01-show__item__image">
                                <img itemprop="image" src="{{asset('storage/'.$portal->path_image)}}" width="100%" alt="{{$portal->title}}" class="pota01-show__item__img"/>
                            </figure>
                            <div itemprop="articleBody" class="ck-content pota01-show__item__description">
                                {!!$portal->text!!}
                            </div>
                        </article>
                    </div>
                    <div class="pota01-show__col-end col-12 col-sm-3">
                        <div class="pota01-show__related">
                            <a href="" class="pota01-show__related__share">Compartilhar Artigo</a>
                            <h4 class="pota01-show__related__title">Artigos Relacionados</h4>
                            @foreach ($portalsRelated as $portalRelated)
                                <article class="pota01-show__boxs__item col-12">
                                    <div itemscope itemtype="http://schema.org/Article" class="pota01-show__boxs__item__content transition">
                                        <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portalRelated->category->slug, 'POTA01Portals' => $portalRelated->slug])}}">
                                            <figure class="pota01-show__boxs__item__image mb-0">
                                                <img itemprop="image" src="{{asset('storage/'.$portalRelated->path_image_thumbnail)}}" class="pota01-show__boxs__item__image__img" width="100%" alt="{{$portalRelated->title}}"/>
                                            </figure>
                                            <div class="pota01-show__boxs__item__description">
                                                <span class="pota01-show__boxs__item__publish">{{dateFormat($portalRelated->publishing, 'd', 'M', 'Y', '')}}</span>
                                                <h2 itemprop="name" class="pota01-show__boxs__item__title">{{$portalRelated->title}}</h2>
                                            </div>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                            {{-- END .pota01-page__boxs__item --}}
                        </div>
                    </div>
                </div>
                <div class="pota01-show__footer d-flex">
                    <nav class="pota01-show__footer__tags d-flex flex-wrap align-items-center">
                        <h5 class="pota01-show__footer__tags__title d-flex align-items-center">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="me-1" width="16px" alt="">
                            TAGS
                        </h5>
                        <a href="#" class="pota01-show__footer__tags__item">MODA</a>
                        <a href="#" class="pota01-show__footer__tags__item">SUCESSO</a>
                        <a href="#" class="pota01-show__footer__tags__item">POLITICA</a>
                        <a href="#" class="pota01-show__footer__tags__item">VIDEOS</a>
                        <a href="#" class="pota01-show__footer__tags__item">NEWS</a>
                    </nav>
                    <a href="" class="pota01-show__footer__share ms-auto">Compartilhar Artigo</a>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="pota01-home__adverts pota01-home__adverts--blogInner">
                            <div class="pota01-home__adverts__item pota01-home__adverts__item--advertiseHere">
                                <a href="#" class="link-full"></a>
                                <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                            </div>
                        </div>
                        {{-- END .pota01-home__adverts --}}
                    </div>
                    <div class="col-6">
                        <div class="pota01-home__adverts pota01-home__adverts--blogInner">
                            <div class="pota01-home__adverts__item pota01-home__adverts__item--advertiseHere">
                                <a href="#" class="link-full"></a>
                                <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                            </div>
                        </div>
                        {{-- END .pota01-home__adverts --}}
                    </div>
                </div>
            </div>
            {{-- END .container --}}
        </section>
        {{-- END .pota01-show --}}
    </main>
    {{-- END #root --}}
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
