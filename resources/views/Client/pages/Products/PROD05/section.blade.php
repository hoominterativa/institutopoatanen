<section id="PROD05" class="prod05">
    <div class="container">
        <header class="prod05__header d-flex flex-column align-items-center">
            @if ($section->title || $section->subtitle || $section->description)
                <h2 class="prod05__title">{{$section->title}}</h2>
                <h3 class="prod05__subtitle">{{$section->subtitle}}</h3>
                <hr class="prod05__line">

                <p class="prod05__desc">{{$section->description}}</p>
            @endif

            <div class="prod05-categories">

                <ul class="prod05-categories__list w-100">
                    @foreach ($categories as $category)
                        <li class="prod05-categories__list__item">
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
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Categorias de Produtos" class="prod05-categories__dropdown-mobile__item__icon">
                                    Categorias
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        @foreach ($categories as $category)
                                            <li class="prod05-categories__dropdown-mobile__item">
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

        </header>

        <main class="prod05__main w-100 d-flex flex-column align-items-start">

            <div class="prod05__carousel owl-carousel">

                @foreach ($products as $product)
                    <article class="prod05__carousel__item prod05-box">
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
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="{{$product->title}}" class="prod05-box__cta__icon">
                                CTA
                            </a>
                        </div>

                    </article>
                @endforeach

            </div>

            <a href="{{route('prod05.category.page',['PROD05ProductsCategory'=>$categoryFirst->slug])}}" class="prod05__cta">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="prod05__cta__icon">
                CTA
            </a>

        </main>
    </div>
</section>
