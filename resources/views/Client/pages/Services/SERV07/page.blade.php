@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

@if ($section)
    <header class="serv07-page__header"style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{$section->background_color}};">
        <div class="container d-flex flex-column align-items-center">
            @if ($section->title_banner)
                <h1 class="serv07-page__title">{{$section->title_banner}}</h1>
            @endif
        </div>
    </header>
@endif
<div class="serv07-categories">
    <ul class="serv07-categories__list w-100">
        @foreach ($categories as $category)
            <li class="serv07-categories__list__item {{isset($category->selected) ? 'active':''}}">
                <a href="{{route('serv07.category.page', ['SERV07ServicesCategory' =>$category->slug])}}">
                    @if ($category->path_image_icon)
                        <img src="{{ asset('storage/' . $category->path_image_icon) }}" alt="" class="serv07-categories__list__item__icon">
                    @endif
                    {{$category->title}}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="serv07-categories__dropdown-mobile">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header serv07-categories__dropdown-mobile__item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-categories__dropdown-mobile__item__icon">
                        Categorias
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            @foreach ($categories as $category)
                                <li class="serv07-categories__dropdown-mobile__item">
                                    <a href="{{route('serv07.category.page', ['SERV07ServicesCategory' =>$category->slug])}}">
                                        @if ($category->path_image_icon)
                                            <img src="{{ asset('storage/' . $category->path_image_icon) }}" alt="" class="serv07-categories__dropdown-mobile__item__icon">
                                        @endif
                                        {{$category->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="serv07-topo container">
    @if ($categoryFirst)
        <div class="__description">
            <h2 class="serv07-topo__description d-block">
                @if ($categoryFirst->subtitle || $categoryFirst->title)
                    <span class="serv07-topo__description__subtitle d-block">{{$categoryFirst->subtitle}}</span>
                    <span class="serv07-topo__description__title d-block">{{$categoryFirst->title}}</span>
                    <hr class="serv07-topo__description__line">
                @endif
            </h2>
            <div class="serv07-topo__description__paragraph">
                @if ($categoryFirst->description)
                    <p>
                        {!! $categoryFirst->description !!}
                    </p>
                @endif
            </div>
        </div>
        <div class="__cta">
            @if ($categoryFirst->link_button)
                <a href="{{$categoryFirst->link_button}}" target="{{$categoryFirst->target_link_button}}" class="serv07-topo__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-topo__cta__icon">
                    @if ($categoryFirst->title_button)
                        {{$categoryFirst->title_button}}
                    @endif
                </a>
            @endif
        </div>
    @endif
</div>
@if ($sectionCategories->count())
    <section class="serv07-page__section container-fluid px-0">
        @foreach ($sectionCategories as $sectionCategory)
            <div class="container container--serv07-page__section">
                <div class="row serv07-page__section__row align-items-center">
                    <div class="serv07-page__section__image col-12 col-md-5 m-0">
                        @if ($sectionCategory->path_image)
                            <img class="w-100 h-100" src="{{ asset('storage/' . $sectionCategory->path_image) }}"  width="430" alt="Titulo">
                        @endif
                    </div>
                    <div class="col-12 col-md-7 serv07-page__section__description">
                        <h2 class="serv07-page__section__encompass_title d-block">
                            @if ($sectionCategory->title || $sectionCategory->subtitle)
                                <span class="serv07-page__section__title d-block">{{$sectionCategory->title}}</span>
                                <span class="serv07-page__section__subtitle d-block">{{ $sectionCategory->subtitle}}</span>
                                <hr class="serv07-page__section__line">
                            @endif
                        </h2>
                        <div class="serv07-page__section__paragraph">
                            @if ( $sectionCategory->description)
                                <p>
                                    {!! $sectionCategory->description !!}
                                </p>
                            @endif
                        </div>
                        @if ($sectionCategory->link_button)
                            <a href="{{$sectionCategory->link_button}}" target="{{$sectionCategory->target_link_button}}" class="serv07-page__section__cta transition justify-content-center align-items-center ms-auto">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="serv07-page__section__cta__icon me-3 transition">
                                @if ($sectionCategory->title_button)
                                    {{$sectionCategory->title_button}}
                                @endif
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endif
@if ($videos->count()|| $galleries->count(0))
<section id="serv07__gallery" class="serv07__gallery" style="">
    <div class="serv07__gallery container">
        @if ($videos->count())
            <div class="serv07__gallery__main">
                @foreach ($videos as $video)
                <div class="serv07__gallery__main__item">
                    <a class="link-full"
                        href="{{ getUri($video->link != '' ? $video->link : asset('storage/' . $video->path_image)) }}"
                        data-fancybox>
                    </a>
                    <img src="{{asset('storage/' . $video->path_image)}}" width="100%" height="100%" alt="Capa do Video">
                </div>
                @endforeach
            </div>
        @endif
        @if ($galleries->count(0))
        <div class="serv07__gallery__thumbnail">
            <div class="serv07__gallery__thumbnail__carousel">
                @foreach ($galleries as $gallery)
                <div class="serv07__gallery__thumbnail">
                    <a class="link-full"
                        href="{{asset('storage/' . $gallery->path_image)}}"
                        data-fancybox>
                    </a>
                    <img src="{{asset('storage/' . $gallery->path_image)}}" data-main-image="{{asset('storage/' . $gallery->path_image)}}" width="100%" class="" alt="">
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endif
<section id="SERV07" class="container-fluid" style="background-image: url(#);">
    <div class="container">
        @if ($categoryGet)
            <header class="header-topic">
                <h3 class="container-title">
                    @if ($categoryGet->category->title_topic || $categoryGet->category->subtitle_topic)
                        <span class="title">{{$categoryGet->category->title_topic}}</span>
                        <span class="subtitle">{{$categoryGet->category->subtitle_topic}}</span>
                        <hr class="line">
                    @endif
                </h3>
                @if ($categoryGet->category->description_topic)
                    <p class="paragraph">{!! $categoryGet->category->description_topic !!}</p>
                @endif
            </header>
        @endif
        @if ($topics->count())
            <div class="container-box row carousel-serv07">
                @foreach ($topics as $topic)
                    <article class="box-topic col">
                        <div class="content transition">
                            @if ($topic->path_image)
                                <img src="{{ asset('storage/' . $topic->path_image) }}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            @endif
                            <div class="container-info d-flex flex-column justify-content-center align-items-center">
                                <figure class="image">
                                    @if ($topic->path_image_icon)
                                        <img src="{{ asset('storage/' . $topic->path_image_icon) }}" class="icon" width="61" alt="">
                                    @endif
                                </figure>
                                <div class="description">
                                    @if ($topic->title)
                                        <h3 class="title">{{$topic->title}}</h3>
                                    @endif
                                    @if ($topic->description)
                                        <p class="paragraph">{!! $topic->description !!}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>


<!-- TEAM01 -->
<div class="serv07-page__content__product container">
    @if ($categoryGet)
        <header class="header-topic">
            <h3 class="container-title">
                @if ($categoryGet->category->title_service || $categoryGet->category->subtitle_service)
                    <span class="title">{{$categoryGet->category->title_service}}</span>
                    <span class="subtitle">{{$categoryGet->category->subtitle_service}}</span>
                    <hr class="line">
                @endif
            </h3>
            @if ($categoryGet->category->description_topic)
                <p class="paragraph">{!! $categoryGet->category->description_topic !!}</p>
            @endif
        </header>
    @endif
    @if ($services->count())
        <div class="row serv07-page__content--row carousel-serv07-product">
            @foreach ($services as $service)
                <article class="serv07-page__content__product__item col-md-3">
                    <div class="serv07-page__content__product__item__image">
                        @if ($service->path_image_box)
                            <img src="{{ asset('storage/' . $service->path_image_box) }}" class="w-100 h-100" alt="Titulo Topico">
                        @endif
                    </div>
                    <div class="serv07-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                        <div class="serv07-page__content__product__item__description__encompass">
                            <div class="flex-column serv07-page__content__product__item__description__encompass__txt">
                                @if ($service->title)
                                    <h2 class="serv07-page__content__product__item__description__encompass__txt__title mx-0 px-0">{{$service->title}}</h2>
                                @endif
                            </div>
                        </div>
                        <div class="serv07-page__content__product__item__description_paragraph text-start px-0 ">
                            @if ($service->description)
                                <p>
                                    {!! $service->description !!}
                                </p>
                            @endif
                        </div>
                        <div class="serv07-page__content__product__item__description__buttons">
                            <a rel="next" href="{{route('serv07.page.content', ['SERV07Services' => $service->slug])}}" class="serv07-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-page__content__product__item__description__buttons__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>


{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
