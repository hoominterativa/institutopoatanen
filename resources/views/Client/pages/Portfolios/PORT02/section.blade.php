<section id="PORT02" class="port02" style="background-image: url({{asset('storage/'.$section->path_image_desktop)}});background-color: {{$section->background_color}}">
    @if ($section->path_image_desktop)
        <div class="port02__mark"></div>
    @endif
    <div class="port02__container container-fluid">
        @if ($section->title || $section->subtitle)
            <header class="port02__header">
                <h3 class="port02__header__wrapper-title">
                    @if ($section->title)
                        <span class="port02__header__title">{{$section->title}}</span>
                    @endif
                    @if ($section->subtitle)
                    <span class="port02__header__subtitle">{{$section->subtitle}}</span>
                    @endif
                </h3>
                <hr class="port02__header__line">
            </header>
        @endif
        {{-- END .port02__header --}}
        @if ($categories->count())
            <nav class="port02__categories">
                <div class="port02__categories__carousel">
                    @foreach ($categories as $category)
                        <a href="{{route('port02.category.page',['PORT02PortfoliosCategory' => $category->slug])}}" class="port02__categories__link">
                            <div class="port02__categories__item">
                                <img src="{{asset('storage/'.$category->path_image_icon)}}" width="62" alt="{{$category->title}}" class="port02__categories__item__icon">
                                <h2 class="port02__categories__item__title">{{$category->title}}</h2>
                            </div>
                        </a>
                    @endforeach
                </div>
                {{-- END .port02__categories__carousel --}}
            </nav>
        @endif
        {{-- END .port02__categories --}}
        @if ($portfolios->count())
            <div class="port02__portfolios">
                <div class="port02__portfolios__carousel">
                    @foreach ($portfolios as $portfolio)
                        <article class="port02__portfolios__item">
                            <a href="#{{$portfolio->slug}}" data-fancybox="{{$portfolio->slug}}" class="link-full"></a>
                            @if ($portfolio->path_image_box)
                                <img src="{{asset('storage/'.$portfolio->path_image_box)}}" width="100%" height="100%" alt="{{$portfolio->title}}" class="port02__portfolios__item_imagem position-absolute">
                            @endif
                            <h2 class="port02__portfolios__item__title">{{$portfolio->title}}</h2>
                            @include('Client.pages.Portfolios.PORT02.show',[
                                'portfolio' => $portfolio
                            ])
                        </article>
                    @endforeach
                    {{-- END .port02__portfolios__item --}}
                </div>
                {{-- END .port02__portfolios__carousel --}}
                <a href="{{route('port02.page')}}" class="port02__portfolios__link-page">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="me-2" alt="">
                    CTA
                </a>
            </div>
        @endif
        {{-- END .port02__portfolios --}}
    </div>
    {{-- END .port02__container --}}
</section>
{{-- #PORT02 --}}
