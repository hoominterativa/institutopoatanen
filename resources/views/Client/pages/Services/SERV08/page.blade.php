@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

<section class="serv08-page">
    <header class="serv08-page__header w-100">
        @if ($section->active_banner)
            <div class="serv08-banner-carousel owl-carousel w-100">
                <div class="serv08-banner-carousel__item" style="background-image: url({{ asset('storage/'.$section->path_image_desktop) }});">
                    @if ($section->title_banner || $section->subtitle_banner)
                        <div class="container d-flex flex-column align-items-center justify-content-center">
                            <h3 class="serv08-banner-carousel__title text-center">{{$section->title_banner}}</h3>
                            <h4 class="serv08-banner-carousel__subtitle text-center">{{$section->subtitle_banner}}</h4>
                            <hr class="serv08-banner-carousel__line">
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <div class="serv08-top w-100">
            <div class="container d-flex flex-column align-items-center justify-content-center">
                @if ($section->active_content)
                    @if ($section->subtitle_content || $section->subtitle_content)
                        <h1 class="serv08-top__title text-center">{{$section->subtitle_content}}</h1>
                        <h2 class="serv08-top__subtitle text-center">{{$section->title_content}}</h2>
                        <hr class="serv08-top__line">
                    @endif
                    @if ($section->description_content)
                        <div class="serv08-top__desc">
                            <p>
                                {!! $section->description_content !!}
                            </p>
                        </div>
                    @endif
                @endif
                @if ($categories->count())
                    <div class="serv08-categories">
                        <ul class="serv08-categories__list w-100 serv08__categories owl-carousel">
                            @foreach ($categories as $category)
                                <li class="serv08-categories__list__item {{isset($category->selected) ? 'active':''}}">
                                    <a href="{{route('serv08.category.page', ['SERV08ServicesCategory' =>$category->slug])}}">
                                        <img src="{{ asset('storage/'.$category->path_image) }}" alt="Ícone da categoria {{$category->title}}" class="serv08-categories__list__item__icon">
                                        {{$category->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </header>
    @if ($services->count())
        <main class="serv08-page__main">
            <div class="container d-flex flex-column align-items-center">
                <div class="serv08-page__main__list">
                    @foreach ($services as $service)
                        <article class="serv08-box" style="background-image: url({{ asset('storage/' .$service->path_image) }}); background-color: #ffffff;">
                            @if ($service->featured_service == 1)
                                <div class="serv08-box__promotion" style="background-color: {{$service->color_featured_service}}; border-color: {{$service->color_featured_service}};">
                                    <h4 class="serv08-box__promotion__titulo">{{$service->title_featured_service}}</h4>
                                </div>
                            @endif
                            <div class="serv08-box__content w-100 d-flex flex-column align-items-stretch">
                                <div class="serv08-box__top w-100 d-flex align-items-center justify-content-between">
                                    <div class="serv08-box__top__left d-flex flex-column align-items-start justify-content-start ">
                                        <h3 class="serv08-box__top__title">{{$service->title}}</h3>
                                        <h4 class="serv08-box__top__subtitle">{{$service->subtitle}}</h4>
                                        <hr class="serv08-box__line">
                                    </div>
                                    <div class="serv08-box__top__center d-flex flex-column align-items-start justify-content-start ">
                                        <div class="serv08-box__top__center__list">
                                            <p class="serv08-box__top__center__list__item">
                                                {!! $service->description !!}
                                            </p>
                                        </div>
                                    </div>
                                    <div style="background-color: {{$service->featured_service == 1 ? $service->color_featured_service : ''}}; border-color: {{$service->featured_service == 1 ? $service->color_featured_service : ''}};" class="serv08-box__top__right d-flex flex-column align-items-end justify-content-start ">
                                        <h4 class="serv08-box__top__subtitlee">{{$service->title_price}}</h4>
                                        <h3 class="serv08-box__top__title"><span>R$ </span>{{number_format($service->price, 2, ',', '.')}}</h3>
                                    </div>
                                </div>
                                <div class="serv08-box__desc">
                                    <p></p>
                                </div>
                                @include('Client.pages.Services.SERV08.show',[
                                    'service'=>$service,
                                    'compliance' => $compliance,
                                    'inputs'=>$inputs,
                                ])
                                <a style="background-color: {{$service->featured_service == 1 ? $service->color_featured_service : ''}}; border-color: {{$service->featured_service == 1 ? $service->color_featured_service : ''}};" rel="next" class="serv08-box__cta" href="" data-fancybox="" data-src="#lightbox-serv08-{{$service->id}}">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv08-box__cta__icon">
                                    CTA
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <ul class="serv08-page__pagination w-100 d-flex flex-row align-items-center justify-content-center">
                    <li class="serv08-page__pagination__item">
                        {{ $services->links() }}
                    </li>
                </ul>
            </div>
        </main>
    @endif
</section>

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
{!!$section!!}
@endforeach
@endsection
