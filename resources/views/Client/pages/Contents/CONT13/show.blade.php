<section id="lightbox-cont13-{{$content->id}}" class="lics"
    style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};">
    <div class="lics__mask"></div>
    <div class="container-fluid px-0 container--lightbox-lics-show">
        <main class="lics__main row mx-auto">
            <div class="lics__main__left col-sm-7">
                <header class="lics__main__left__header">
                    @if ($content->title || $content->subtitle)
                        <h2 class="lics__main__left__header__title">{{$content->title}}</h2>
                        <h3 class="lics__main__left__header__subtitle">{{$content->subtitle}}</h3>
                        <hr class="lics__main__left__header__line">
                    @endif
                    @if ($content->text)
                        <div class="lics__main__left__header__paragraph">
                            <p>
                                {!! $content->text !!}
                            </p>
                        </div>
                    @endif
                </header>
                @if ($content->galleries->count())
                    <div class="lics__main__left__engBox carousel-lics owl-carousel">
                        @foreach ($content->galleries as $gallery)
                            <div class="lics__main__left__engBox__box">
                                @if ($gallery->path_image)
                                    <img src="{{asset('storage/' . $gallery->path_image)}}" alt="Imagem da galeria">
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="lics__main__right col-sm-5">
                @if ($content->link)
                    <div class="lics__main__right__iframe">
                        <iframe width="100%" height="100%" src="{{getUri($content->link)}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                @endif
            </div>
        </main>
    </div>
</section>
