@if ($brands->count() > 0)
    <section id="BRAN01" class="bran01">
        @if ($section)
            @if ($section->title_section)
                <header class="bran01__header">
                    @if ($section->title_section)
                        <h2 class="bran01__header__title">{!! $section->title_section !!}</h2>
                    @endif

                    {{-- @if ($section->subtitle_section)
                        <h3 class="bran01__header__subtitle">{{ $section->subtitle_section }}</h3>
                    @endif

                    @if ($section->title_section || $section->subtitle_section)
                        <hr class="bran01__header__line">
                    @endif

                    @if ($section->description_section)
                        <div class="bran01__header__paragraph">
                            {!! $section->description_section !!}
                        </div>
                    @endif --}}

                </header>
            @endif
        @endif

        @if ($brands->count())
            <main class="bran01__content">
                <div class="bran01__content__swiper-wrapper swiper-wrapper">
                    @foreach ($brands as $brand)
                        <article class="bran01__content__item swiper-slide"
                            style="background-image:url({{ asset('storage/' . $brand->path_image_box) }})">

                            @if ($brand->link)
                                <a
                                title="link para a marca"
                                href="{{ getUri($brand->link) }}" target="{{ $brand->target_link }}"
                                    class="link-full"></a>
                            @endif

                            @if ($brand->path_image_icon)
                                <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo da marca"
                                    loading="lazy" class="bran01__content__item__icon">
                            @endif
                        </article>
                    @endforeach

                </div>
            </main>
        @endif


        {{-- <a title="ir para a página" href="{{ route('bran01.page') }}" class="bran01__cta">
            CTA
        </a> --}}

    </section>
@endif
