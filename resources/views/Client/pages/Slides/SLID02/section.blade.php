@if ($slides->count())
    <section id="SLID02" class="container-fluid p-0" data-slide-height="auto">
        @foreach ($slides as $slide)
            <div class="SLID02 owl-carousel">
                <div class="container-slide container-fluid">
                    @if ($slide->link || $slide->target_link)
                        <a href="{{ $slide->link }}" target="{{ $slide->target_link }}" class="link-full"></a>
                    @endif
                    @if ($slide->path_image_desktop)
                        <img src="{{ asset('storage/' . $slide->path_image_desktop) }}"
                            class="img-background-slide" alt="image Background">
                    @endif
                    <div class="content-slide container ms-auto me-auto row justify-content-center align-items-end">
                        <div class="content-description">
                            <h2 class="title">Título</h2>
                            <div class="content-network">
                                @foreach ($topics as $topic)
                                    @if ($topic->link ||$topic->target_link)
                                        <a href="{{ $topic->link }}" target="{{ $topic->target_link }}"
                                            class="btn-cta-network transition">
                                            @if ($topic->path_image_icon)
                                                <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                                    width="25px" />
                                            @endif
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- END owl-carousel --}}
        <div id="dotsSlideCustom"></div>
    </section>
@endif
