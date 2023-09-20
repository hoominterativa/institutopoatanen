@extends('Client.Core.client')
@section('content')
    <section id="PORT02" class="port02-page">
        <div class="port02-page__container container-fluid">
            @if ($banner)
                <header class="port02-page__header" style="background-image: url({{asset('storage/'.$banner->path_image_desktop)}});background-color: {{$banner->background_color}}">
                    @if ($banner->path_image_desktop)
                        <div class="port02-page__mark"></div>
                    @endif
                    <h3 class="port02-page__header__wrapper-title">
                        @if ($banner->title)
                            <span class="port02-page__header__title">{{$section->title}}</span>
                        @endif
                    </h3>
                    <hr class="port02-page__header__line">
                </header>
            @endif
            {{-- END .port02-page__header --}}
            @if ($categories->count())
                <nav class="port02-page__categories">
                    <div class="port02-page__categories__carousel">
                        @foreach ($categories as $category)
                            <a href="{{route('port02.category.page',['PORT02PortfoliosCategory' => $category->slug])}}" class="port02-page__categories__link {{ isset($category->selected) ? 'active' : '' }}">
                                <div class="port02-page__categories__item">
                                    <img src="{{asset('storage/'.$category->path_image_icon)}}" width="62" alt="{{$category->title}}" class="port02-page__categories__item__icon">
                                    <h2 class="port02-page__categories__item__title">{{$category->title}}</h2>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    {{-- END .port02-page__categories__carousel --}}
                </nav>
            @endif
            {{-- END .port02-page__categories --}}
            @if ($portfolios->count())
                <div class="port02-page__portfolios">
                    @if ($section)
                        <div class="port02-page__portfolios__header" style="background-image: url({{asset('storage/'.$section->path_image_desktop)}});background-color: {{$section->background_color}}">
                            <div class="port02-page__portfolios__header__wrapper-title d-flex align-items-center justify-content-center">
                                @if ($section->path_image_icon)
                                    <img src="{{asset('storage/'.$section->path_image_icon)}}" width="62" class="port02-page__portfolios__header__icon me-2">
                                @endif
                                @if ($section->title)
                                    <h3 class="port02-page__portfolios__header__title">{{$section->title}}</h3>
                                @endif
                            </div>
                            <hr class="port02-page__portfolios__header__line">
                            @if ($section->description)
                                <div class="port02-page__portfolios__header__text">
                                    <p>{{$section->description}}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="port02-page__row row">
                        @foreach ($portfolios as $portfolio)
                            <div class="col-12 col-sm-6 col-md-4">
                                <article class="port02-page__portfolios__item">
                                    <a href="#{{$portfolio->slug}}" data-fancybox="{{$portfolio->slug}}" class="link-full"></a>
                                    @if ($portfolio->path_image_box)
                                        <img src="{{asset('storage/'.$portfolio->path_image_box)}}" width="100%" height="100%" alt="{{$portfolio->title}}" class="port02-page__portfolios__item_imagem position-absolute">
                                    @endif
                                    <h2 class="port02-page__portfolios__item__title">{{$portfolio->title}}</h2>
                                    @include('Client.pages.Portfolios.PORT02.show',[
                                        'portfolio' => $portfolio
                                    ])
                                </article>
                            </div>
                        @endforeach
                        {{-- END .port02-page__portfolios__item --}}
                        <div class="port02-page__portfolios__pagination">
                            {{$portfolios->links()}}
                        </div>
                    </div>
                    {{-- END .port02-page__row --}}
                </div>
            @endif
            {{-- END .port02-page__portfolios --}}
        </div>
        {{-- END .port02-page__container --}}
    </section>
    {{-- #PORT02 --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
