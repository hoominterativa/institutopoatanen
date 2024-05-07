@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT02V2" class="cont02v2 position-relative container-fluid px-0"
            style="background-image: url({{ asset('storage/' . $content->path_image_background_desktop) }});">
            @if ($content->path_image_background_desktop)
                <div class="cont02v2__mark"></div>
            @endif
            <div class="container container--cont02v2 px-0 mx-auto">
                <div class="row px-0 mx-auto d-flex justify-content-between">
                    @if ($content->path_image)
                        <div class="cont02v2__left d-flex col-auto px-0">
                            <div class="cont02v2__image px-0">
                                <img src="{{ asset('storage/' . $content->path_image) }}" alt="Imagem flutuante"
                                    rel="" loading="lazy" />
                            </div>
                        </div>
                    @endif
                    {{-- END .cont02__left --}}
                    <div class="cont02v2__right col d-flex align-items-center">
                        <div class="cont02v2__description">
                            @if ($content->title || $content->subtitle)
                                <h3 class="cont02v2__title">{{ $content->title }}</h3>
                                <h2 class="cont02v2__subtitle">{{ $content->subtitle }}</h2>
                                <hr class="cont02v2__line">
                            @endif
                            @if ($content->description)
                                <div class="cont02v2__paragraph">
                                    <p>
                                        {!! $content->description !!}
                                    </p>
                                </div>
                            @endif
                            @if ($content->link_button)
                                <a href="{{ getUri($content->link_button) }}"
                                    target="{{ $content->target_link_button }}"
                                    class="cont02v2__cta transition d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="ìcone"
                                        class="cont02v2__cta__icon me-3 transition">
                                    @if ($content->title_button)
                                        {{ $content->title_button }}
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>
                    {{-- END .cont02__right --}}
                </div>
                {{-- END .row --}}
            </div>
            {{-- END .container --}}
        </section>
        {{-- END #CONT02 --}}
    @endforeach
@endif
