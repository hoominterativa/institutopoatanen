@if ($section)
    <section id="CONT14" class="cont14">

        @if ($section->title)
            <h4 class="cont14__title">{{ $section->title }}</h4>
        @endif

        <div class="cont14__categories">
            @if ($categories->count())
                <menu class="cont14__categories__swiper-wrapper swiper-wrapper">
                    @foreach ($categories as $category)
                        <button data-url="{{ route('cont14.show', ['CONT14ContentsCategory' => $category->id]) }}"
                            class="cont14__categories__item swiper-slide {{ $categoryFirst->id == $category->id ? 'active' : '' }}">{{ $category->title }}</button>
                    @endforeach
                </menu>
            @endif
        </div>

        <div class="cont14__information">
            <div class="cont14__information__carousel">
                <div class="cont14__information__carousel__swiper-wrapper swiper-wrapper">
                    @foreach ($contents as $content)
                        <div class="cont14__information__item swiper-slide">
                            @if ($content->title)
                                <h2 class="cont14__information__item__title">{{ $content->title }}</h2>
                            @endif

                            @if ($content->subtitle)
                                <h3 class="cont14__information__item__subtitle">{{ $content->subtitle }}o</h3>
                            @endif

                            @if ($content->path_image || $content->link)
                                @if ($content->path_image)
                                    <img src="{{ asset('storage/' . $content->path_image) }}"
                                        class="cont14__information__item__image" alt="Imagem">
                                @else
                                    <iframe class="cont14__information__item__iframe" src="{{ getUri($content->link) }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                @endif
                            @endif

                            @if ($content->description)
                                <div class="cont14__information__item__paragraph">
                                    <p>
                                        {!! $content->description !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </section>
@endif
