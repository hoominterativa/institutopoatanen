    <section id="UNIT01" class="unit01">
        @if ($section)
            @if ($section->title_section || $section->subtitle_section)
                <header class="unit01-section__header">
                    @if ($section->title_section)
                        <h2 class="unit01-section__header__title">{{ $section->title_section }}</h2>
                    @endif
                    @if ($section->subtitle_section)
                        <h3 class="unit01-section__header__subtitle">{{ $section->subtitle_section }}</h3>
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
                            @if ($unit->title_unit || $unit->title)
                                <h4 class="">{{ $unit->title_unit }}
                                </h4>
                                <h4 class="">{{ $unit->title }}
                                </h4>
                            @endif
                            <div class="">
                                @if ($unit->description)
                                    <p>
                                        {!! $unit->description !!}
                                    </p>
                                @endif
                            </div>
                            <div class="">
                                @foreach ($unit->topics as $topic)
                                    <div class="">
                                        @if ($topic->link !== '' && $topic->target_link == '_blank')
                                            <a rel="next" href="{{ getUri($topic->link) }}"
                                                target="{{ $topic->target_link }}">
                                                <div class="">
                                                    <img src="{{ asset('storage/uploads/tmp/image-box.jpg') }}"
                                                        class="" alt="Logo">
                                                </div>
                                                <div class="">
                                                    <div class="">
                                                        @if ($topic->path_image_icon)
                                                            <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                                                alt="Ícone" class="">
                                                        @endif
                                                    </div>
                                                    @if ($topic->title)
                                                        <h2 class="">
                                                            {{ $topic->title }}</h2>
                                                    @endif
                                                </div>
                                            </a>
                                        @else
                                            <div data-fancybox="{{ $topic->title }}"
                                                data-src="#lightbox-unit01-1-{{ $topic->id }}">
                                                <div class="">
                                                    <img src="{{ asset('storage/uploads/tmp/image-box.jpg') }}"
                                                        class="" alt="Logo">
                                                </div>
                                                <div class="">
                                                    <div class="">
                                                        @if ($topic->path_image_icon)
                                                            <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                                                alt="Ícone" class="">
                                                        @endif
                                                    </div>
                                                    @if ($topic->title)
                                                        <h2 class="">
                                                            {{ $topic->title }}</h2>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @include('Client.pages.Units.UNIT01.show', [
                                            'topic' => $topic,
                                            'galleries' => $unit->galleries,
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if ($unit->galleries)
                            <div class="unit01__main__item__gallery">
                                <div class="unit01__main__item__gallery__swiper-wrapper swiper-wrapper">
                                    @foreach ($unit->galleries as $gallery)
                                        <div class="unit01__main__item__gallery__item" {{-- data-fancybox="galeria"
                                            data-src="{{ asset('storage/' . $gallery->path_image) }}" --}}>
                                            {{-- <a href="{{ asset('storage/' . $gallery->path_image) }}"
                                                data-fancybox="galeria"> --}}
                                            <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Imagem"
                                                class="">

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @endif
    </section>
