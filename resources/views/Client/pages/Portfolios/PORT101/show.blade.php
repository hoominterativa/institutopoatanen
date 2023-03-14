@if ($sections)
    <div id="lightbox-port101-1" class="modal lightbox-port101 row px-0 mx-auto">
        @foreach ($portfolios as $portfolio)
            <div class="lightbox-port101__content modal__content"
                style="background-image:url({{ asset('storage/' . $portfolio->path_image_desktop) }});">
                <div class="row px-0 px-0 mx-0 w-100 h-100">
                    <div class="lightbox-port101__description p-5 col-md-6 d-block">
                        <h3 class="lightbox-port101__description__title">{{$portfolio->title}}</h3>
                        <h2 class="lightbox-port101__description__subtitle mb-0">{{$portfolio->subtitle}}</h2>
                        <hr class="lightbox-port101__description__line">
                        <div class="lightbox-port101__description__paragraph">
                            <p>
                                {{$portfolio->text}}
                            </p>
                        </div>
                        <a href="#"
                            class="lightbox-port101__description__cta transition d-flex justify-content-center align-items-center">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                class="lightbox-port101__description__cta__icon me-3 transition">
                            CTA
                        </a>
                    </div>
                    {{-- END .lightbox-port101__description --}}
                    <div class="lightbox-port101__galery col-md-6 px-0">
                        <div class="carousel-show-port101 owl-carousel">
                            <div class="item" data-hash="foto-1">
                                <a href="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" data-fancybox>
                                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" class="h-100 w-100"
                                        alt="Subtitulo">
                                </a>
                            </div>
                            <div class="item" data-hash="foto-2">
                                <a href="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" data-fancybox>
                                    <img src="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" class="h-100 w-100"
                                        alt="Subtitulo">
                                </a>
                            </div>
                            <div class="item" data-hash="foto-3">
                                <a href="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" data-fancybox>
                                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" class="h-100 w-100"
                                        alt="Subtitulo">
                                </a>
                            </div>
                            <div class="item" data-hash="foto-4">
                                <a href="{{ asset('storage/uploads/tmp/gall01_image12.png') }}" data-fancybox>
                                    <img src="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" class="h-100 w-100"
                                        alt="Subtitulo">
                                </a>
                            </div>
                        </div>
                        <div class="carousel-show-port101-nav owl-carousel">
                            <a id="foto-nav" href="#foto-1" tabindex="1">
                                <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" class="h-100 w-100"
                                    alt="Subtitulo">
                            </a>
                            <a id="foto-nav" href="#foto-2" tabindex="1">
                                <img src="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" class="h-100 w-100"
                                    alt="Subtitulo">
                            </a>
                            <a id="foto-nav" href="#foto-3" tabindex="1">
                                <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" class="h-100 w-100"
                                    alt="Subtitulo">
                            </a>
                            <a id="foto-nav"href="#foto-4" tabindex="1">
                                <img src="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" class="h-100 w-100"
                                    alt="Subtitulo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- END .lightbox-port101 --}}
@endif
