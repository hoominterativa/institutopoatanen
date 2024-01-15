<section id="BRAN01" class="bran01">
    @if ($section)
        <header class="bran01__header">
            @if ($section->title_section || $section->subtitle_section)
                <h2 class="bran01__header__title">{{ $section->title_section }}</h2>
                <h3 class="bran01__header__subtitle">{{ $section->subtitle_section }}</h3>
                <hr class="bran01__header__line">
            @endif

            @if ($section->description_section)
                <div class="bran01__header__paragraph">
                    <p>
                        {!! $section->description_section !!}
                    </p>
                </div>
            @endif

        </header>
    @endif

    @if ($brands->count())
        <div class="bran01__content">
            <div class="bran01__content__carousel owl-carousel">

                @foreach ($brands as $brand)
                    <article class="bran01__content__item"
                        style="background-image:url({{ asset('storage/' . $brand->path_image_box) }})">
                        <a href="{{ getUri($brand->link ?? '#') }}"
                            target="{{ $brand->link ? $brand->target_link : null }}"
                            @if (!$brand->link) style="cursor: default;" @endif class="link-full"></a>

                        @if ($brand->path_image_icon)
                            <div class="bran01__content__item__image">
                                <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo"
                                    loading="lazy" class="bran01__content__item__image__img">
                            </div>
                        @endif
                    </article>
                @endforeach

            </div>
        </div>
    @endif


    <a rel="next" href="{{ route('bran01.page') }}"class="bran01__cta">
        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Icone CTA"class="bran01__cta__icon">
        CTA
    </a>

</section>
{{-- END .bran01 --}}
