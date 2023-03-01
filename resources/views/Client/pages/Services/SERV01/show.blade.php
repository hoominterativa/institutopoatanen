@extends('Client.Core.client')
@section('content')
    <main id="root">
        <section id="SERV01" class="serv01-show container-fluid">
            <header class="serv01-show__header" style="background-image: url({{asset('storage/'.$service->path_image_banner)}})">
                <div class="container">
                    <h2 class="serv01-show__header__title">Título Banner</h2>
                    <nav class="serv01-show__header__links carousel-serv01-show__links d-flex align-items-center justify-content-center">
                        @foreach ($services as $serviceGet)
                            <a href="{{route('serv01.show', ['SERV01Services' => $serviceGet->slug])}}" class="serv01-show__header__link-item {{$serviceGet->id==$service->id?'serv01-show__header__link-item--active':''}}">{{$serviceGet->title}}</a>
                        @endforeach
                    </nav>
                </div>
            </header>
            {{-- END .serv01-show__header --}}

            <div class="container serv01-show__content">
                <div class="serv01-show__content__info">
                    <img src="{{asset('storage/'.$service->path_image_icon)}}" width="36px" class="serv01-show__content__icon" alt="Título Subtítulo">
                    <h1>
                        <span class="serv01-show__content__subtitle">{{$service->subtitle}}</span>
                        <span class="serv01-show__content__title">{{$service->title}}</span>
                    </h1>
                    <a href="#" class="serv01-show__content__info__link">
                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="26px" class="serv01-show__content__link_icon" alt="">
                    </a>
                </div>
                <hr class="serv01-show__content__line">
                <div class="serv01-show__content__description">
                    {!!$service->text!!}
                </div>
            </div>
            {{-- END .serv01-show__content --}}
            @if ($service->advantages->count())
                <div class="serv01-show__topics">
                    <div class="container">
                        @if ($service->advantagesSection)
                            <header class="serv01-show__topics__header">
                                <h3 class="serv01-show__topics__header__container">
                                    <span class="serv01-show__topics__header__title">{{$service->advantagesSection->title}}</span>
                                    <span class="serv01-show__topics__header__subtitle">{{$service->advantagesSection->subtitle}}</span>
                                </h3>
                                <hr class="serv01-show__topics__header__line">
                                <p class="serv01-show__topics__header__paragraph">{{$service->advantagesSection->description}}</p>
                            </header>
                        @endif
                        <div class="serv01-show__topics__container-box carousel-serv01-show__topics row">
                            @foreach ($service->advantages as $advantage)
                                <article class="serv01-show__topics__container-box__item col-12 col-sm-4 col-lg-3">
                                    <div class="content transition">
                                        @if ($advantage->path_image)
                                            <img src="{{asset('storage/'.$advantage->path_image)}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                        @endif
                                        <div class="serv01-show__topics__container-box__info d-flex flex-column justify-content-center align-items-center">
                                            @if ($advantage->path_image_icon)
                                                <figure class="serv01-show__topics__container-box__image">
                                                    <img src="{{asset('storage/'.$advantage->path_image_icon)}}" class="icon" width="50px" alt="">
                                                </figure>
                                            @endif
                                            <div class="serv01-show__topics__container-box__description">
                                                <h3 class="serv01-show__topics__container-box__title">{{$advantage->title}}</h3>
                                                <p class="serv01-show__topics__container-box__paragraph mx-auto">{{$advantage->description}}</p>
                                            </div>
                                        </div>
                                        <div class="serv01-show__topics__container-box__hover d-flex flex-column justify-content-center align-items-center">
                                            <h4 class="serv01-show__topics__container-box__hover__title">{{$advantage->title}}</h4>
                                            <div class="serv01-show__topics__container-box__hover__paragraph mx-auto">{!!$advantage->text!!}</div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                            {{-- END .box-service --}}
                        </div>
                        {{-- END .serv01-show__topics__container-box --}}
                    </div>
                    {{-- END .container --}}
                </div>
                {{-- END .serv01-show__topics --}}
            @endif

            @if ($service->portfolios->count())
                <div class="serv01-show__portfolios">
                    <div class="container">
                        @if ($service->portfolioSection??false)
                            @if ($service->portfolioSection->active)
                                <header class="serv01-show__portfolios__header">
                                    <h3 class="serv01-show__portfolios__header__container">
                                        <span class="serv01-show__portfolios__header__title">{{$service->portfolioSection->title}}</span>
                                        <span class="serv01-show__portfolios__header__subtitle">{{$service->portfolioSection->subtitle}}</span>
                                    </h3>
                                    <hr class="serv01-show__portfolios__header__line">
                                    <p class="serv01-show__portfolios__header__paragraph">{{$service->portfolioSection->description}}</p>
                                </header>
                            @endif
                        @endif
                        <div class="serv01-show__portfolios__container-box carousel-serv01-show__portfolios row">
                            @foreach ($service->portfolios as $portfolio)
                                <article class="serv01-show__portfolios__container-box__item col">
                                    <div class="content transition">
                                        @if ($portfolio->path_image)
                                            <img src="{{asset('storage/'.$portfolio->path_image)}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="{{$portfolio->title}}">
                                        @endif
                                        @if (!$portfolio->text)
                                            @if (isset($portfolio->gallery[0]))
                                                <a href="{{asset('storage/'.$portfolio->gallery[0]->path_image)}}" {{$portfolio->gallery[0]->legend?'data-caption='.$portfolio->gallery[0]->legend:''}} data-fancybox="{{Str::slug($service->title.' '.$portfolio->title)}}">
                                            @endif
                                        @else
                                            <a href="#serv01-show__portfolios__lightbox-{{$portfolio->id}}" data-fancybox="{{Str::slug($service->title.' '.$portfolio->title)}}">
                                        @endif
                                            <div class="serv01-show__portfolios__container-box__info d-flex flex-column justify-content-end">
                                                <div class="serv01-show__portfolios__container-box__description">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-sm-8">
                                                            <h3 class="serv01-show__portfolios__container-box__title">{{$portfolio->title}}</h3>
                                                            <p class="serv01-show__portfolios__container-box__paragraph mx-auto">{{$portfolio->description}}</p>
                                                        </div>
                                                        <div class="col-12 col-sm-4">
                                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="icon mx-auto" width="36px" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @if ($portfolio->text)
                                            <div id="serv01-show__portfolios__lightbox-{{$portfolio->id}}" class="serv01-show__portfolios__lightbox" style="display: none;">
                                                <div class="row h-100">
                                                    @if ($portfolio->gallery->count())
                                                        <div class="col-12 col-sm-4">
                                                            <div class="serv01-show__portfolios__lightbox__carousel-image h-100">
                                                                @foreach ($portfolio->gallery as $key => $gallery)
                                                                    <figure class="mb-0">
                                                                        <img src="{{asset('storage/'.$gallery->path_image)}}" class="serv01-show__portfolios__lightbox__image" width="100%" height="100%" alt="{{$portfolio->title}}">
                                                                        @if ($gallery->legend)
                                                                            <figcaption class="serv01-show__portfolios__lightbox__image__legend">{{$gallery->legend}}</figcaption>
                                                                        @endif
                                                                    </figure>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-12 col-sm-8 h-100">
                                                        <div class="serv01-show__portfolios__lightbox__description">
                                                            <h3 class="serv01-show__portfolios__lightbox__title">{{$portfolio->title}}</h3>
                                                            <div class="serv01-show__portfolios__lightbox__paragraph">{!!$portfolio->text!!}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($portfolio->gallery as $key => $gallery)
                                                @if ($key!==0)
                                                    <a href="{{asset('storage/'.$gallery->path_image)}}" {{$gallery->legend?'data-caption='.$gallery->legend:''}} data-fancybox="{{Str::slug($service->title.' '.$portfolio->title)}}"></a>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                            {{-- END .box-service --}}
                        </div>
                        {{-- END .serv01-show__portfolios__container-box --}}
                    </div>
                    {{-- END .container --}}
                </div>
                {{-- END .serv01-show__portfolios --}}
            @endif
        </section>
        {{-- END #SERV01 --}}
    </main>
    {{-- END #root --}}
@endsection
