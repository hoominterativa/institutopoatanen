@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT06" class="cont06 container-fluid px-0" style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};">
            <div class="d-flex justify-content-center align-content-center flex-column">
                @if ($content->title || $content->description)
                    <header class="cont06__header">
                        @if ($content->title)
                            <h3 class="cont06__header__title">
                                {{$content->title}}
                                <hr class="cont06__header__line">
                            </h3>
                        @endif
                        @if ($content->description)
                            <p class="cont06__header__paragraph">{!! $content->description !!}</p>
                        @endif
                    </header>
                @endif
                <div class="cont06__boxVideo">
                    @if ($content->link_video)
                        <div class="cont06__boxVideo__content">
                            <div id="videoApre" class="cont06__boxVideo__content__video d-flex justify-content-center align-items-center" data-src="{{getUri($content->link_video)}}" data-capa-video="{{ asset('storage/' . $content->path_image) }}" style="background-image: url({{ asset('storage/' . $content->path_image) }});">
                                <img class="trans-fast play" src="{{ asset('storage/uploads/tmp/play.png') }}" alt="Play Vídeo">
                            </div>
                        </div>
                    @endif
                    @if ($content->link_button)
                        <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link }}"
                            class="cont06__boxVideo__cta transition d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícone" class="cont06__cta__icon me-3 transition">
                            @if ($content->title_button)
                                {{ $content->title_button }}
                            @endif
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @endforeach
@endif
{{-- END #CONT06 --}}
