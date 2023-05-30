<section id="PROD02V1" class="prod02v1 container-fluid px-0">
    <div class="container container--edit">
        <header class="prod02v1__navigation">
            <div class="prod02v1__navigation__content d-flex justify-content-between w-100">
                <div class="prod02v1__navigation__content__encompass">
                    @if ($section->title || $section->subtitle)
                        <h2 class="prod02v1__navigation__content__encompass__title">{{ $section->title }}</h2>
                        <h3 class="prod02v1__navigation__content__encompass__subtitle mb-0">{{ $section->subtitle }}</h3>
                    @endif
                </div>
                {{-- Finish prod02v1__navigation__content__encompass --}}
                <nav class="prod02v1__navigation__content__nav__desktop justify-content-between align-items-center">

                    <ul class="d-flex align-content-center mb-0 px-0">
                        @foreach ($categories as $category)
                            <li>
                                <a
                                    href="{{ route('prod02v1.category.page', ['PROD02V1ProductsCategory' => $category->slug]) }}">
                                    @if ($category->path_image_icon)
                                        <img src="{{ asset('storage/' . $category->path_image_icon) }}" alt="Ícone">
                                    @endif
                                    @if ($category->title)
                                        {{ $category->title }}
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Finish prod02v1__navigation__content__ul --}}
                    <a href="{{ route('prod02v1.page') }}"
                        class="prod02v1__navigation__content__nav__desktop__cta transition d-flex justify-content-center align-items-center">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                            class="prod02v1__navigation__content__nav__desktop__cta__icon me-3 transition">
                        CTA
                    </a>
                    {{-- Finish prod02v1__navigation__content__nav__desktop__cta --}}
                </nav>
                {{-- Finish prod02v1__navigation__content__nav__desktop --}}
            </div>
            {{-- Finish prod02v1__navigation__content --}}
            <ul class="prod02v1__navigation__nav__mobile align-content-center mb-0 px-0">
                @foreach ($categories as $category)
                    <li><a
                            href="{{ route('prod02v1.category.page', ['PROD02V1ProductsCategory' => $category->slug]) }}">{{ $category->title }}</a>
                    </li>
                @endforeach
            </ul>
            {{-- Finish prod02v1__navigation__nav__mobile --}}
            <div class="prod02v1__navigation__paragraph">
                @if ($section->description)
                    <p>
                        {!! $section->description !!}
                    </p>
                @endif
            </div>
            {{-- Finish prod02v1__navigation__paragraph --}}
        </header>
        {{-- Finish prod02v1__navigation --}}
        @if ($products->count())
            <div class="prod02v1__content__product">
                <div class="carousel-prod02v1 owl-carousel">
                    @foreach ($products as $product)
                        <article class="prod02v1__content__product__item w-100">
                            <div class="prod02v1__content__product__item__image w-100 h-100">
                                <img src="{{ asset('storage/' . $product->path_image_box) }}" class="w-100 h-100"
                                    alt="Titulo Topico">
                            </div>
                            <div
                                class="prod02v1__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                                <h2 class="prod02v1__content__product__item__description__title mx-0 px-0">
                                    {{ $product->title }}</h2>
                                <div class="prod02v1__content__product__item__description_paragraph mx-0 px-0 ">
                                    <p>
                                        {!! $product->description !!}
                                    </p>
                                </div>
                                <a rel="next" href="javascript-void(0);" data-fancybox="{{ $product->slug }}"
                                    data-src="#lightbox-prod02v1-1-{{ $product->slug }}"
                                    class="prod02v1__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="prod02v1__content__product__item__cta__icon me-3 transition">
                                    CTA
                                </a>
                            </div>
                            @include('Client.pages.Products.PROD02V1.show', [
                                'product' => $product,
                            ])
                        </article>
                    @endforeach
                    {{-- Finish prod02v1__content__product__item --}}
                </div>
                {{-- Finish carousel-prod02v1 --}}
            </div>
        @endif
        {{-- Finish prod02v1__content__product --}}
    </div>
    {{-- Finish container --}}
</section>
{{-- Finish prod02v1 --}}
