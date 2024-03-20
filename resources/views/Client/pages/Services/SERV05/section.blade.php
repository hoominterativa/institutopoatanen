@if ($section)
    <section id="SERV05" class="serv05">
        <div class="container">
            <header class="serv05__header d-flex flex-column align-items-center">
                @if ($section->title || $section->subtitle)
                    <h2 class="serv05__title">{{$section->title}}</h2>
                    <h3 class="serv05__subtitle">{{$section->subtitle}}</h3>
                    <hr class="serv05__line">
                @endif
                @if ($section->description)
                    <p class="serv05__desc">
                        {!! $section->description !!}
                    </p>
                @endif
                @if ($categories->count())
                    <div class="serv05-categories">
                        <ul class="serv05-categories__list w-100">
                            @foreach ($categories as $category)
                                <li class="serv05-categories__list__item">
                                    <a href="{{route('serv05.category.page', ['SERV05ServicesCategory' => $category->slug])}}">
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
                                                        <a href="{{route('serv05.category.page', ['SERV05ServicesCategory' => $category->slug])}}">
                                                            @if ($category->path_image_icon)
                                                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv05-categories__dropdown-mobile__item__icon">
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
                @endif
            </header>
            @if ($services->count())
                <main class="serv05__main w-100 d-flex flex-column align-items-stretch">
                    <div class="serv05__carousel owl-carousel">
                        @foreach ($services as $service)
                            <article class="serv05__carousel__item serv05-box" style="background-image: url({{ asset('storage/' . $service->path_image) }}); background-color: #ffffff;">
                                @if ($service->path_image_icon)
                                    <img src="{{ asset('storage/' . $service->path_image_icon) }}" alt="" class="serv05-box__icon">
                                @endif
                                <div class="serv05-box__content w-100 d-flex flex-column align-items-stretch">
                                    <div class="serv05-box__top w-100 d-flex align-items-center justify-content-between">
                                        @if ($service->title || $service->subtitle)
                                            <div class="serv05-box__top__left d-flex flex-column align-items-start justify-content-start ">
                                                <h3 class="serv05-box__top__title">{{$service->title}}</h3>
                                                <h4 class="serv05-box__top__subtitle">{{$service->subtitle}}</h4>
                                            </div>
                                        @endif
                                        @if ($service->title_price || $service->price)
                                            <div class="serv05-box__top__right d-flex flex-column align-items-end justify-content-start ">
                                                <h4 class="serv05-box__top__subtitle">{{$service->title_price}}</h4>
                                                <h3 class="serv05-box__top__title">R$ {{$service->price}}</h3>
                                            </div>
                                        @endif
                                    </div>
                                    <hr class="serv05-box__line">
                                    @if ($service->description)
                                        <p class="serv05-box__desc">
                                            {!! $service->description !!}
                                        </p>
                                    @endif
                                    <a href="{{route('serv05.show', ['SERV05ServicesCategory' => $service->category->slug, 'SERV05Services' => $service->slug])}}" class="serv05-box__cta">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                            class="serv05-box__cta__icon">
                                        CTA
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <a href="{{route('serv05.category.page', ['SERV05ServicesCategory' => $categoryFirst->slug])}}" class="serv05__cta">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv05__cta__icon">
                        CTA
                    </a>
                </main>
            @endif
        </div>
    </section>
@endif
