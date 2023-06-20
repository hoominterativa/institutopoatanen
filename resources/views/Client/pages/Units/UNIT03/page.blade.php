@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <section class="unit03-page w-100">
        @if ($banner)
            <header class="unit03-page__banner"
                style="background-image: url({{ asset('storage/' . $banner->path_image_desktop) }}); background-color: {{$banner->background_color}}">
                <div class="unit03-page__banner__content container d-flex flex-column align-items-center justify-content-center">
                    @if ($banner->title || $banner->subtitle)
                        <h1 class="unit03-page__banner__title text-center">{{$banner->title}}</h1>
                        <h2 class="unit03-page__banner__subtitle text-center">{{$banner->subtitle}}</h2>
                        <hr class="unit03-page__banner__line">
                    @endif
                </div>
            </header>
        @endif
        <main class="unit03-page__main w-100 d-flex flex-column">
            <div class="container d-flex flex-column align-items-stretch">
                @if ($categories->count())
                    <ul class="unit03-page__categories w-100">
                        @foreach ( $categories as $category)
                            <li class="unit03-page__categories__item {{isset($category->selected) ? 'active':''}}">
                                <a href="{{route('unit03.category.page', ['UNIT03UnitsCategory' => $category->slug])}}">
                                    @if ($category->path_image_icon)
                                        <img src="{{ asset('storage/' . $category->path_image_icon) }}" alt="" class="unit03-page__categories__item__icon">
                                    @endif
                                    @if ($category->title)
                                        {{$category->title}}
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="unit03-page__categories__dropdown-mobile">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header unit03-page__categories__dropdown-mobile__item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                            class="unit03-page__categories__dropdown-mobile__item__icon">
                                        Categorias
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach ($categories as $category)
                                                <li class="unit03-page__categories__dropdown-mobile__item">
                                                    <a href="{{route('unit03.category.page', ['UNIT03UnitsCategory' => $category->slug])}}">
                                                        @if ($category->path_image_icon)
                                                            <img src="{{ asset('storage/' . $category->path_image_icon) }}"alt="" class="unit03-page__categories__dropdown-mobile__item__icon">
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
                @endif
                @if ($units->count())
                    <div class="unit03-page__list w-100">
                        @foreach ($units as $unit)
                            <article class="unit03-page__list__item">
                                <a href="{{route('unit03.page.content', ['UNIT03UnitsCategory' => $unit->category->slug, 'UNIT03Units' => $unit->slug])}}" class="link-full"></a>
                                <div class="unit03-page__list__item__top">
                                    @if ($unit->path_image)
                                        <img src="{{ asset('storage/' . $unit->path_image) }}" alt="" class="unit03-page__list__item__img">
                                    @endif
                                    @if ($unit->title)
                                        <h2 class="unit03-page__list__item__title">{{$unit->title}}</h2>
                                    @endif
                                </div>

                                <div class="unit03-page__list__item__bottom">
                                    @if ($unit->path_image_icon)
                                        <img src="{{ asset('storage/' . $unit->path_image_icon) }}" alt="" class="unit03-page__list__item__icon">
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </section>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
