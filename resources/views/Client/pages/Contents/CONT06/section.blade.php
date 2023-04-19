@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT06" class="cont06 container-fluid px-0"
            style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};">
            <div class="d-flex justify-content-center align-content-center">
                <div class="cont06__boxVideo">
                    @if ($content->link_video)
                        <div class="cont06__boxVideo__content">
                            <div id="videoApre"
                                class="cont06__boxVideo__content__video d-flex justify-content-center align-items-center"
                                data-src="{{$content->link_video}}" data-capa-video="{{ asset('storage/' . $content->path_image) }}" style="background-image: url({{ asset('storage/' . $content->path_image) }});">
                                <img class="trans-fast play" src="{{ asset('storage/uploads/tmp/play.png') }}"
                                    alt="Play Vídeo">
                            </div>
                        </div>
                    @endif
                    @if ($content->link_button)
                        <a href="{{ $content->link_button }}" target="{{ $content->target_link }}"
                            class="cont06__boxVideo__cta transition d-flex justify-content-center align-items-center">
                            @if ($content->path_image_icon)
                                <img src="{{ asset('storage/' . $content->path_image_icon) }}" alt=""
                                    class="cont06__cta__icon me-3 transition">
                            @endif
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
