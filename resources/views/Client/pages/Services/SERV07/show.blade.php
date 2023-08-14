@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

<div class="serv07-show-banner">
    <header class="serv07-show-banner__header"style="background-image: url({{ asset('storage/' . $service->category->path_image_desktop) }}); background-color: {{$service->category->background_color}};">
        <div class="container d-flex flex-column align-items-center">
            @if ($service->category->title_banner)
                <h1 class="serv07-show-banner__title">{{$service->category->title_banner}}</h1>
            @endif
        </div>
    </header>
</div>

<section class="serv07-show">
    <main>
        <div class="serv07-show__contentTitle">
            <div class="serv07-show__contentTitle__container container">
                <div class="serv07-show__contentTitle__wrap">
                    <div class="row">
                        <div class="col-12 col-md-6"></div>
                        <div class="col-12 col-md-6 serv07-show__contentTitle__sideRight">
                            @if ($service->title || $service->subtitle)
                                <h1 class="serv07-show__contentTitle__title">{{$service->title}}</h1>
                                <h3 class="serv07-show__contentTitle__subtitle">{{$service->subtitle}}</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="serv07-show__info">
            <div class="serv07-show__info__container container">
                <div class="row">
                    <div class="col-12 col-md-6 serv07-show__info__gallery">
                        <div id="receiveGallery">
                            <div class="serv07-show__info__gallery__wrap">
                                @if ($service->path_image)
                                    <img src="{{ asset('storage/' . $service->path_image) }}" width="100%" class="serv07-show__info__gallery__imgMain" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 serv07-show__info__description">
                        @if ($service->text)
                            <p>{!! $service->text !!}</p>
                        @endif
                        @if ($service->link_button)
                            <a href="{{$service->link_button}}" target="{{$service->target_link_button}}" class="serv07-show__info__description__cta">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" width="31px" class="me-2" alt="">
                                @if ($service->title_button)
                                    {{$service->title_button}}
                                @endif
                            </a>
                        @endif
                    </div>
                </div>
                @if ($galleries->count())
                    <div class="serv07-show__info__gallery__carousel" style="margin-top: 78px;">
                        @foreach ($galleries as $gallery)
                            <img src="{{ asset('storage/' . $gallery->path_image) }}" class="serv07-show__info__gallery__thumbnail" alt="">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
</section>


<div class="serv07-show-section__content__product container">
    <header class="header-topic">
        <h3 class="container-title">
            <span class="title">{{$service->category->title}}</span>
        </h3>
        <hr class="line">
    </header>
    @if ($services->count())
        <div class="row serv07-show-section__content--row carousel-serv07-show-section-product">
            @foreach ($services as $service)
                <article class="serv07-show-section__content__product__item col-md-3">
                    <div class="serv07-show-section__content__product__item__image">
                        @if ($service->path_image_box)
                            <img src="{{ asset('storage/' . $service->path_image_box) }}" class="w-100 h-100" alt="Titulo Topico">
                        @endif
                    </div>
                    <div class="serv07-show-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                        <div class="serv07-show-section__content__product__item__description__encompass">
                            <div class="flex-column serv07-show-section__content__product__item__description__encompass__txt">
                                @if ($service->title)
                                    <h2 class="serv07-show-section__content__product__item__description__encompass__txt__title mx-0 px-0">{{$service->title}}</h2>
                                @endif
                            </div>
                        </div>
                        <div class="serv07-show-section__content__product__item__description_paragraph text-start px-0 ">
                            @if ($service->description)
                                <p>
                                    {!! $service->description !!}
                                </p>
                            @endif
                        </div>
                        <div class="serv07-show-section__content__product__item__description__buttons">
                            <a rel="next" href="{{route('serv07.page.content', ['SERV07Services' => $service->slug])}}" class="serv07-show-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__product__item__description__buttons__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
    <a href="{{route('serv07.category.page', ['SERV07ServicesCategory' =>$service->category->slug])}}" class="serv07-show-section__content__cta">
        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__cta__icon">
        CTA
    </a>
</div>


{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
