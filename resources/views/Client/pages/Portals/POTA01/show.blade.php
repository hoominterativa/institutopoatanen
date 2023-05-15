@extends('Client.Core.client')
@section('content')
    <main id="root">
        <section id="POTA01" class="pota01-show container-fluid">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="pota01-show__col-start col-12 col-sm-8">
                        <article itemscope itemtype="http://schema.org/Article" class="pota01-show__item">
                            <h1 itemprop="name" class="pota01-show__item__title">{{$portal->title}}</h1>
                            <span class="pota01-show__item__published">
                                Data: <span itemprop="datePublished" content="{{$portal->publishing}}" class="pota01-show__item__date">{{Carbon\Carbon::parse($portal->publishing)->formatLocalized('%d de %B de %Y')}}</span>
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
                            {{-- <a href="" class="pota01-show__related__share">Compartilhar Artigo</a> --}}
                            <h4 class="pota01-show__related__title">Artigos Relacionados</h4>
                            @foreach ($portalsRelated as $portalRelated)
                                <article class="pota01-show__boxs__item">
                                    <div itemscope itemtype="http://schema.org/Article" class="pota01-show__boxs__item__content transition">
                                        <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portalRelated->category->slug, 'POTA01Portals' => $portalRelated->slug])}}">
                                            <figure class="pota01-show__boxs__item__image">
                                                <img itemprop="image" src="{{asset('storage/'.$portalRelated->path_image_thumbnail)}}" class="pota01-show__boxs__item__image__img" width="100%" alt="{{$portalRelated->title}}"/>
                                            </figure>
                                            <div class="pota01-show__boxs__item__description">
                                                <span class="pota01-show__boxs__item__date-publish">
                                                    Data: <span itemprop="datePublished" content="{{$portalRelated->publishing}}" class="pota01-show__boxs__item__date">{{Carbon\Carbon::parse($portalRelated->publishing)->formatLocalized('%d de %B de %Y')}}</span>
                                                </span>
                                                <h3 itemprop="name" class="pota01-show__boxs__item__title">{{$portalRelated->title}}</h3>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p itemprop="articleBody" class="pota01-show__boxs__item__paragraph">{{$portalRelated->description}}</p>
                                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="pota01-show__boxs__item__icon ms-3" alt="{{$portalRelated->title}}"/>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                            {{-- END .pota01-page__boxs__item --}}
                        </div>
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
