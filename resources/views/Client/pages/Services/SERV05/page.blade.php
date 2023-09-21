@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <section class="serv05-page">
        <header class="serv05-page__header w-100">
            <div class="serv05-banner-carousel owl-carousel w-100">
                @foreach ($galleries as $gallery)
                    <div class="serv05-banner-carousel__item" style="background-image: url({{ asset('storage/' . $gallery->path_image_desktop) }});  background-color: #ffffff;">
                        <div class="container d-flex flex-column align-items-center justify-content-center">
                            @if ($section)
                                <h3 class="serv05-banner-carousel__title text-center">{{$section->title_banner}}</h3>
                                <h4 class="serv05-banner-carousel__subtitle text-center">{{$section->subtitle_banner}}</h4>
                                <hr class="serv05-banner-carousel__line">
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="serv05-top w-100">
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    @if ($section)
                        <h1 class="serv05-top__title text-center">{{$section->title_about}}</h1>
                        <h2 class="serv05-top__subtitle text-center">{{$section->subtitle_about}}</h2>
                        <hr class="serv05-top__line">
                        <div class="serv05-top__desc">
                            <p>
                                {!! $section->description_about!!}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </header>
        <main class="serv05-page__main">
            <div class="container d-flex flex-column align-items-center">
                <div class="serv05-categories">
                    <ul class="serv05-categories__list w-100">
                        @foreach ($categories as $category)
                            <li class="serv05-categories__list__item {{isset($category->selected) ? 'active':''}}">
                                <a href="{{route('serv05.category.page' , ['SERV05ServicesCategory' => $category->slug])}}">
                                    @if ($category->path_image_icon)
                                        <img src="{{ asset('storage/' . $category->path_image_icon) }}" alt="" class="serv05-categories__list__item__icon">
                                    @endif
                                    @if ($category->title)
                                        {{$category->title}}
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="serv05-categories__dropdown-mobile">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header serv05-categories__dropdown-mobile__item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                            class="serv05-categories__dropdown-mobile__item__icon">
                                        Categorias
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach ($categories as $category)
                                                <li class="serv05-categories__dropdown-mobile__item">
                                                    <a href="{{route('serv05.category.page' , ['SERV05ServicesCategory' => $category->slug])}}">
                                                        @if ($category->path_image_icon)
                                                            <img src="{{ asset('storage/' . $category->path_image_icon) }}" alt="" class="serv05-categories__dropdown-mobile__item__icon">
                                                        @endif
                                                        @if ($category->title)
                                                            {{$category->title}}
                                                        @endif
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
                <div class="serv05-page__main__list">
                    @foreach ($services as $service)
                        <article class="serv05-box" style="background-image: url({{ asset('storage/' . $service->path_image) }}); background-color: #ffffff;">
                            @if ($service->path_image_icon)
                                <img src="{{ asset('storage/' . $service->path_image_icon) }}" alt="" class="serv05-box__icon">
                            @endif
                            <div class="serv05-box__content w-100 d-flex flex-column align-items-stretch">
                                <div class="serv05-box__top w-100 d-flex align-items-center justify-content-between">
                                    <div class="serv05-box__top__left d-flex flex-column align-items-start justify-content-start ">
                                        @if ($service->title || $service->subtitle)
                                            <h3 class="serv05-box__top__title">{{$service->title}}</h3>
                                            <h4 class="serv05-box__top__subtitle">{{$service->subtitle}}</h4>
                                        @endif
                                    </div>
                                    <div class="serv05-box__top__right d-flex flex-column align-items-end justify-content-start ">
                                        @if ($service->title_price || $service->price)
                                            <h4 class="serv05-box__top__subtitle">{{$service->title_price}}</h4>
                                            <h3 class="serv05-box__top__title">R$ {{$service->price}}</h3>
                                        @endif
                                    </div>
                                </div>
                                <hr class="serv05-box__line">
                                @if ($service->description)
                                    <p class="serv05-box__desc">
                                        {!! $service->description !!}
                                    </p>
                                @endif
                                <a href="{{route('serv05.show.content', ['SERV05Services' => $service->slug])}}" class="serv05-box__cta">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv05-box__cta__icon">
                                    CTA
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                {{-- <ul class="serv05-page__pagination w-100 d-flex flex-row align-items-center justify-content-center">
                    @for ($i = 1; $i < 4; $i++)
                        <li class="serv05-page__pagination__item">
                            <a href="#">{{ $i }}</a>
                        </li>
                    @endfor
                </ul> --}}
                <nav aria-label="..." class="serv05-page__pagination">
                    {{ $services->links() }}
                </nav>
            </div>
        </main>
    </section>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
