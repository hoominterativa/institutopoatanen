@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <section class="serv06-page">
        @if ($banner)
            <header class="serv06-page__header"
                style="background-image: url({{ asset('storage/' . $banner->path_image_desktop) }}); background-color: {{$banner->background_color}};">
                <div class="container d-flex flex-column align-items-center">
                    @if ($banner->title || $banner->subtitle)
                        <h1 class="serv06-page__title">{{$banner->title}}</h1>
                        <h3 class="serv06-page__subtitle">{{$banner->subtitle}}</h3>
                        <hr class="serv06-page__line">
                    @endif
                    <div class="serv06-categories">
                        @if ($categories->count())
                            <ul class="serv06-categories__list w-100">
                                @foreach ($categories as $category)
                                    <li class="serv06-categories__list__item">
                                        <a href="#sec-{{ $category->slug }}-{{ $category->services->first()->slug }}">
                                            @if ($category->path_image_icon)
                                                <img src="{{ asset('storage/' . $category->path_image_icon) }}" alt="" class="serv06-categories__list__item__icon">
                                            @endif
                                            @if ($category->title)
                                                {{ $category->title }}
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="serv06-categories__dropdown-mobile">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header serv06-categories__dropdown-mobile__item">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseOne" aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                                class="serv06-categories__dropdown-mobile__item__icon">
                                            Categorias
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            @if ($categories->count())
                                                <ul>
                                                    @foreach ($categories as $category)
                                                        <li class="serv06-categories__dropdown-mobile__item">
                                                            <a href="#sec-{{ $category->slug }}-{{ $category->services->first()->slug }}">
                                                                @if ($category->path_image_icon)
                                                                    <img src="{{ asset('storage/' . $category->path_image_icon) }}" alt="" class="serv06-categories__dropdown-mobile__item__icon">
                                                                    @if ($category->title)
                                                                        {{ $category->title }}
                                                                    @endif
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        @endif
        @if ($services->count())
            <main class="serv06-page__main">
                @foreach ($services as $service)
                <article id="sec-{{ $service->category->slug }}-{{ $service->slug }}" class="serv06-page__item w-100">
                        @if ($service->path_image)
                            <img src="{{ asset('storage/' . $service->path_image) }}" alt="" class="serv06-page__item__image">
                        @endif
                        <div class="serv06-page__item__right">
                            @if ($service->title || $service->subtitle)
                                <h4 class="serv06-page__item__subtitle">{{$service->subtitle}}</h4>
                                <h3 class="serv06-page__item__title">{{$service->title}}</h3>
                                <hr class="serv06-page__item__line">
                            @endif
                            <div class="serv06-page__item__text">
                                @if ($service->text)
                                    <p>
                                        {!! $service->text !!}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </main>
        @endif
    </section>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
