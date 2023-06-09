<div class="lightbox-gall03" id="lightbox-gall03{{$gallery->id}}">
    <div class="lightbox-gall03__content container">
        <div class="lightbox-gall03__top">
            @if ($gallery->title)
                <h4 class="lightbox-gall03__title">{{$gallery->title}}</h4>
            @endif
        </div>
        <div class="lightbox-gall03__bottom">
            <div class="lightbox-gall03__bottom__main">
                @if ($gallery->path_image || $gallery->image_legend)
                    <img src="{{ asset('storage/' . $gallery->path_image) }}" width="100%" height="100%"
                    class="lightbox-gall03__bottom__main__item" alt="">
                    <h4 class="lightbox-gall03__bottom__main__legend">{{$gallery->image_legend}}</h4>
                @endif
            </div>
            <div class="lightbox-gall03__bottom__thumbnail">
                <div class="lightbox-gall03__bottom__thumbnail__carousel">
                    @if ($gallery->path_image || $gallery->image_legend)
                        <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Imagem"
                        data-main-image="{{ asset('storage/' . $gallery->path_image) }}"
                        data-main-title=" {{$gallery->image_legend}} ">
                    @endif
                    @foreach ($gallery->images as $image)
                        <img src="{{ asset('storage/' . $image->path_image) }}" alt="Imagem"
                        data-main-image="{{ asset('storage/' . $image->path_image) }}"
                        data-main-title=" {{$gallery->image_legend}} ">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
