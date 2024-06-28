<div class="serv12-show" id="M{{$topic->id}}">
    <div class="serv12-show__information">
        @if ($topic->title)
            <h2 class="serv12-show__information__title">{{$topic->title}}</h2>
        @endif
        @if ($topic->subtitle)
            <h3 class="serv12-show__information__subtitle">{{$topic->subtitle}}
        @endif
        </h3>
        @if ($topic->text)
            <div class="serv12-show__information__paragraph">
                {!! $topic->text !!}
            </div>
        @endif
    </div>
    @if ($topic->galleries->count())
        <div class="serv12-show__gallery">
            <div class="serv12-show__gallery__carousel">
                <div class="serv12-show__gallery__carousel__swiper-wrapper swiper-wrapper">
                    @foreach ($topic->galleries as $gallery)
                        @if ($gallery->link_video)
                            <div class="serv12-show__gallery__carousel__item swiper-slide"
                                data-src="{{getUri($gallery->link_video)}}"
                                style="background-image: url({{ asset('storage/' . $gallery->path_image) }});">
                                <button class="serv12-show__gallery__carousel__item__button" title="Play">
                                    <img class="serv12-show__gallery__carousel__item__button__icon"
                                        src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                                </button>
                            </div>
                        @else
                            <img class="serv12-show__gallery__carousel__item swiper-slide"
                                src="{{ asset('storage/' . $gallery->path_image) }}" alt="{{$topic->title}}">
                        @endif
                    @endforeach
                </div>
                <div class="serv12-show__gallery__carousel__swiper-button-prev swiper-button-prev">
                </div>
                <div class="serv12-show__gallery__carousel__swiper-button-next swiper-button-next">
                </div>
                <div class="serv12-show__gallery__thumbs">
                    <div class="serv12-show__gallery__thumbs__swiper-wrapper swiper-wrapper">
                        @foreach ($topic->galleries as $gallery)
                            @if ($gallery->path_image)
                                <div class="serv12-show__gallery__thumbs__item swiper-slide"
                                    data-src="{{getUri($gallery->link_video)}}"
                                    style="background-image: url({{ asset('storage/' . $gallery->path_image) }});">
                                </div>
                            @else
                                <img class="serv12-show__gallery__thumbs__item swiper-slide"
                                    src="{{ asset('storage/' . $gallery->path_image) }}" alt="{{$topic->title}}">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
