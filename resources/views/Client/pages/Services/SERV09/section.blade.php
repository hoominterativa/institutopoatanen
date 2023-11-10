<section id="SERV09" class="serv09">
    <div class="container container--serv09 position-relative">
        <header class="serv09__header">
            @if ($section->title || $section->subtitle)
                <h3 class="serv09__header__title">{{ $section->subtitle }}</h3>
                <h2 class="serv09__header__subtitle">{{ $section->title }}</h2>
                <hr class="serv09__header__line">
            @endif
            @if ($section->description)
                <div class="serv09__header__description">
                    {!! $section->description !!}
                </div>
            @endif
            @if ($categories->count())
                <nav class="serv09__header__nav">
                    <ul class="serv09__header__nav__list">
                        @foreach ($categories as $category)
                            <li class="serv09__header__nav__list__category" >
                                <a href="{{route('serv09.category.page', ['SERV09ServicesCategory' => $category->slug])}}">
                                    @if ($category->path_image)
                                        <img src="{{ asset('storage/' . $category->path_image) }}" alt="Icone categoria" class="serv09__header__nav__list__category__icon">
                                    @endif
                                    {{$category->title}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @endif
        </header>
        @if ($services->count())
            <main class="serv09__main">
                <div class="serv09__content carousel-serv09 owl-carousel">
                    @foreach ($services as $service)
                        <article class="serv09__box w-100 d-flex justify-content-between row mx-auto">
                            <div class="serv09__box__left col-sm-6">
                                <div class="serv09__box__left__content">
                                    @if ($service->title || $service->subtitle)
                                        <h3 class="serv09__box__left__content__title">{{$service->title}}</h3>
                                        <h4 class="serv09__box__left__content__subtitle">{{$service->subtitle}}</h4>
                                    @endif
                                    @if ($service->price)
                                        <h3 class="serv09__box__left__content__price"><span>R$</span>{{number_format($service->price, 2, ',', '.')}}</h3>
                                    @endif

                                    <div class="serv09__box__left__content__paragraph">
                                        @if ($service->description)
                                            <p>
                                                {!! $service->description !!}
                                            </p>
                                        @endif
                                    </div>
                                    @if ($service->topics->count())
                                        <div class="serv09__box__left__content__engBox">
                                            @foreach ($service->topics as $topic)
                                                <div class="serv09__box__left__content__engBox__button">
                                                    @if ($topic->path_image)
                                                        <img src="{{ asset('storage/' . $topic->path_image) }}" alt="Ícon" class="serv09__box__left__content__engBox__button__icon">
                                                    @endif
                                                    @if ($topic->title)
                                                        <h4 class="serv09__box__left__content__engBox__button__title">{{$topic->title}}</h4>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="serv09__box__right col-sm-6">
                                <img src="{{ asset('storage/' . $service->path_image) }}" alt="" class="serv09__box__right__image">
                                <a href="{{route('serv09.page.content', ['SERV09ServicesCategory' => $service->categories->slug, 'SERV09Services' => $service->slug])}}" class="serv09__box__right__btn">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícon" class="serv09__box__right__btn__icon">
                                    CTA
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <a  href="{{route('serv09.category.page', ['SERV09ServicesCategory' => $categoryFirst->slug])}}" class="serv09__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícon" class="serv09__cta__icon">
                    Ver mais
                </a>
            </main>
        @endif
    </div>
</section>
