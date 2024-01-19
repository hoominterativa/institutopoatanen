@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

{{-- BEGIN Page content --}}
@if ($units->count())
    <div id="UNIT01" class="unit01-page">
        <section class="container-fluid px-0">
            @if ($section)
                <header class="unit01-page__header" style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }}); background-color: {{ $section->background_color_banner }};">
                    <div class="container container--unit01-header">
                        @if ($section->title_banner || $section->subtitle_banner)
                            <h2 class="d-block text-center">
                                <span class="unit01-page__header__title d-block">{{$section->title_banner}}</span>
                                <span class="unit01-page__header__subtitle d-block text-uppercase">{{$section->subtitle_banner}}</span>
                                <hr class="unit01-page__header__line">
                            </h2>
                        @endif
                        @if ($categories->count())
                            <div class="unit01-page__header__navigation">
                                <nav class="unit01-page__header__navigation__desktop">
                                    <ul class="unit01-page__header__navigation__desktop__item">
                                        @foreach ($categories as $category)
                                            <li>
                                                <a href="{{route('unit01.category.page',['UNIT01UnitsCategory' => $category->slug])}}">
                                                    <img src="{{asset('storage/' . $category->path_image)}}" alt="ícone {{$category->title}}">
                                                    {{$category->title}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                                <div class="unit01-page__header__navigation__dropdown-mobile">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header unit01-page__header__navigation__dropdown-mobile__item">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                                    aria-controls="flush-collapseOne">
                                                    Categorias
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <ul>
                                                        @foreach ($categories as $category)
                                                            <li class="unit01-page__header__navigation__dropdown-mobile__item">
                                                                <a href="{{route('unit01.category.page',['UNIT01UnitsCategory' => $category->slug])}}">
                                                                    <img src="{{asset('storage/' . $category->path_image)}}" alt="ícone {{$category->title}}">
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
                        @endif
                    </div>
                </header>
            @endif
        </section>
        <div class="unit01-page__divisor">
            @foreach ($units as $unit)
                <div class="unit01-page__divisor__section">
                    <div class="row px-0 mx-0 justify-content-between">
                        <div class="unit01-page__divisor__section__boxLeft col-sm-6 px-0">
                            @if ($unit->title_unit || $unit->title)
                                <h4 class="unit01-page__divisor__section__boxLeft__title">{{$unit->title_unit}}</h4>
                                <hr class="unit01-page__divisor__section__boxLeft__line">
                                <h4 class="unit01-page__divisor__section__boxLeft__subtitle">{{$unit->title}}</h4>
                            @endif
                            <div class="unit01-page__divisor__section__boxLeft__paragraph">
                                @if ($unit->description)
                                    <p>
                                        {!! $unit->description !!}
                                    </p>
                                @endif
                            </div>
                            <div class="unit01-page__divisor__section__boxLeft__topics row px-0 mx-0">
                                @foreach ($unit->topics as $topic)
                                    <div class="unit01-page__divisor__section__boxLeft__topics__topic col-sm-3 px-0 position-relative">
                                        @if ($topic->link !== '' && $topic->target_link == '_blank')
                                            <a rel="next" href="{{getUri($topic->link)}}" target="{{$topic->target_link}}">
                                                <div class="unit01-page__divisor__section__boxLeft__topics__topic__image position-absolute w-100 h-100">
                                                    <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Logo">
                                                </div>
                                                <div class="unit01-page__divisor__section__boxLeft__topics__topic__description position-absolute w-100 h-100">
                                                    <div class="unit01-page__divisor__section__boxLeft__topics__topic__description__icon">
                                                        @if ($topic->path_image_icon)
                                                            <img src="{{asset('storage/' . $topic->path_image_icon)}}" alt="Ícone" class="w-100 h-100">
                                                        @endif
                                                    </div>
                                                    @if ($topic->title)
                                                        <h2 class="unit01-page__divisor__section__boxLeft__topics__topic__description__title mb-0">{{$topic->title}}</h2>
                                                    @endif
                                                </div>
                                            </a>
                                        @else
                                            <a rel="next" href="" data-fancybox="{{$topic->title}}" data-src="#lightbox-unit01-1-{{$topic->id}}">
                                                <div class="unit01-page__divisor__section__boxLeft__topics__topic__image position-absolute w-100 h-100">
                                                    <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Logo">
                                                </div>
                                                <div class="unit01-page__divisor__section__boxLeft__topics__topic__description position-absolute w-100 h-100">
                                                    <div class="unit01-page__divisor__section__boxLeft__topics__topic__description__icon">
                                                        @if ($topic->path_image_icon)
                                                            <img src="{{asset('storage/' . $topic->path_image_icon)}}" alt="Ícone" class="w-100 h-100">
                                                        @endif
                                                    </div>
                                                    @if ($topic->title)
                                                        <h2 class="unit01-page__divisor__section__boxLeft__topics__topic__description__title mb-0">{{$topic->title}}</h2>
                                                    @endif
                                                </div>
                                            </a>
                                        @endif
                                        @include('Client.pages.Units.UNIT01.show', [
                                            'topic' => $topic,
                                            'galleries' => $unit->galleries
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if ($unit->galleries)
                            <div class="unit01-page__divisor__section__boxRight col-sm-5 px-0">
                                <div class="carousel_unit01 owl-carousel">
                                    @foreach ($unit->galleries as $gallery)
                                        <div class="unit01-page__divisor__section__boxRight__imageBox">
                                            <a href="{{asset('storage/' . $gallery->path_image)}}" data-fancybox="galeria">
                                                <img src="{{asset('storage/' . $gallery->path_image)}}" alt="Imagem" class="w-100 h-100">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
{{-- END .unit01-page__content --}}

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
