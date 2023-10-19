<div id="lightbox-abou02-{{$topic->id}}" class="lightbox-abou02 row">
    <div class="row px-0 px-0 mx-0">
        @if ($topic->path_image)
            <div class="lightbox-abou02__image px-0 col-md-6">
                <img src="{{asset('storage/' . $topic->path_image )}}" class="h-100 w-100" alt="Subtitulo">
            </div>
        @endif
        {{-- END .lightbox-abou02__image --}}
        <div class="lightbox-abou02__description p-5 col-md-6 d-block">
            @if ($topic->title || $topic->subtitle)
                <h3 class="lightbox-abou02__subtitle">{{$topic->subtitle}}</h3>
                <h2 class="lightbox-abou02__title mb-0">{{$topic->title}}</h2>
                <hr class="lightbox-abou02__line">
            @endif
            @if ($topic->text)
                <div class="lightbox-abou02__paragraph">
                    <p>{!! $topic->text !!}</p>
                </div>
            @endif
        </div>
        {{-- END .lightbox-abou02__description --}}
    </div>
</div>
{{-- END .lightbox-abou02 --}}

