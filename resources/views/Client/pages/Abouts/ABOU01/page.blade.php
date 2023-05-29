@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root">
        <div id="ABOU01" class="abou01-page">
            <section class="container-fluid px-0">
                <header class="abou01-page__header" style="background-image: url({{asset('storage/'.$about->path_image_banner)}})">
                    <div class="container d-flex flex-column justify-content-center align-items-center">
                        <h3 class="abou01-page__header__container">
                            <span class="abou01-page__header__title">{{$about->title_banner}}</span>
                            <span class="abou01-page__header__subtitle">{{$about->subtitle_banner}}</span>
                        </h3>
                        <hr class="abou01-page__header__line">
                    </div>
                </header>

                <div class="container">
                    <div class="abou01-page__content">
                        <h2 class="abou01-page__content__container">
                            <span class="abou01-page__content__title">{{$about->title}}</span>
                            <span class="abou01-page__content__subtitle">{{$about->subtitle}}</span>
                        </h2>
                        <hr class="abou01-page__content__line">
                        <div class="abou01-page__content__paragraph">
                            {!!$about->text!!}
                        </div>
                    </div>
                </div>
            </section>
            {{-- END .abou01-page__content --}}

            <section class="abou01-page__topic container-fluid" style="background-image: url({{asset('storage/uploads/tmp/bg-section-dark-gray.jpg')}})">
                <div class="container">
                    <div class="row carousel-abou01-topic">
                        @foreach ($about->topics as $topic)
                            <article class="abou01-page__topic__item col-12 col-lg-4">
                                <div class="abou01-page__topic__content transition">
                                    <div class="abou01-page__topic__item__header d-flex align-items-center">
                                        @if ($topic->path_image_icon)
                                            <img src="{{asset('storage/'.$topic->path_image_icon)}}" width="32" class="abou01-page__topic__item__icon" alt="{{$topic->title}}">
                                        @endif
                                        <h3 class="abou01-page__topic__item__title">{{$topic->title}}</h3>
                                    </div>
                                    <p class="abou01-page__topic__item__paragraph">{!! $topic->description !!}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
            {{-- END .abou01-page__topic --}}

            <section class="abou01-page__section container-fluid">
                <div class="container">
                    <div class="row abou01-page__section__row align-items-center">
                        <div class="abou01-page__section__image col-12 col-lg-5">
                            @if ($about->path_image_inner_section)
                                <img src="{{asset('storage/'.$about->path_image_inner_section)}}" class="abou01-page__section__image__item" width="430" alt="{{$about->title_inner_section}}">
                            @endif
                        </div>
                        <div class="col-12 col-lg-7">
                            <h2 class="abou01-page__section__container">
                                <span class="abou01-page__section__title">{{$about->title_inner_section}}</span>
                                <span class="abou01-page__section__subtitle">{{$about->subtitle_inner_section}}</span>
                            </h2>
                            <hr class="abou01-page__section__line">
                            <p class="abou01-page__section__paragraph">{!!$about->text_inner_section !!}</p>
                        </div>
                    </div>
                </div>
            </section>
            {{-- END .abou01-page__section --}}
        </div>
        {{-- END .abou01-page --}}
    </main>
    {{-- Finish Content page Here --}}

    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach

@endsection
