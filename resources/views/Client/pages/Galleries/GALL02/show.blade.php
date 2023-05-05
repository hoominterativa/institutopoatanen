<div id="lightbox-gall02-{{$gallery->id}}" class="lightbox-gall02 row">
    <div class="lightbox-gall02__content">
        <div class="container px-0 px-0 mx-auto">
            <div class="lightbox-gall02__top">
                @if ($gallery->title || $gallery->subtitle)
                    <div class="lightbox-gall02__top__description">
                        <h4 class="lightbox-gall02__top__description__title">{{$gallery->title}}</h4>
                        <h5 class="lightbox-gall02__top__description__subtitle">{{$gallery->subtitle}}</h5>
                    </div>
                @endif
            </div>
            <div class="lightbox-gall02__bottom">
                <div class="lightbox-gall02__bottom__main">
                    <img src="{{asset('storage/' .$gallery->path_image)}}"  width="100%" height="100%" class="lightbox-gall02__bottom__main__item" alt="">
                    <h4 class="lightbox-gall02__bottom__main__legend">{{$gallery->title}}</h4>
                </div>
                <div class="lightbox-gall02__bottom__thumbnail">
                    <div class="lightbox-gall02__bottom__thumbnail__carousel">
                        @foreach ($galleries as $gallery )
                            <img src="{{asset('storage/' . $gallery->path_image)}}" data-main-image="{{asset('storage/' . $gallery->path_image)}}" data-main-title="{{$gallery->title}}" width="100%" class="lightbox-gall02__bottom__thumbnail__item lightbox-gall02__bottom__thumbnail__item--active" alt="Imagem">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- END .lightbox-gall02 --}}

