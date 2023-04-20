<section id="{{$portfolio->slug}}" class="port02__show" style="display: none;">
    <div class="row">
        <div class="port02__show__descritpion col-12 col-sm-5">
            <h3 class="port02__show__title">{{$portfolio->title}}</h3>
            <h4 class="port02__show__subtitle">{{$portfolio->subtitle}}</h4>
            <hr class="port02__show__line">
            <div class="port02__show__text">
                <p>{{$portfolio->text}}</p>
            </div>
        </div>
        <div class="port02__show__gallery col-12 col-sm-7">
            <div class="port02__show__gallery__main">
                <img src="{{asset('storage/'.$portfolio->path_image_box)}}" width="100%" height="100%" class="port02__show__gallery__main__item" alt="">
                <iframe width="100%" height="100%" class="port02__show__gallery__main__iframe" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            <div class="port02__show__gallery__thumbnail">
                <div class="port02__show__gallery__thumbnail__carousel">
                    <img src="{{asset('storage/'.$portfolio->path_image_box)}}" data-main-image="{{asset('storage/'.$portfolio->path_image_box)}}" width="100%" class="port02__show__gallery__thumbnail__item port02__show__gallery__thumbnail__item--active" alt="{{$portfolio->title}}">
                    @foreach ($portfolio->galleries as $gallery)
                        @if ($gallery->path_image)
                            <img src="{{asset('storage/'.$gallery->path_image)}}" data-main-image="{{$gallery->link_video?$gallery->link_video.'?controls=0':asset('storage/'.$gallery->path_image)}}" width="100%" class="port02__show__gallery__thumbnail__item {{$gallery->link_video?'port02__show__gallery__thumbnail__item--video':''}}" alt="{{$portfolio->title}}">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
