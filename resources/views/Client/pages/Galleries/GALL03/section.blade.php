<section id="GALL03" class="gall03 container-fluid">
    <div class="container">
        @if ($section)
            <header class="gall03__header w-100 d-flex flex-column align-items-center">
                @if ($section->title || $section->subtitle)
                    <h2 class="gall03__header__title text-center">{{$section->title}}</h2>
                    <h3 class="gall03__header__subtitle text-center">{{$section->subtitle}}</h3>
                    <hr class="gall03__header__line">
                @endif
            </header>
        @endif
        @if ($galleries)
            <main class="gall03__carousel owl-carousel">
                @foreach ($galleries as $gallery)
                    <div class="gall03__carousel__item">
                        <a href="#lightbox-gall03{{$gallery->id}}" data-fancybox class="link-full"></a>
                        @if ($gallery->path_image)
                            <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="" class="gall03__carousel__item__image">
                        @endif
                        @if ($gallery->title)
                            <h4 class="gall03__carousel__item__title">
                                {{$gallery->title}}
                            </h4>
                        @endif
                        @include('Client.pages.Galleries.GALL03.show', [
                            'gallery' => $gallery
                        ])
                    </div>
                @endforeach
            </main>
        @endif

    </div>
</section>
