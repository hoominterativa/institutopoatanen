<div id="lightbox-unit01-1-{{$topic->id}}" class="lightbox-unit01 row px-0">
    <div class="row px-0 px-0 mx-0">
        <div class="lightbox-unit01__left px-0 col-md-6">
            <div class="unit01-show-carousel owl-carousel">
                @foreach ($galleries as $gallery)
                <div class="lightbox-unit01__image">
                    <img src="{{asset('storage/' . $gallery->path_image)}}" class="h-100 w-100" alt="Subtitulo">
                </div>
                 @endforeach
            </div>
        </div>
        
        {{-- END .lightbox-unit01__image --}}
        <div class="lightbox-unit01__description p-5 col-md-6 d-block">
            <h3 class="lightbox-unit01__subtitle">{{$topic->subtitle}}</h3>
            <h2 class="lightbox-unit01__title mb-0"><img src="{{asset('storage/' . $topic->path_image_icon)}}" alt="Logo">{{$topic->title}}</h2>
            <hr class="lightbox-unit01__line">
            <div class="lightbox-unit01__paragraph">
                @if ($topic->description)
                    <p>
                        {!! $topic->description !!}
                    </p>
                @endif
            </div>
        </div>
        {{-- END .lightbox-unit01__description --}}
    </div>
</div>
{{-- END .lightbox-unit01 --}}

