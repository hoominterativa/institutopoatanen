<section id="gall02-show{{ $gallery->id }}" class="gall02-show">
    @if ($gallery->title || $gallery->subtitle)
        <header class="gall02-show__header">
            @if ($gallery->title)
                <h2 class="gall02-show__header__title">{{ $gallery->title }}</h2>
            @endif

            @if ($gallery->subtitle)
                <h3 class="gall02-show__header__subtitle">{{ $gallery->subtitle }}</h3>
            @endif
        </header>
    @endif


    {{-- <figure class="gall02-show__gallery">
        <img src="{{ asset('storage/' . $gallery->path_image) }}" class="gall02-show__gallery__item"
            alt="{{ $gallery->image_legend }}">
        <figcaption class="gall02-show__gallery__item__legend">{{ $gallery->image_legend }}</figcaption>
    </figure> --}}

    <div class="gall02-show__gallery">
        <figure class="gall02-show__gallery__swipper-wrapper swiper-wrapper">
            @foreach ($gallery->images as $image)
                <img class="gall02-show__gallery__item swiper-slide " src="{{ asset('storage/' . $image->path_image) }}"
                alt="{{ $gallery->image_legend }}">
            @endforeach
            <figcaption class="gall02-show__gallery__description">
                {{ $gallery->image_legend }}
            </figcaption>
        </figure>
        <div class="gall02-show__gallery__swiper-button-prev swiper-button-prev"></div>
        <div class="gall02-show__gallery__swiper-button-next swiper-button-next"></div>
    </div>
    <div class="gall02-show__thumbs">
        <div class="gall02-show__thumbs__swiper-wrapper swiper-wrapper">
            @foreach ($gallery->images as $image)
                <img src="{{ asset('storage/' . $image->path_image) }}"
                    class="gall02-show__thumbs__item swiper-slide"  alt="{{ $gallery->image_legend }}">
            @endforeach
        </div>


    </div>


</section>
