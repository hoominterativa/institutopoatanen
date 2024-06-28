@if ($section || $categories->count() || $services->count())
    <section id="serv12" class="serv12">
        @if ($section)
            <header class="serv12__header">
                @if ($section->title)
                    <h2 class="serv12__header__title">{{$section->title}}</h2>
                @endif
                @if ($section->subtitle)
                    <h3 class="serv12__header__subtitle">{{$section->subtitle}}</h3>
                @endif
                @if ($section->description)
                    <div class="serv12__header__paragraph">
                        {!! $section->description !!}
                    </div>
                @endif
            </header>
        @endif
        @if ($categories->count())
            <aside class="serv12__categories">
                <menu class="serv12__categories__swiper-wrapper swiper-wrapper">
                    @foreach ($categories as $category)
                        <li class="serv12__categories__item swiper-slide {{$category->id == $categorySelected->id ? 'active' : ''}}">
                            <a href="{{route('serv12.category.page', ['SERV12ServicesCategory' => $category->slug])}}" class="link-full" title="categoria {{$category->title}}"></a>
                            {{$category->title}}
                        </li>
                    @endforeach
                </menu>
            </aside>
        @endif
        @if ($services->count())
            <div class="serv12__services">
                <div class="serv12__services__carousel">
                    <div class="serv12__services__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($services as $service)
                            <article class="serv12__services__item swiper-slide">
                                <a href="{{route('serv12.category.page', ['SERV12ServicesCategory' => $service->category->slug, 'SERV12Services' => $service->slug])}}" class="link-full"></a>
                                @if ($service->path_image_icon)
                                    <img src="{{asset('storage/'. $service->path_image_icon)}}" loading="lazy" class="serv12__services__item__icon" alt="Ícone do {{$service->title}} ">
                                @endif
                                <h3 class="serv12__services__item__title">{{$service->title}}</h3>
                                @if ($service->description)
                                    <p class="serv12__services__item__paragraph">
                                        {!! $service->description !!}
                                    </p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                    <div class="serv12__services__carousel__swiper-pagination"></div>
                </div>
                <a href="{{route('serv12.category.page', ['SERV12ServicesCategory' => $categorySelected->slug])}}" title="página de serviços" class="serv12__cta">CTA</a>
            </div>
        @endif
    </section>
@endif
