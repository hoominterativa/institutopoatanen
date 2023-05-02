<section id="PROD02" class="prod02 container-fluid px-0">
    <div class="container container--edit">
        <header class="prod02__navigation">
            <div class="prod02__navigation__content d-flex justify-content-between w-100">
                <div class="prod02__navigation__content__encompass">
                    @if ($section->title || $section->subtitle)
                        <h1 class="prod02__navigation__content__encompass__title">{{$section->title}}</h1>
                        <h2 class="prod02__navigation__content__encompass__subtitle mb-0">{{$section->subtitle}}</h2>
                    @endif
                </div>
                {{-- Finish prod02__navigation__content__encompass --}}
                <nav class="prod02__navigation__content__nav__desktop justify-content-between align-items-center">
                    @foreach ($categories as $category)
                        <ul class="d-flex align-content-center mb-0 px-0">
                            <li><a href="{{route('prod02.category.page',['PROD02ProductsCategory' => $category->slug])}}">{{$category->title}}</a></li>
                        </ul>
                    @endforeach
                    {{-- Finish prod02__navigation__content__ul --}}
                    <a href="{{route('prod02.page')}}" class="prod02__navigation__content__nav__desktop__cta transition d-flex justify-content-center align-items-center">
                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__navigation__content__nav__desktop__cta__icon me-3 transition">
                        CTA
                    </a>
                    {{-- Finish prod02__navigation__content__nav__desktop__cta --}}
                </nav>
                {{-- Finish prod02__navigation__content__nav__desktop --}}
            </div>
            {{-- Finish prod02__navigation__content --}}
            <ul class="prod02__navigation__nav__mobile align-content-center mb-0 px-0">
                @foreach ($categories as $category)
                    <li><a href="{{route('prod02.category.page',['PROD02ProductsCategory' => $category->slug])}}">{{$category->title}}</a></li>
                @endforeach
            </ul>
            {{-- Finish prod02__navigation__nav__mobile --}}
            <div class="prod02__navigation__paragraph">
                @if ($section->description)
                    <p>
                    {!! $section->description !!}
                    </p>
                @endif
            </div>
            {{-- Finish prod02__navigation__paragraph --}}
        </header>
        {{-- Finish prod02__navigation --}}
        @if ($products->count())
            <div class="prod02__content__product">
                <div class="carousel-prod02 owl-carousel">
                    @foreach ($products as $product)
                        <article class="prod02__content__product__item w-100">
                            <div class="prod02__content__product__item__image w-100 h-100">
                                <img src="{{asset('storage/' . $product->path_image_box)}}" class="w-100 h-100" alt="Titulo Topico">
                            </div>
                            <div class="prod02__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                                <h2 class="prod02__content__product__item__description__title mx-0 px-0">{{$product->title}}</h2>
                                <div class="prod02__content__product__item__description_paragraph mx-0 px-0 ">
                                    <p>
                                        {!! $product->description !!}
                                    </p>
                                </div>
                                <a rel="next" href="javascript-void(0);" data-fancybox="{{$product->slug}}" data-src="#lightbox-prod02-1-{{$product->slug}}" class="prod02__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__content__product__item__cta__icon me-3 transition">
                                    CTA
                                </a>
                            </div>
                            @include('Client.pages.Products.PROD02.show', [
                                'product' => $product
                            ])
                        </article>
                    @endforeach
                    {{-- Finish prod02__content__product__item --}}
                </div>
                {{-- Finish carousel-prod02 --}}
            </div>
        @endif
        {{-- Finish prod02__content__product --}}
    </div>
    {{-- Finish container --}}
</section>
{{-- Finish prod02 --}}
