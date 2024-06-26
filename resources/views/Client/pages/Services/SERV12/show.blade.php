{{-- BACKEND A SUA SHOW É A DIV ABAIXO. PODE RECORTAR E COLAR NA SHOW.BLADE --}}
<div class="serv12-show" id="M{{ $i }}">
    <div class="serv12-show__information">
        <h2 class="serv12-show__information__title">Título do tópico {{ $i }}</h2>
        <h3 class="serv12-show__information__subtitle">Subtítulo do tópico {{ $i }}
        </h3>
        <div class="serv12-show__information__paragraph">
            <p>descrição especifica do tópico</p>
        </div>
    </div>
    <div class="serv12-show__gallery">
        <div class="serv12-show__gallery__carousel">
            <div class="serv12-show__gallery__carousel__swiper-wrapper swiper-wrapper">
                @for ($j = 0; $j < 10; $j++)
                    <img class="serv12-show__gallery__carousel__item swiper-slide"
                        src="{{ asset('images/imageServ.png') }}" alt="{{-- Título do tópico --}}">
                @endfor
                {{-- BACKEND: PARA QUANDO HOUVER VIDEO --}}
                <div class="serv12-show__gallery__carousel__item swiper-slide"
                    data-src="https://www.youtube.com/embed/MfZDZpY9Oog"
                    style="background-image: url({{ asset('images/banner.png') }});">
                    <button class="serv12-show__gallery__carousel__item__button" title="Play">
                        <img class="serv12-show__gallery__carousel__item__button__icon"
                            src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                    </button>
                </div>
            </div>
            <div class="serv12-show__gallery__carousel__swiper-button-prev swiper-button-prev">
            </div>
            <div class="serv12-show__gallery__carousel__swiper-button-next swiper-button-next">
            </div>
            <div class="serv12-show__gallery__thumbs">
                <div class="serv12-show__gallery__thumbs__swiper-wrapper swiper-wrapper">
                    @for ($j = 0; $j < 10; $j++)
                        <img class="serv12-show__gallery__thumbs__item swiper-slide"
                            src="{{ asset('images/imageServ.png') }}"
                            alt="{{-- Título do tópico --}}">
                    @endfor
                    {{-- BACKEND: PARA QUANDO HOUVER VIDEO --}}
                    <div class="serv12-show__gallery__thumbs__item swiper-slide"
                        data-src="https://www.youtube.com/embed/MfZDZpY9Oog"
                        style="background-image: url({{ asset('images/banner.png') }});">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- BACKEND END-SHOW --}}
