@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<div id="ABOU02" class="abou02-page">
    <section class="container-fluid px-0">
        @if ($banner)
            <header class="abou02-page__header" style="background-image: url({{ asset('storage/' . $banner->path_image_desktop) }}); background-color: {{ $banner->background_color }};">
                @if ($banner->title || $banner->subtitle)
                    <h2 class="container container--abou02-header d-block text-center">
                        <span class="abou02-page__header__title d-block">{{$banner->title}}</span>
                        <span class="abou02-page__header__subtitle d-block text-uppercase">{{$banner->subtitle}}</span>
                        <hr class="abou02-page__header__line mb-0">
                    </h2>
                @endif
            </header>
        @endif
        @if ($about)
            <div class="container container--abou02-page">
                <div class="abou02-page__content text-center">
                    @if ($about->title || $about->subtitle)
                        <h2 class="abou02-page__content__container d-block text-center">
                            <span class="abou02-page__content__subtitle d-block">{{$about->subtitle}}</span>
                            <span class="abou02-page__content__title mb-0 d-block">{{$about->title}}</span>
                            <hr class="abou02-page__content__line">
                        </h2>
                    @endif
                    {{-- END .abou02-page__content__container --}}
                    @if ($about->text)
                        <div class="abou02-page__content__paragraph">
                            <p>
                                {!! $about->text !!}
                            </p>
                        </div>
                    @endif
                    {{-- END .abou02-page__content__paragraph --}}
                </div>
            </div>
        @endif
    </section>
    {{-- END .abou02-page__content --}}
    @if ($about->topics)
        <section class="abou02-page__topic container-fluid px-0" style="background-image: url({{asset('storage/uploads/tmp/bg-section-dark-gray.jpg')}})">
            <div class="container container--abou02-page__topic">
                @if ($sectionTopic)
                    <h2 class="abou02-page__topic__encompass d-block text-center">
                        @if ($sectionTopic->title || $sectionTopic->subtitle)
                            <span class="abou02-page__topic__encompass__title d-block">{{$sectionTopic->title}}</span>
                            <span class="abou02-page__topic__encompass__subtitle mb-0 d-block">{{$sectionTopic->subtitle}}</span>
                            <hr class="abou02-page__topic__encompass__line">
                        @endif
                    </h2>
                @endif
                {{-- END .abou02-page__topic__encompass --}}
                <div class="abou02-page__topic__content">
                    <div class="carousel-abou02-topic owl-carousel">
                        @foreach ($about->topics as $topic )
                            <article class="abou02-page__topic__item w-100">
                                <a rel="next" href="" data-fancybox="{{$topic->title}}" data-src="#lightbox-abou02-1-{{$topic->id}}">
                                    <div class="abou02-page__topic__item_content transition w-100 h-100">
                                        <div class="abou02-page__topic__header position-relative w-100 h-100">
                                            @if ($topic->path_image)
                                                <div class="abou02-page__topic__image w-100 h-100">
                                                    <img src="{{asset('storage/' . $topic->path_image)}}" class="w-100 h-100" alt="Titulo Topico">
                                                </div>
                                            @endif
                                            <div class="abou02-page__topic__description text-center flex-column w-100 h-100 position-absolute d-flex justify-content-end align-items-center">
                                                @if ($topic->title)
                                                    <h3 class="abou02-page__topic__title">{{$topic->title}}</h3>
                                                @endif
                                                <div class="abou02-page__topic__paragraph">
                                                    @if ($topic->description)
                                                        <p>{!! $topic->description !!}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @include('Client.pages.Abouts.ABOU02.show', [
                                            'topic' => $topic,
                                        ])
                                    </div>
                                </a>
                            </article>
                        @endforeach
                        {{-- END .abou02-page__topic__item --}}
                    </div>
                </div>
                {{-- END .abou02-page__topic__content --}}
            </div>
        </section>
    @endif
    {{-- END .abou02-page__topic --}}
    @if ($lastSection)
        <section class="abou02-page__section container-fluid px-0">
            <div class="container container--abou02-page__section">
                <div class="row abou02-page__section__row align-items-center">
                    @if ($lastSection->path_image)
                        <div class="abou02-page__section__image col-12 col-md-5 m-0">
                            <img class="w-100 h-100" src="{{asset('storage/' . $lastSection->path_image)}}"  width="430" alt="Titulo">
                        </div>
                    @endif
                    <div class="col-12 col-md-7 abou02-page__section__description">
                        @if ($lastSection->title||$lastSection->subtitle)
                            <h2 class="abou02-page__section__encompass_title d-block">
                                <span class="abou02-page__section__title d-block">{{$lastSection->title}}</span>
                                <span class="abou02-page__section__subtitle d-block">{{$lastSection->subtitle}}</span>
                                <hr class="abou02-page__section__line">
                            </h2>
                        @endif
                        @if ($lastSection->description)
                            <div class="abou02-page__section__paragraph">
                                <p>
                                    {!! $lastSection->description !!}
                                </p>
                            </div>
                        @endif
                        <a href="{{ $lastSection->link_button ? getUri($lastSection->link_button) : 'javascript:void(0)' }}" target="{{ $lastSection->target_link_button }}" class="abou02-page__section__cta transition justify-content-center align-items-center ms-auto">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="abou02-page__section__cta__icon me-3 transition">
                            @if ($lastSection->title_button)
                                {{$lastSection->title_button}}
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- END .abou02-page__section --}}
</div>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
