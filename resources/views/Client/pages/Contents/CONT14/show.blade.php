<div id="cont14__right__engBox" class="cont14__right__engBox">
    <div class="carousel-gallery-cont14 owl-carousel">
        @foreach ($contents as $content)
            <div class="cont14__right__engBox__box">
                <h4 class="cont14__right__engBox__box__title">{{$content->title}}</h4>
                <h5 class="cont14__right__engBox__box__subtitle">{{$content->subtitle}}</h5>
                <div class="cont14__right__engBox__box__image">
                    @if ($content->path_image)
                        <img src="{{asset('storage/'.$content->path_image)}}" class="h-100 w-100" alt="Imagem">
                    @else
                    <iframe width="100%" height="100%" src="{{getUri($content->link)}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    @endif
                </div>
                <div class="cont14__right__engBox__box__paragraph">
                    <p>
                        {!! $content->description !!}
                    </p>
                </div>
            </div>
            <!-- Fim-cont14__right__box -->
        @endforeach
    </div>
</div>
