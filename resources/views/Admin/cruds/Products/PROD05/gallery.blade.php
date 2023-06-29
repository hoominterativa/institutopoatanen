<div class="prod05-show__info__gallery__wrap">
    <img src="{{ asset('storage/'.$galleries[0]->path_image) }}" width="100%" class="prod05-show__info__gallery__imgMain" alt="">
    <div class="prod05-show__info__gallery__carousel">
        @foreach ($galleries as $gallery)
            <img src="{{ asset('storage/'.$gallery->path_image) }}" class="prod05-show__info__gallery__thumbnail" alt="">
        @endforeach
    </div>
</div>
