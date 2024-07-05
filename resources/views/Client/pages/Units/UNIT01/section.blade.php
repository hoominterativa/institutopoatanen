    <section id="UNIT01" class="unit01">
        @if ($section)
            @if ($section->title_section || $section->subtitle_section)
                <header class="unit01__header">
                    @if ($section->title_section)
                        <h2 class="unit01__header__title">{{ $section->title_section }}</h2>
                    @endif
                    @if ($section->subtitle_section)
                        <h3 class="unit01__header__subtitle">{{ $section->subtitle_section }}</h3>
                    @endif
                </header>
            @endif
        @endif

        @if ($categories->count())
            <aside class="unit01__categories">
                <menu class="unit01__categories__swiper-wrapper swiper-wrapper">
                    @foreach ($categories as $category)
                        {{-- BACKEND: Ocultar do painel ícone da categoria $category->path_image --}}
                        <a class="unit01__categories__item swiper-slide" title="{{ $category->title }}"
                            href="{{ route('unit01.category.page', ['UNIT01UnitsCategory' => $category->slug]) }}">
                            {{ $category->title }}
                        </a>
                    @endforeach
                </menu>
            </aside>
        @endif

        @if ($units->count() > 0)
            <div class="unit01__main">
                @foreach ($units as $unit)
                    <article class="unit01__main__item">
                        <div class="unit01__main__item__information">
                            @if ($unit->title_unit)
                                <h4 class="unit01__main__item__information__title">{{ $unit->title_unit }}</h4>
                            @endif

                            @if ($unit->title)
                                <h5 class="unit01__main__item__information__subtitle">{{ $unit->title }}</h5>
                            @endif

                            @if ($unit->description)
                                <div class="unit01__main__item__information__paragraph">
                                    {!! $unit->description !!}
                                </div>
                            @endif
                            @if ($unit->topics->count() > 0)
                                <div class="unit01__main__item__information__topics">
                                    @foreach ($unit->topics as $topic)
                                        <div class="unit01__main__item__information__topics__item">

                                            @if ($topic->path_image_icon)
                                                <img loading='lazy'
                                                    src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                                    alt="Ícone do tópico  {{ $topic->title }}"
                                                    class="unit01__main__item__information__topics__item__image">
                                            @endif

                                            @if ($topic->title)
                                                <h6 class="unit01__main__item__information__topics__item__title">
                                                    {{ $topic->title }}</h6>
                                            @endif
                                            @if (!empty($topic->link))
                                                <a href="{{ getUri($topic->link) }}" target="_blank"
                                                    class="link-full"></a>
                                            @else
                                                <a data-fancybox="{{ $topic->title }}"
                                                    href="#unit01-show-{{ $topic->id }}" class="link-full"></a>
                                                @include('Client.pages.Units.UNIT01.show', [
                                                    'topic' => $topic,
                                                    'galleries' => $unit->galleries,
                                                ])
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        @if ($unit->galleries->count() > 0)
                            <div class="unit01__main__item__gallery">
                                <div class="unit01__main__item__gallery__swiper-wrapper swiper-wrapper">
                                    @foreach ($unit->galleries as $gallery)
                                        <img class="unit01__main__item__gallery__item swiper-slide"
                                            src="{{ asset('storage/' . $gallery->path_image) }}"
                                            alt="Imagem relacionada ao {{ $unit->title_unit }}" loading='lazy'>
                                    @endforeach
                                </div>

                                <div class="unit01__main__item__gallery__swiper-button-prev swiper-button-prev"></div>
                                <div class="unit01__main__item__gallery__swiper-button-next swiper-button-next"></div>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @endif
    </section>
