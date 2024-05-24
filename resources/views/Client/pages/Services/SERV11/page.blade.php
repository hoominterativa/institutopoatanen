@extends('Client.Core.client')
@section('content')
    <main id="root" class="serv11-page">
        @if ($banner)
            @if ($banner->title_banner || $banner->subtitle_banner)
                <section class="serv11-page__banner" style="background-image: url({{ asset('storage/'.$banner->path_image_desktop) }});">
                    @if ($banner->title_banner)
                        <h1 class="serv11-page__banner__title">{{$banner->title_banner}}</h1>
                    @endif
                    @if ($banner->subtitle_banner)
                        <h2 class="serv11-page__banner__subtitle">{{$banner->subtitle_banner}}</h2>
                    @endif
                </section>
            @endif
        @endif
        @if ($sessions->count())
            @foreach ($sessions as $session)
                <div class="serv11-page__section-service">
                    @if ($session->title || $session->subtitle)
                        <header class="serv11-page__section-service__header">
                            @if ($session->subtitle)
                                <h4 class="serv11-page__section-service__header__subtitle">{{$session->subtitle}}</h4>
                            @endif
                            @if ($session->title)
                                <h3 class="serv11-page__section-service__header__title">{{$session->title}}</h3>
                            @endif
                        </header>
                    @endif
                    @if ($session->services->count())
                        <div class="serv11-page__section-service__list">
                            @foreach ($session->services as $service)
                                <article class="serv11-page__section-service__list__item" data-fancybox data-src='#M{{$service->id}}'>
                                    @if ($service->path_image_icon)
                                        <img src="{{asset('storage/'.$service->path_image_icon)}}" loading="lazy" class="serv11-page__section-service__list__item__icon" alt="Ícone do {{$service->title}}">
                                    @endif
                                    @if ($service->title)
                                        <h3 class="serv11-page__section-service__list__item__title">{{$service->title}}</h3>
                                    @endif
                                    @if ($service->description)
                                        <p class="serv11-page__section-service__list__item__paragraph">
                                            {!! $service->description !!}
                                        </p>
                                    @endif
                                    @include('Client.pages.Services.SERV11.show')
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
