<section id="GALL02" class="gall02 container-fluid" style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
    <div class="container">
        <header class="header-gall02">
            @if ($section->title || $section->subtitle)
                <h3 class="container-title">
                    <span class="title">{{$section->title}}</span>
                    <span class="subtitle">{{$section->subtitle}}</span>
                    <hr class="line">
                </h3>
            @endif
        </header>
        @if ($galleries->count())
            <div class="gall02__content">
                <div class="carousel-gall02 owl-carousel">
                    @foreach ($galleries as $gallery)
                        <article class="box-gall02 w-100">
                            <a href="#lightbox-gall02-{{$gallery->id}}" data-fancybox class="link-full"></a>
                            <div class="content transition">
                                <figure class="image">
                                    @if ($gallery->path_image)
                                        <img src="{{asset('storage/' . $gallery->path_image)}}" loading="lazy" alt="">
                                    @endif
                                </figure>
                                @if ($gallery->title)
                                    <div class="description w-100">
                                        <h3 class="title">{{$gallery->image_legend}}</h3>
                                    </div>
                                @endif
                            </div>
                            @include('Client.pages.Galleries.GALL02.show', [
                                'gallery' => $gallery
                            ])
                        </article>
                    @endforeach
                    {{-- END .box-gall02 --}}
                </div>
            </div>
        @endif
    </div>
</section>
