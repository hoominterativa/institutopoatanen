<section id="unit01-show-{{$topic->id}}" class="unit01-show">
        <div class="unit01-show__carousel">
            <div class="unit01-show__carousel__swiper-wrapper swiper-wrapper">
                @foreach ($galleries as $gallery)
                    <img src="{{asset('storage/' . $gallery->path_image)}}" class="unit01-show__carousel__item swiper-slide" alt="Imagem da galeria de {{$topic->title}}">

                 @endforeach
            </div>

            <div class="unit01-show__carousel__nav__swiper-button-prev swiper-button-prev"></div>
            <div class="unit01-show__carousel__nav__swiper-button-next swiper-button-next"></div>
        </div>

        <div class="unit01-show__information">
            <header class="unit01-show__information__header">
                <h3 class="unit01-show__information__header__subtitle">{{$topic->subtitle}}</h3>
                <h2 class="unit01-show__information__header__title">
                    {{$topic->title}}
                </h2>
                <img src="{{asset('storage/' . $topic->path_image_icon)}}" class="unit01-show__information__header__icon" alt="{{$topic->title}}">
            </header>
            @if ($topic->description)
                <div class="unit01-show__information__paragraph">
                        {!! $topic->description !!}
                </div>
            @endif
        </div>

</section>


