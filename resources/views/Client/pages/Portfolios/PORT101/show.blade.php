<div id="lightbox-port101-{{ $portfolio->id }}" class="modal lightbox-port101 row px-0 mx-auto">
    <div class="lightbox-port101__content modal__content"
        style="background-image:url({{ asset('storage/' . $portfolio->path_image_desktop) }});">
        <div class="row px-0 px-0 mx-0 w-100 h-100">
            <div class="lightbox-port101__description p-5 col-md-6 d-block">
                <h3 class="lightbox-port101__description__title">{{ $portfolio->title }}</h3>
                <h2 class="lightbox-port101__description__subtitle mb-0">{{ $portfolio->subtitle }}</h2>
                <hr class="lightbox-port101__description__line">
                <div class="lightbox-port101__description__paragraph">
                    <p>
                        {!! $portfolio->text !!}
                    </p>
                </div>
                @if ($portfolio->link_button)
                    <a href="{{ $portfolio->link_button }} " target="{{ $portfolio->target_link_button }}"
                        class="lightbox-port101__description__cta transition d-flex justify-content-center align-items-center">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                            class="lightbox-port101__description__cta__icon me-3 transition">
                        CTA
                    </a>
                @endif
            </div>
            {{-- END .lightbox-port101__description --}}
            @if ($portfolio->galleries->count())
                <div class="lightbox-port101__galery col-md-6 px-0">
                    <div class="carousel-show-port101 owl-carousel">
                        @foreach ($portfolio->galleries as $gallery)
                            <div class="item" data-hash="foto-{{ $gallery->id }}">
                                <a href="{{ $gallery->link_video != '' ? $gallery->link_video : asset('storage/' . $gallery->path_image) }}"
                                    data-fancybox>
                                    <img src="{{ asset('storage/' . $gallery->path_image) }}" class="h-100 w-100"
                                        alt="Subtitulo">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="carousel-show-port101-nav owl-carousel">
                        @foreach ($portfolio->galleries as $gallery)
                            <a id="foto-nav" href="#foto-{{ $gallery->id }}" tabindex="1">
                                <img src="{{ asset('storage/' . $gallery->path_image) }}" class="h-100 w-100"
                                    alt="Subtitulo">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- END .lightbox-port101 --}}
