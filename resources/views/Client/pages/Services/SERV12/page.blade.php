@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="serv12-page">
        @if ($categorySelected->path_image_desktop_banner || $categorySelected->title_banner || $categorySelected->subtitle_banner)
            <section class="serv12-page__banner"
                style="background-image: url({{ asset('storage/' . $categorySelected->path_image_desktop_banner) }});">
                @if ($categorySelected->title_banner)
                    <h1 class="serv12-page__banner__title">{{$categorySelected->title_banner}}</h1>
                @endif
                @if ($categorySelected->subtitle_banner)
                    <h2 class="serv12-page__banner__subtitle">{{$categorySelected->subtitle_banner}}</h2>
                @endif
            </section>
        @endif
        @if ($categories->count())
            <aside class="serv12-page__categories">
                <menu class="serv12-page__categories__swiper-wrapper swiper-wrapper">
                    @foreach ($categories as $category)
                        <li class="serv12-page__categories__item swiper-slide {{$categorySelected->id == $category->id ? 'active' : ''}}">
                            <a href="{{route('serv12.category.page', ['SERV12ServicesCategory' => $category->slug])}}" class="link-full" title="categoria{{ $category->title }}"></a>
                            {{$category->title}}
                        </li>
                    @endforeach
                </menu>
            </aside>
            <section class="serv12-page__category-section">
                @if ($categorySelected->path_image)
                    <img src="{{ asset('storage/' . $categorySelected->path_image) }}" loading="lazy" alt="Imagem da categoria {{$categorySelected->title}}"
                        class="serv12-page__category-section__img">
                @endif
                <div class="serv12-page__category-section__information">
                    <h2 class="serv12-page__category-section__information__title">{{$categorySelected->title}}</h2>
                    @if ($categorySelected->text)
                        <div class="serv12-page__category-section__information__paragraph">
                            {!! $categorySelected->text !!}
                        </div>
                    @endif
                </div>
            </section>
        @endif
        @if ($services->count())
            <section class="serv12-page__services-section">
                <div class="serv12-page__services-section__carousel">
                    <div class="serv12-page__services-section__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($services as $service)
                            <div class="serv12-page__services-section__carousel__item swiper-slide">
                                <a href="{{route('serv12.category.page', ['SERV12ServicesCategory' => $service->category->slug, 'SERV12Services' => $service->slug])}}" class="link-full"></a>
                                @if ($service->path_image_icon)
                                    <img class="serv12-page__services-section__carousel__item__img"
                                        src="{{ asset('storage/' . $service->path_image_icon) }}" alt="Ícone do {{$service->title}}">
                                @endif
                                <h4 class="serv12-page__services-section__carousel__item__title">{{$service->title}}</h4>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if ($serviceSelected)
                    <div class="serv12-page__services-section__main">
                        @if ($serviceSelected->path_image)
                            <img src="{{ asset('storage/' . $serviceSelected->path_image) }}" alt="{{$serviceSelected->title}}"
                            class="serv12-page__services-section__main__img">
                        @endif
                        @if ($serviceSelected->title || $serviceSelected->subtitle || $serviceSelected->text)
                            <div class="serv12-page__services-section__main__information">
                                <h2 class="serv12-page__services-section__main__information__title">{{$serviceSelected->title}}</h2>
                                @if ($serviceSelected->subtitle)
                                    <h3 class="serv12-page__services-section__main__information__subtitle">{{$serviceSelected->subtitle}}</h3>
                                @endif
                                @if ($serviceSelected->text)
                                    <div class="serv12-page__services-section__main__information__paragraph">
                                        {!! $serviceSelected->text !!}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
                @if ($topics->count())
                    <div class="serv12-page__services-section__topics">
                        <div class="serv12-page__services-section__topics__swiper-wrapper swiper-wrapper">
                            @foreach ($topics as $topic)
                                <div class="serv12-page__services-section__topics__item swiper-slide" data-fancybox
                                    data-src='#M{{$topic->id}}'>
                                    @if ($topic->path_image_icon)
                                        <img class="serv12-page__services-section__topics__item__icon"
                                        src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="icone do tópico {{$topic->title}}">
                                    @endif
                                    @if ($topic->title)
                                        <h4 class="serv12-page__services-section__topics__item__title">{{$topic->title}}</h4>
                                    @endif
                                    @if ($topic->description)
                                        <p class="serv12-page__services-section__topics__item__paragraph">
                                            {!! $topic->description !!}
                                        </p>
                                    @endif
                                    @include('Client.pages.Services.SERV12.show')
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($video)
                    <div class="serv12-page__services-section__video" data-src="{{getUri($video->link)}}"
                        style="background-image: url({{ asset('storage/' . $video->path_image) }});">
                        <button class="serv12-page__services-section__video__button" title="Play">
                            <img class="serv12-page__services-section__video__button__icon"
                            src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                        </button>
                    </div>
                @endif
                @if ($galleries->count())
                    <div class="serv12-page__services-section__gallery">
                        @foreach ($galleries as $gallery)
                            <figure class="serv12-page__services-section__gallery__item">
                                @if ($gallery->path_image)
                                    <img class="serv12-page__services-section__gallery__item__img"
                                        src="{{ asset('storage/' . $gallery->path_image) }}">
                                @endif
                                @if ($gallery->description)
                                    <figcaption class="serv12-page__services-section__gallery__item__description">
                                        {!! $gallery->description !!}
                                    </figcaption>
                                @endif
                            </figure>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
    </main>

    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
