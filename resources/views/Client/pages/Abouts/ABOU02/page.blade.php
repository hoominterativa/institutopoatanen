@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<div id="ABOU02" class="abou02-page">
    <section class="container-fluid px-0">
        @if ($section->active_banner)
            <header class="abou02-page__header" style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }}); background-color: {{ $section->background_color_banner }};">
                <div class="abou02-page__header__mask"></div>
                @if ($section->title_banner || $section->subtitle_banner)
                    <h2 class="container container--abou02-header d-block text-center">
                        <span class="abou02-page__header__title d-block">{{$section->title_banner}}</span>
                        <span class="abou02-page__header__subtitle d-block text-uppercase">{{$section->subtitle_banner}}</span>
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
    @if ($topics->count())
        <section class="abou02-page__topic container-fluid px-0" style="background-image: url({{asset('storage/uploads/tmp/bg-section-dark-gray.jpg')}})">
            <div class="container container--abou02-page__topic">
                @if ($section->active_topic)
                    <h2 class="abou02-page__topic__encompass d-block text-center">
                        @if ($section->title_topics || $section->subtitle_topics)
                            <span class="abou02-page__topic__encompass__title d-block">{{$section->title_topics}}</span>
                            <span class="abou02-page__topic__encompass__subtitle mb-0 d-block">{{$section->subtitle_topics}}</span>
                            <hr class="abou02-page__topic__encompass__line">
                        @endif
                    </h2>
                @endif
                {{-- END .abou02-page__topic__encompass --}}
                <div class="abou02-page__topic__content">
                    <div class="carousel-abou02-topic owl-carousel">
                        @foreach ($topics as $topic )
                            <article class="abou02-page__topic__item w-100">
                                <a rel="next" href="" data-fancybox="{{$topic->title}}" data-src="#lightbox-abou02-{{$topic->id}}">
                                    <div class="abou02-page__topic__item_content transition w-100 h-100">
                                        <div class="abou02-page__topic__header position-relative w-100 h-100">
                                            @if ($topic->path_image_box)
                                                <div class="abou02-page__topic__image w-100 h-100">
                                                    <img src="{{asset('storage/' . $topic->path_image_box)}}" class="w-100 h-100" alt="Titulo Topico">
                                                </div>
                                            @endif
                                            <div class="abou02-page__topic__description text-center flex-column w-100 h-100 position-absolute d-flex justify-content-end align-items-center">
                                                @if ($topic->title_box)
                                                    <h3 class="abou02-page__topic__title">{{$topic->title_box}}</h3>
                                                @endif
                                                @if ($topic->description_box)
                                                    <div class="abou02-page__topic__paragraph">
                                                        <p>{!! $topic->description_box !!}</p>
                                                    </div>
                                                @endif
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
    @if ($section->active_content)
        <section class="abou02-page__section container-fluid px-0">
            <div class="container container--abou02-page__section">
                <div class="row abou02-page__section__row align-items-center">
                    @if ($section->path_image_content)
                        <div class="abou02-page__section__image col-12 col-md-5 m-0">
                            <img class="w-100 h-100" src="{{asset('storage/' . $section->path_image_content)}}"  width="430" alt="Titulo">
                        </div>
                    @endif
                    <div class="col-12 col-md-7 abou02-page__section__description">
                        @if ($section->title_content||$section->subtitle_content)
                            <h2 class="abou02-page__section__encompass_title d-block">
                                <span class="abou02-page__section__title d-block">{{$section->title_content}}</span>
                                <span class="abou02-page__section__subtitle d-block">{{$section->subtitle_content}}</span>
                                <hr class="abou02-page__section__line">
                            </h2>
                        @endif
                        @if ($section->description_content)
                            <div class="abou02-page__section__paragraph">
                                <p>
                                    {!! $section->description_content !!}
                                </p>
                            </div>
                        @endif
                        @if ($section->link_button_content)
                            <a href="{{ $section->link_button_content ? getUri($section->link_button_content) : 'javascript:void(0)' }}" target="{{ $section->target_link_button_content }}" class="abou02-page__section__cta transition justify-content-center align-items-center ms-auto">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="abou02-page__section__cta__icon me-3 transition">
                                @if ($section->title_button_content)
                                    {{$section->title_button_content}}
                                @endif
                            </a>
                        @endif
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
