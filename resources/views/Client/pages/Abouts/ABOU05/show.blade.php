<div id="lightbox-abou05-{{$content->id}}" class="lightbox-abou05 row">
    <div class="row px-0 px-0 mx-0">
        <div class="lightbox-abou05__content__carrossel row px-0 mx-auto">
            <div class="px-0 col-md-6">
                <div class="lightbox-abou05__image h-100">
                    @if ($content->path_image_inner)
                        <img src="{{asset('storage/' . $content->path_image_inner)}}" class="h-100 w-100" alt="Subtitulo">
                    @endif
                </div>
                {{-- END .caroussel_abou05-show --}}
            </div>
            {{-- END .lightbox-abou05__content__carrossel --}}
            <div class="lightbox-abou05__description col-md-6 d-block">
                <div class="lightbox-abou05__encompass">
                    <div class="lightbox-abou05__navigationTitle px-0">
                        <h2 class="lightbox-abou05__title mb-0">{{$content->title_inner}}</h2>
                        <h3 class="lightbox-abou05__subtitle mb-0">{{$content->subtitle_inner}}</h3>
                    </div>
                    <div class="lightbox-abou05__navigation px-0">
                        @foreach ($content->socials as $social)
                            @if ($social->link)
                                <a href="{{getUri($social->link)}}" target="_blank" rel="prev">
                                    @if ($social->path_image)
                                        <img src="{{asset('storage/' . $social->path_image)}}" alt="Ícone Voltar">
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr class="lightbox-abou05__line">
                <div class="lightbox-abou05__paragraph">
                    <p>
                        {!! $content->text_inner !!}
                    </p>
                </div>
            </div>
         {{-- END .caroussel_abou05-show --}}
        </div>
        {{-- END .lightbox-abou05__description --}}
    </div>
</div>
{{-- END .lightbox-abou05 --}}
