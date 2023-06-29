@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="prod05-page">

        <header class="prod05-page__header w-100">

            <div class="prod05-banner w-100" style="background-image: url({{ asset('storage/'.$section->path_image_banner) }})">
                <div class="container d-flex flex-column align-items-center justify-content-center">
                    @if ($section->title || $section->subtitle)
                        <h3 class="prod05-banner__title text-center">{{$section->title_banner}}</h3>
                        <h4 class="prod05-banner__subtitle text-center">{{$section->subtitle_banner}}</h4>
                        <hr class="prod05-banner__line">
                    @endif

                    {{-- CATEGORIAS --}}
                    <div class="prod05-categories">

                        <ul class="prod05-categories__list w-100">
                            @foreach ($categories as $category)
                                <li class="{{$categoryCurrent->id == $category->id ? 'active' : ''}} prod05-categories__list__item">
                                    <a href="{{route('prod05.category.page', ['PROD05ProductsCategory' => $category->slug])}}">
                                        @if ($category->path_image_icon)
                                            <img src="{{ asset('storage/'.$category->path_image_icon) }}" alt="{{$category->title}}" class="prod05-categories__list__item__icon">
                                        @endif
                                        {{$category->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="prod05-categories__dropdown-mobile">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header prod05-categories__dropdown-mobile__item">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseOne" aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="prod05-categories__dropdown-mobile__item__icon">
                                            Categorias
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <ul>
                                                @foreach ($categories as $category)
                                                    <li class="{{$categoryCurrent->id == $category->id ? 'active' : ''}} prod05-categories__dropdown-mobile__item">
                                                        <a href="{{route('prod05.category.page', ['PROD05ProductsCategory' => $category->slug])}}">
                                                            @if ($category->path_image_icon)
                                                                <img src="{{ asset('storage/'.$category->path_image_icon) }}" alt="{{$category->title}}" class="prod05-categories__dropdown-mobile__item__icon">
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
                </div>
            </div>
            @if ($categoryCurrent->exists)
                <div class="prod05-top w-100">
                    <div class="container d-flex flex-column align-items-center justify-content-center">
                        @if ($categoryCurrent->title_section || $categoryCurrent->subtitle_section || $categoryCurrent->description_section)
                            <h1 class="prod05-top__title text-center">{{$categoryCurrent->title_section}}</h1>
                            <h2 class="prod05-top__subtitle text-center">{{$categoryCurrent->subtitle_section}}</h2>
                            <hr class="prod05-top__line">
                            <div class="prod05-top__desc">
                                {!!$categoryCurrent->description_section!!}
                            </div>
                        @endif

                        {{-- SUBCATEGORIAS --}}
                        <div class="prod05-categories">

                            <ul class="prod05-categories__list w-100">
                                @foreach ($subcategories as $subcategory)
                                    <li class="{{$subcategoryCurrent->id == $subcategory->id ? 'active' : ''}} prod05-categories__list__item">
                                        <a href="{{route('prod05.subcategory.page', ['PROD05ProductsCategory' => $categoryCurrent->slug, 'PROD05ProductsSubcategory' => $subcategory->slug])}}">
                                            @if ($subcategory->path_image_icon)
                                                <img src="{{ asset('storage/'.$subcategory->path_image_icon) }}" alt="{{$subcategory->title}}" class="prod05-categories__list__item__icon">
                                            @endif
                                            {{$subcategory->title}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="prod05-categories__dropdown-mobile">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header prod05-categories__dropdown-mobile__item">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                                aria-controls="flush-collapseOne">
                                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                                    class="prod05-categories__dropdown-mobile__item__icon">
                                                Categoria
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <ul>
                                                    @foreach ($subcategories as $subcategory)
                                                        <li class="{{$subcategoryCurrent->id == $subcategory->id ? 'active' : ''}} prod05-categories__dropdown-mobile__item">
                                                            <a href="{{route('prod05.subcategory.page', ['PROD05ProductsCategory' => $categoryCurrent->slug, 'PROD05ProductsSubcategory' => $subcategory->slug])}}">
                                                                @if ($subcategory->path_image_icon)
                                                                    <img src="{{ asset('storage/'.$subcategory->path_image_icon) }}" alt="{{$subcategory->title}}" class="prod05-categories__dropdown-mobile__item__icon">
                                                                @endif
                                                                {{$subcategory->title}}
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
                    </div>
                </div>
            @endif

        </header>

        <main class="prod05-page__main">
            <div class="container d-flex flex-column align-items-center">
                <div class="prod05-page__main__list w-100">
                    @foreach ($products as $product)
                        <article class=" prod05-box">
                            @if ($product->path_image_thumbnail)
                                <img src="{{ asset('storage/'.$product->path_image_thumbnail) }}" alt="{{$product->title}}" class="prod05-box__image">
                            @endif
                            <div class="prod05-box__content w-100 d-flex flex-column align-items-center">
                                <div class="prod05-box__top w-100 d-flex flex-column align-items-center">
                                    <h3 class="prod05-box__top__title">{{$product->title}}</h3>
                                    <h4 class="prod05-box__top__subtitle">{{$product->subtitle}}</h4>
                                </div>
                                <hr class="prod05-box__line">
                                @if ($product->description)
                                    <p class="prod05-box__desc">{{$product->description}}</p>
                                @endif
                                <a href="{{route('prod05.page.content', ['PROD05ProductsCategory' => $product->category->slug, 'PROD05ProductsSubcategory' => $product->subcategory->slug ,'PROD05Products' => $product->slug])}}" class="prod05-box__cta">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="prod05-box__cta__icon">
                                    CTA
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{$products->links()}}

                {{-- <ul class="prod05-page__pagination w-100 d-flex flex-row align-items-center justify-content-center">
                    @for ($i = 1; $i < 4; $i++)
                        <li class="prod05-page__pagination__item">
                            <a href="#">{{ $i }}</a>
                        </li>
                    @endfor
                </ul> --}}

            </div>
        </main>
    </section>

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
