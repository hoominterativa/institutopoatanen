@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <div id="abou05-page" class="abou05-page">
        <section class="container-fluid px-0">
            @if ($section)
                <header class="abou05-page__header"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }}); background-color: {{$section->background_color_banner}};">
                    <div class="container container--abou05-header d-flex flex-column justify-content-center align-items-center">
                        <h3 class="abou05-page__header__container d-flex flex-column justify-content-center align-items-center">
                            <span class="abou05-page__header__title">{{$section->title_banner}}</span>
                            <span class="abou05-page__header__subtitle">{{$section->subtitle_banner}}</span>
                        </h3>
                        <hr class="abou05-page__header__line">
                    </div>
                </header>
            @endif
            @if ($about)
                <div class="container">
                    <div class="abou05-page__content  d-flex flex-column justify-content-center align-items-center">
                        @if ($about->title || $about->subtitle)
                            <h2 class="abou05-page__content__encompass d-flex flex-column justify-content-center align-items-center">
                                <span class="abou05-page__content__title">{{$about->title}}</span>
                                <span class="abou05-page__content__subtitle">{{$about->subtitle}}</span>
                            </h2>
                            <hr class="abou05-page__content__line">
                        @endif
                        <div class="abou05-page__content__paragraph">
                            <p>
                                {!! $about->text !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </section>
        {{-- END .abou05-page__content --}}
        @if ($contents->count())
            <section class="abou05-page__section container-fluid px-0">
                <div class="container container--abou05-page__section">
                    <div class="row abou05-page__section__row align-items-center">
                        <div class="abou05-page__section__box d-flex flex-column">
                            <div class="abou05-page__section__box__encompass">
                                <div class="container">
                                    @if ($section)
                                        <h4 class="abou05-page__section__box__encompass__title">{{$section->title_content}}</h4>
                                        <h5 class="abou05-page__section__box__encompass__subtitle">{{$section->subtitle_content}}</h5>
                                        <hr class="abou05-page__section__box__encompass__line">
                                    @endif
                                </div>
                            </div>
                            @foreach($contents as $content)
                                <div class="abou05-page__section__box__content w-100 d-flex justify-content-center">
                                    <div class="container px-0 d-flex justify-content-between">
                                    <div class="abou05-page__section__box__image">
                                        @if ($content->path_image)
                                            <img class="w-100 h-100" src="{{asset('storage/' . $content->path_image)}}"  width="430" alt="Titulo">
                                        @endif
                                    </div>
                                    <div class="abou05-page__section__box__description">
                                            <h2 class="abou05-page__section__box__description__encompass d-block">
                                                @if ($content->title || $content->subtitle)
                                                    <span class="abou05-page__section__box__description__encompass__title d-block">{{$content->title}}</span>
                                                    <span class="abou05-page__section__box__description__encompass__subtitle d-block">{{$content->subtitle}}</span>
                                                    <hr class="abou05-page__section__box__description__encompass__line">
                                                @endif
                                            </h2>
                                            <div class="abou05-page__section__box__description__paragraph">
                                                <p>
                                                    {!! $content->text !!}
                                                </p>
                                            </div>
                                            <a href="#lightbox-abou05-{{$content->id}}" data-fancybox class="abou05-page__section__box__description__cta transition justify-content-center align-items-center ms-auto">
                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="abou05-page__section__cta__icon me-3 transition">
                                                CTA
                                            </a>
                                    </div>
                                        @include('Client.pages.Abouts.ABOU05.show',[
                                            'content' => $content,
                                        ])
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- END .abou05-page__section__box --}}
                    </div>
                </div>
            </section>
        @endif
        {{-- END .abou05-page__section --}}

    </div>
    {{-- END .abou05-page --}}
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
