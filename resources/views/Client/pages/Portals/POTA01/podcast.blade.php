@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <section id="POTA01" class="pota01-podcast container-fluid px-0">
        <header class="pota01-podcast__header">
            <div class="container d-flex align-items-center h-100">
                <h1 class="pota01-podcast__header__title">Podcast</h1>
            </div>
        </header>
        <div class="container">
            <div class="row">
                <div class="pota01-podcast__start col-12 col-md-8">
                    <div class="pota01-podcast__podcast__tracks">
                        @foreach ($podcasts as $podcast)
                            <article class="pota01-podcast__podcast__item">
                                <div class="pota01-podcast__podcast__item__content">
                                    @if ($podcast->path_image_thumbnail)
                                        <div class="pota01-podcast__podcast__item__image">
                                            <img src="{{asset('storage/'.$podcast->path_image_thumbnail)}}" class="pota01-podcast__podcast__item__image__img" alt="">
                                        </div>
                                    @endif
                                    <div class="pota01-podcast__podcast__item__description" {{!$podcast->path_image_thumbnail?'style=width:100%;':''}}>
                                        @if ($podcast->title)
                                            <h2 class="pota01-podcast__podcast__item__title">{{$podcast->title}}</h2>
                                        @endif
                                        @if ($podcast->duration)
                                            <span class="pota01-podcast__podcast__item__duration">Duração: {{$podcast->duration}}min</span>
                                        @endif
                                        @if ($podcast->publishing)
                                            <span class="pota01-podcast__podcast__item__publish">{{dateFormat($podcast->publishing, 'd', 'M', 'Y', '')}}</span>
                                        @endif
                                        @if ($podcast->description)
                                        <div class="pota01-podcast__podcast__item__paragraph">
                                            {!! $podcast->description !!}
                                        </div>
                                        @endif
                                        @if ($podcast->embed)
                                            <div class="mt-3">
                                                {!! $podcast->embed !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="pota01-podcast__end col-12 col-md-4">
                    <div class="pota01-home__adverts pota01-home__adverts--podcastBeforeArticle">
                        <div class="pota01-home__adverts__item pota01-home__adverts__item--advertiseHere">
                            <a href="#" class="link-full"></a>
                            <h5 class="pota01-home__adverts__item__title">Anúncie aqui</h5>
                        </div>
                    </div>
                    {{-- END .pota01-home__adverts --}}

                    <div class="pota01-show__related">
                        <h4 class="pota01-show__related__title">Ultimos Artigos</h4>
                        @foreach ($portals as $portal)
                            <article class="pota01-show__boxs__item col-12">
                                <div itemscope itemtype="http://schema.org/Article" class="pota01-show__boxs__item__content transition">
                                    <a itemprop="url" href="{{route('pota01.show.content', ['POTA01PortalsCategory' => $portal->category->slug, 'POTA01Portals' => $portal->slug])}}">
                                        <figure class="pota01-show__boxs__item__image mb-0">
                                            <img itemprop="image" src="{{asset('storage/'.$portal->path_image_thumbnail)}}" class="pota01-show__boxs__item__image__img" width="100%" alt="{{$portal->title}}"/>
                                        </figure>
                                        <div class="pota01-show__boxs__item__description">
                                            <span class="pota01-show__boxs__item__publish">{{dateFormat($portal->publishing, 'd', 'M', 'Y', '')}}</span>
                                            <h2 itemprop="name" class="pota01-show__boxs__item__title">{{$portal->title}}</h2>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                        {{-- END .pota01-page__boxs__item --}}
                    </div>

                    <div class="pota01-home__adverts pota01-home__adverts--podcastAfterArticle">
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
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
