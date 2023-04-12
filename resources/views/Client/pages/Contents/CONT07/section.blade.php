@if ($section)
    <section id="CONT07" class="cont07 container-fluid px-0"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
        <div class="container container--pd px-0 mx-auto">
            @if ($section->title_section || $section->subtitle_seciton)
                <div class="cont07__emcompass text-center">
                    <h4 class="cont07__emcompass__title">{{ $section->title_section }}</h4>
                    <h5 class="cont07__emcompass__subtitle">{{ $section->subtitle_section }}</h5>
                </div>
            @endif
            <div class="cont07__content d-flex justify-content-center align-content-center">
                <div class="cont07__boxVideo">
                    @if ($video)
                        <div class="cont07__boxVideo__content">
                            @if ($video->link_video)
                                <a href="{{ $video->link_video }}" class="play" data-fancybox>
                                    <img class="trans-fast " src="{{ asset('storage/uploads/tmp/play.png') }}"
                                        alt="Play Vídeo">
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if ($contents->count())
            <div class="cont07__gallery carousel-gallery-cont07 owl-carousel mx-auto">
                @foreach ($contents as $content)
                    <div class="cont07__gallery__item">
                        @if ($content->link_video)
                            <a href="{{ $content->link_video }}" data-fancybox="galeria-video">
                                @if ($content->path_image)
                                    <img src="{{ asset('storage/' . $content->path_image) }}" />
                                @endif
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
        @if ($section->link_button)
            <a href="{{ $section->link_button }}" target="{{ $section->target_link_button }}"
                class="cont07__cta transition d-flex justify-content-center align-items-center">
                @if ($section->path_image_icon)
                    <img src="{{ asset('storage/' . $section->path_image_icon) }}" alt=""
                        class="cont07__cta__icon me-3 transition">
                @endif
                @if ($section->title_button)
                    {{ $section->title_button }}
                @endif
            </a>
        @endif
    </section>
@endif
{{-- END #cont07 --}}
