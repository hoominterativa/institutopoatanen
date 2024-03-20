@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <section class="serv05-show__header w-100">
        @if ($service->active_banner == 1)
            <div class="serv05-banner-carousel owl-carousel w-100">
                <div class="serv05-banner-carousel__item"
                    style="background-image: url({{ asset('storage/' . ($service->path_image_desktop ? $service->path_image_desktop : $banner->path_image_desktop_banner)) }});">
                    <div class="container d-flex flex-column align-items-center justify-content-center">
                        @if ($service->title_banner || $service->subtitle_banner)
                            <h3 class="serv05-banner-carousel__title text-center">{{$service->title_banner}}</h3>
                            <h4 class="serv05-banner-carousel__subtitle text-center">{{$service->subtitle_banner}}</h4>
                            <hr class="serv05-banner-carousel__line">
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="serv05-top w-100">
            <div class="container d-flex flex-column align-items-center justify-content-center">
                @if ($service->active_about_inner == 1)
                    @if ($service->title_about_inner || $service->subtitle_about_inner )
                        <h1 class="serv05-top__title text-center">{{$service->title_about_inner}}</h1>
                        <h2 class="serv05-top__subtitle text-center">{{$service->subtitle_about_inner}}</h2>
                        <hr class="serv05-top__line">
                    @endif
                    <div class="serv05-top__desc">
                        @if ($service->description_about_inner)
                            <p>
                                {!! $service->description_about_inner !!}
                            </p>
                        @endif
                    </div>
                @endif
                @if ($contents->count())
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
                @endif
            </div>
        </div>
    </section>
    @if ($contents->count())
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
    @endif
    @if ($topics->count())
        <section class="serv05-show__topics">
            <div class="container d-flex flex-column align-items-streach">
                @if ($service->active_topic == 1)
                    @if ($service->title_topic || $service->subtitle_topic)
                        <header class="serv05-show__topics__header w-100 d-flex flex-column align-items-center">
                            <h4 class="serv05-show__topics__subtitle">{{$service->subtitle_topic}}</h4>
                            <h3 class="serv05-show__topics__title">{{$service->title_topic}}</h3>
                            <hr class="serv05-show__topics__line">
                        </header>
                    @endif
                @endif
                <main class="serv05-show__topics__main w-100 d-flex flex-column align-items-stretch">
                    <div class="serv05-show__topics__carousel w-100 owl-carousel">
                        @foreach ($topics as $topic)
                            <article class="serv05-show__topics__item" style="background-image: url({{ asset('storage/' . $topic->path_image) }});">
                                <header class="serv05-show__topics__item__header w-100 d-flex flex-row align-items-center justify-content-start">
                                    @if ($topic->path_image_icon)
                                        <img src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="" class="serv05-show__topics__item__icon">
                                    @endif
                                    @if ($topic->title || $topic->subtitle)
                                        <div class="serv05-show__topics__item__header__right d-flex flex-column align-items-start justify-content-center">
                                            <h3 class="serv05-show__topics__item__title">{{$topic->title}}</h3>
                                            <h4 class="serv05-show__topics__item__subtitle">{{$topic->subtitle}}</h4>
                                        </div>
                                    @endif
                                </header>
                                <hr class="serv05-show__topics__item__line">
                                @if ($topic->description)
                                    <div class="serv05-show__topics__item__desc">
                                        <p>
                                            {!! $topic->description !!}
                                        </p>
                                    </div>
                                @endif
                            </article>
                        @endforeach
                    </div>
                    @if ($service->active_topic == 1)
                        <a rel="next" href="{{$service->link_topic ? getUri($service->link_topic) : '#'}}" target="{{$service->link_topic ? $service->target_link : '' }}" class="serv05-show__topics__cta">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv05-show__topics__cta__icon">
                            @if ($service->title_topic_button)
                                {{$service->title_topic_button}}
                            @endif
                        </a>
                    @endif
                </main>
            </div>
        </section>
    @endif
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
