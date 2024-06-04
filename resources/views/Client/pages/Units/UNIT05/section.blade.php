@if ($section || $galleries->count() || $categories->count() || $subcategories->count())
    <section class="unit05">
        @if ($categories->count())
            <menu class="unit05__categories">
                <div class="unit05__categories__swiper-wrapper swiper-wrapper">
                    @foreach ($categories as $category)
                        <a title="{{$category->title}}" href="{{ route('unit05.category.page', ['UNIT05UnitsCategory' => $category->slug]) }}"
                            class="unit05__categories__item swiper-slide {{ $category->id == $categoryFirst->id ? 'active' : '' }}">
                            {{$category->title}}
                        </a>
                    @endforeach
                </div>
            </menu>
        @endif

        <div class="unit05__content">
            @if ($galleries->count())
                <div class="unit05__content__gallery">
                    <div class="unit05__content__gallery__swiper-wrapper swiper-wrapper">
                        @foreach ($galleries as $gallery)
                            @if ($gallery->path_image)
                                <img src="{{ asset('storage/'. $gallery->path_image) }}" loading='lazy'
                                alt="Banner da seção {{$section->title_section ? $section->title_section : $section->subtitle_section}}" class="unit05__content__gallery__item swiper-slide">
                            @endif
                        @endforeach
                    </div>
                    <div class="unit05__content__gallery__nav__swiper-button-prev swiper-button-prev"></div>
                    <div class="unit05__content__gallery__nav__swiper-button-next swiper-button-next"></div>
                </div>
            @endif

            <div class="unit05__content__information">
                @if ($section->subtitle_section)
                    <h3 class="unit05__content__information__subtitle">{{$section->subtitle_section}}</h3>
                @endif
                @if ($section->title_section)
                    <h2 class="unit05__content__information__title">{{$section->title_section}}</h2>
                @endif
                @if ($section->description_section)
                    <div class="unit05__content__information__paragraph">
                        <p>{!! $section->description_section !!}</p>
                    </div>
                @endif

                @if ($subcategories->count())
                    <div class="unit05__content__information__subcategories">
                        <div class="unit05__content__information__subcategories__swiper-wrapper swiper-wrapper">
                            @foreach ($subcategories as $subcategory)
                                <div class="unit05__content__information__subcategories__item swiper-slide">
                                    @if ($subcategory->path_image_icon)
                                        <img src="{{ asset('storage/' . $subcategory->path_image_icon) }}" alt="Ícone de {{$subcategory->title}}" loading='lazy'
                                            class="unit05__content__information__subcategories__item__icon">
                                    @endif
                                    @if ($subcategory->title)
                                    {{-- FRONTEND Corrigir título e link full --}}
                                    <a title="{{$subcategory->title}}" href="{{ route('unit05.subcategory.page', ['UNIT05UnitsCategory' => $category->slug, 'UNIT05UnitsSubcategory' => $subcategory->slug]) }}"
                                        class="unit05__content__information__subcategories__item__title">
                                        {{$subcategory->title}}
                                    </a>
                                    @endif
                                    @if ($subcategory->description)
                                        <p class="unit05__content__information__subcategories__item__paragraph">
                                            {!! $subcategory->description !!}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="unit05__content__information__subcategories__nav">
                            <div class="unit05__content__information__subcategories__nav__swiper-button-prev swiper-button-prev"></div>
                            <div class="unit05__content__information__subcategories__nav__swiper-button-next swiper-button-next"></div>
                        </div>
                    </div>
                @endif
                <a href="{{ route('unit05.category.page', ['UNIT05UnitsCategory' => $categoryFirst->slug]) }}" class="unit05__content__information__cta">CTA</a>
            </div>
        </div>
        {{-- FRONTEND Imagem desktop --}}
        @if ($section->path_image_desktop_section)
            <img src="{{ asset('storage/'. $section->path_image_desktop_section) }}" loading='lazy'
            alt="Banner da seção {{$section->title_section ? $section->title_section : $section->subtitle_section}}" class="unit05__section-banner">
        @endif
        {{-- FRONTEND Imagem mobile --}}
        @if ($section->path_image_mobile_section)
            <img src="{{ asset('storage/'. $section->path_image_mobile_section) }}" loading='lazy'
            alt="Banner da seção {{$section->title_section ? $section->title_section : $section->subtitle_section}}" class="unit05__section-banner">
        @endif
    </section>
@endif
