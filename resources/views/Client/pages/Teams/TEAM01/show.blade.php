<div id="lightbox-team01-{{$team->slug}}" class="lightbox-team01 row">
    <div class="row px-0 px-0 mx-0">
        <div class="lightbox-team01__content__carrossel row px-0 mx-auto">
            <div class="px-0 col-md-6">
                    <div class="lightbox-team01__image h-100">
                        @if ($team->path_image_box)
                            <img src="{{asset('storage/' . $team->path_image_box)}}" class="h-100 w-100" alt="Subtitulo">
                        @endif
                    </div>
                {{-- END .caroussel_team01-show --}}
            </div>
            {{-- END .lightbox-team01__content__carrossel --}}
            <div class="lightbox-team01__description col-md-6 d-block">
                <div class="lightbox-team01__encompass">
                    <div class="lightbox-team01__navigationTitle px-0">
                        @if ($team->title || $team->subtitle)
                            <h2 class="lightbox-team01__title mb-0">{{$team->title}}</h2>
                            <h3 class="lightbox-team01__subtitle mb-0">{{$team->subtitle}}</h3>
                        @endif
                    </div>
                    <div class="lightbox-team01__navigation px-0">
                        @foreach ($team->socials as $social )
                            <a href="{{$social->link ? getUri($social->link) : 'javascript:void(0)'}}" target="{{ $social->target_link }}" rel="prev">
                                @if ($social->path_image_icon)
                                    <img src="{{asset('storage/' . $social->path_image_icon)}}" alt="Ícone Voltar">
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
                <hr class="lightbox-team01__line">
                <div class="lightbox-team01__paragraph">
                    @if ($team->text)
                        <p>
                            {!! $team->text !!}
                        </p>
                    @endif
                </div>
                <a rel="next" href="{{$team->link_button ? getUri($team->link_button) : 'javascript:void(0)'}}" target="{{ $team->target_link_button }}" class="lightbox-team01__cta transition d-flex">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="lightbox-team01__cta__icon me-3 transition">
                    @if ($team->title_button)
                        {{ $team->title_button }}
                    @endif
                </a>
            </div>
         {{-- END .caroussel_team01-show --}}
        </div>
        {{-- END .lightbox-team01__description --}}
    </div>
</div>
{{-- END .lightbox-team01 --}}
