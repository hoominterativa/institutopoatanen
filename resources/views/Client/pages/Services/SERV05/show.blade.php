@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="serv05-show__header w-100">
        <div class="serv05-banner-carousel owl-carousel w-100">
            <div class="serv05-banner-carousel__item" style="background-image: url({{ asset('storage/' . $service->path_image_desktop) }});  background-color: #ffffff;">
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    @if ($service->title_banner || $service->subtitle_banner)
                        <h3 class="serv05-banner-carousel__title text-center">{{$service->title_banner}}</h3>
                        <h4 class="serv05-banner-carousel__subtitle text-center">{{$service->subtitle_banner}}</h4>
                        <hr class="serv05-banner-carousel__line">
                    @endif
                </div>
            </div>
        </div>
        <div class="serv05-top w-100">
            <div class="container d-flex flex-column align-items-center justify-content-center">
                @if ($service->title_about || $service->subtitle_about )
                    <h1 class="serv05-top__title text-center">{{$service->title_about}}</h1>
                    <h2 class="serv05-top__subtitle text-center">{{$service->subtitle_about}}</h2>
                    <hr class="serv05-top__line">
                @endif
                <div class="serv05-top__desc">
                    @if ($service->description)
                        <p>
                            {!! $service->description !!}
                        </p>
                    @endif
                </div>
                <ul class="serv05-show__nav w-100">
                    @foreach ($contents as $content)
                        <li class="serv05-show__nav__item">
                            <a href="#sec-{{ $content->slug }}">
                                @if ($content->path_image_icon)
                                    <img src="{{ asset('storage/' . $content->path_image_icon) }}" alt="" class="serv05-show__nav__item__icon">
                                @endif
                                @if ($content->section)
                                    {{$content->section}}
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    @foreach ($contents as $content)
        <article id="sec-{{ $content->slug }}" class="serv05-show__item w-100">
            @if ($content->path_image)
                <img src="{{ asset('storage/' . $content->path_image) }}" alt="" class="serv05-show__item__image">
            @endif
            <div class="serv05-show__item__right">
                @if ($content->title || $content->subtitle)
                    <h4 class="serv05-show__item__subtitle">{{$content->subtitle}}</h4>
                    <h3 class="serv05-show__item__title">{{$content->title}}</h3>
                    <hr class="serv05-show__item__line">
                @endif
                <div class="serv05-show__item__text">
                    @if ($content->text)
                        <p>
                            {!! $content->text !!}
                        </p>
                    @endif
                </div>
            </div>
        </article>
    @endforeach
    <section class="serv05-show__topics">
        <div class="container d-flex flex-column align-items-streach">
            <header class="serv05-show__topics__header w-100 d-flex flex-column align-items-center">
                @if ($service->title_topic || $service->subtitle_topic)
                    <h4 class="serv05-show__topics__subtitle">{{$service->subtitle_topic}}</h4>
                    <h3 class="serv05-show__topics__title">{{$service->title_topic}}</h3>
                    <hr class="serv05-show__topics__line">
                @endif
            </header>
            <main class="serv05-show__topics__main w-100 d-flex flex-column align-items-stretch">
                <div class="serv05-show__topics__carousel w-100 owl-carousel">
                    @foreach ($topics as $topic)
                        <article class="serv05-show__topics__item" style="background-image: url({{ asset('storage/' . $topic->path_image) }}) ; background-color: #ffffff;">
                            <header class="serv05-show__topics__item__header w-100 d-flex flex-row align-items-center justify-content-start">
                                @if ($topic->path_image_icon)
                                    <img src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="" class="serv05-show__topics__item__icon">
                                @endif
                                <div class="serv05-show__topics__item__header__right d-flex flex-column align-items-start justify-content-center">
                                    @if ($topic->title || $topic->subtitle)
                                        <h3 class="serv05-show__topics__item__title">{{$topic->title}}</h3>
                                        <h4 class="serv05-show__topics__item__subtitle">{{$topic->subtitle}}</h4>
                                    @endif
                                </div>
                            </header>
                            <hr class="serv05-show__topics__item__line">
                            <div class="serv05-show__topics__item__desc">
                                @if ($topic->description)
                                    <p>
                                        {!! $topic->description !!}
                                    </p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
                    <a rel="next" href="{{$service->link_topic ? getUri($service->link_topic) : 'javascript:void(0)'}}" target="{{ $service->target_link }}" class="serv05-show__topics__cta">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv05-show__topics__cta__icon">
                        @if ($service->title_topic_button)
                            {{$service->title_topic_button}}
                        @endif
                    </a>
            </main>
        </div>
    </section>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
