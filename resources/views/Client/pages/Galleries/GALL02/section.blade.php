<section id="GALL02" class="gall02">
    @if ($section)
        @if ($section->title || $section->subtitle)
            <header class="gall02__header">
                @if ($section->title)
                    <h2 class="gall02__header__title">{{ $section->title }}</h2>
                @endif

                @if ($section->subtitle)
                    <h3 class="gall02__header__subtitle">{{ $section->subtitle }}</h3>
                @endif
            </header>
        @endif
    @endif
    @if ($galleries->count())
        <main class="gall02__gallery">
            <div class="gall02__gallery__carousel">
                <div class="gall02__gallery__carousel__swiper-wrapper swiper-wrapper">
                    @foreach ($galleries as $gallery)
                        <figure role="button" class="gall02__gallery__item swiper-slide" data-src="#gall02-show{{ $gallery->id }}" data-fancybox>

                            @if ($gallery->path_image)
                                <img
                                class="gall02__gallery__item__img"
                                src="{{ asset('storage/' . $gallery->path_image) }}" loading="lazy" alt="">
                            @endif

                            @if ($gallery->image_legend)
                                <figcaption class="gall02__gallery__item__description">
                                    {{ $gallery->image_legend }}
                                </figcaption>
                            @endif

                            @include('Client.pages.Galleries.GALL02.show', [
                                'gallery' => $gallery,
                            ])
                        </figure>
                    @endforeach
                </div>

                <div class="gall02__gallery__nav">
                    <div class="gall02__gallery__nav__swiper-button-prev swiper-button-prev"></div>
                    <div class="gall02__gallery__nav__swiper-button-next swiper-button-next"></div>
                </div>
            </div>

        </main>
    @endif

</section>
