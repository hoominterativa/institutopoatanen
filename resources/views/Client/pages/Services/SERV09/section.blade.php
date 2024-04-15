<section id="SERV09" class="serv09">
    @if ($section->subtitle || $section->title || $section->description)
        <header class="serv09__header">

            @if ($section->subtitle)
                <h3 class="serv09__header__subtitle">{{ $section->subtitle }}</h3>
            @endif

            @if ($section->title)
                <h2 class="serv09__header__title">{{ $section->title }}</h2>
            @endif

            @if ($section->description)
                <div class="serv09__header__paragraph">
                    {!! $section->description !!}
                </div>
            @endif
        </header>
    @endif


    @if ($categories->count())
        <aside class="serv09__categories">
            <menu class="serv09__categories__swiper-wrapper swiper-wrapper">
                @foreach ($categories as $category)
                    <li class="serv09__categories__item swiper-slide">
                        <a href="{{ route('serv09.category.page', ['SERV09ServicesCategory' => $category->slug]) }}"
                            class="link-full" title="{{ $category->title }}">
                        </a>
                        @if ($category->path_image)
                            <img src="{{ asset('storage/' . $category->path_image) }}"
                                alt="Icone da categoria: {{ $category->title }}" class="serv09__categories__item__icon"
                                loading="lazy">
                        @endif
                        {{ $category->title }}
                    </li>
                @endforeach
            </menu>
        </aside>
    @endif

    @if ($services->count())
        <main class="serv09__main">
            <div class="serv09__main__carousel">
                <div class="serv09__main__carousel__swiper-wrapper swiper-wrapper">
                    @foreach ($services as $service)
                        <article class="serv09__main__item swiper-slide">

                            <a href="{{ route('serv09.page.content', ['SERV09ServicesCategory' => $service->categories->slug, 'SERV09Services' => $service->slug]) }}"
                                class="link-full" title="{{ $service->title }}">
                            </a>

                            <div class="serv09__main__item__information">

                                @if ($service->title)
                                    <h3 class="serv09__main__item__information__title">{{ $service->title }}</h3>
                                @endif

                                @if ($service->subtitle)
                                    <h4 class="serv09__main__item__information__subtitle">{{ $service->subtitle }}</h4>
                                @endif

                                @if ($service->price)
                                    <span class="serv09__main__item__information__price">
                                        R$ {{$service->price }}
                                    </span>
                                @endif

                                @if ($service->description)
                                    <div class="serv09__main__item__information__paragraph">
                                        <p>
                                            {!! $service->description !!}
                                        </p>
                                    </div>
                                @endif

                                @if ($service->topics->count())
                                    <ul class="serv09__main__item__information__topics">
                                        @foreach ($service->topics as $topic)
                                            <li class="serv09__main__item__information__topics__item">
                                                @if ($topic->path_image)
                                                    <img src="{{ asset('storage/' . $topic->path_image) }}"
                                                        alt="Ícone de {{ $topic->title }}" loading="lazy"
                                                        class="serv09__main__item__information__topics__item__icon">
                                                @endif

                                                {{ $topic->title }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if ($service->percentage)
                                    <div class="serv09__main__item__information__progress">

                                        <span class="serv09__main__item__information__progress__title">
                                            {{ $service->percentage === 100 ? 'Concluído' : 'Em andamento' }}
                                        </span>

                                        <div class="serv09__main__item__information__progress__bar">
                                            <span class="serv09__main__item__information__progress__bar__fill"
                                                style="width: {{$service->percentage}}%;"></span>
                                        </div>

                                        <span class="serv09__main__item__information__progress__number">
                                            {{$service->percentage}}%
                                        </span>
                                    </div>
                                @endif

                            </div>

                            <img src="{{ asset('storage/' . $service->path_image) }}"
                                alt="Imagem do serviço {{ $service->title }}" class="serv09__main__item__image">

                        </article>
                    @endforeach
                </div>

                <div class="serv09__main__carousel__swiper-pagination swiper-pagination"></div>

            </div>

            <a href="{{ route('serv09.category.page', ['SERV09ServicesCategory' => $categoryFirst->slug]) }}"
                class="serv09__main__cta">
                Ver mais
            </a>
        </main>
    @endif
</section>
