<section id="SERV08" class="serv08">
    <div class="container">
        <header class="serv08__header d-flex flex-column align-items-center">
            @if ($section)
                <h2 class="serv08__title">{{$section->title}}</h2>
                <h3 class="serv08__subtitle">{{$section->subtitle}}</h3>
                <hr class="serv08__line">
                <p class="serv08__desc">
                    {!! $section->description !!}
                </p>
            @endif
            @if ($categories->count())
                <div class="serv08-categories">
                    <ul class="serv08-categories__list w-100 serv08__categories owl-carousel">
                        @foreach ($categories as $category)
                            <li class="serv08-categories__list__item">
                                <a href="{{route('serv08.category.page', ['SERV08ServicesCategory' => $category->slug])}}">
                                    @if ($category->path_image)
                                        <img src="{{ asset('storage/' . $category->path_image) }}" alt="Icone categoria" class="serv08-categories__list__item__icon">
                                    @endif
                                    {{$category->title}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </header>
        @if ($services->count())
            <main class="serv08__main w-100 d-flex flex-column align-items-stretch">
                <div class="serv08__carousel owl-carousel">
                    @foreach ($services as $service)
                        <article class="serv08__carousel__item serv08-box" style="background-image: url({{ asset('images/gray.png') }}); background-color: #ffffff;">
                            <div class="serv08-box__promotion">
                                    <h4 class="serv08-box__promotion__titulo">Promoção</h4>
                                    {{-- $service->color_featured_service --}}
                            </div>
                            <div class="serv08-box__content w-100 d-flex flex-column align-items-stretch">
                                <div class="serv08-box__top w-100 d-flex align-items-center justify-content-between">
                                    <div class="serv08-box__top__left d-flex flex-column align-items-start justify-content-start ">
                                        <h3 class="serv08-box__top__title">{{$service->title}}</h3>
                                        <h4 class="serv08-box__top__subtitle">{{$service->subtitle}}</h4>
                                        <hr class="serv08-box__line">
                                    </div>
                                    <div class="serv08-box__top__center d-flex flex-column align-items-start justify-content-start ">
                                        <ul class="serv08-box__top__center__list">
                                           <p class="serv08-box__top__center__list__item">
                                                {!! $service->description !!}
                                            </p>
                                        </ul>
                                    </div>
                                </div>
                                <div class="serv08-box__top__right d-flex flex-column align-items-end justify-content-start ">
                                    <h4 class="serv08-box__top__subtitlee">{{$service->title_price}}</h4>
                                    <h3 class="serv08-box__top__title"><span>R$</span> {{$service->price}}</h3>
                                </div>
                            </div>
                            @include('Client.pages.Services.SERV08.show')
                            <a rel="next" class="serv08-box__cta" href="#lightbox-serv08" data-fancybox="" data-src="#lightbox-serv08">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv08-box__cta__icon">
                                CTA
                            </a>
                        </article>
                    @endforeach
                </div>
                <a href="{{route('serv08.category.page', ['SERV08ServicesCategory' => $categoryFirst->slug])}}" class="serv08__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv08__cta__icon">
                    Ver mais
                </a>
            </main>
        @endif
    </div>
</section>
