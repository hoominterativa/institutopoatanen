@if ($topics->count())
    @if ($section)
        <section id="TOPI101" class="topi101 container-fluid px-0"
            style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
            <div class="container container--topic101">
                @if ($section->title || $section->subtitle)
                    <div class="topi101__encompass text-center">
                        @if ($section->title)
                            <h4 class="topi101__encompass__title">{{ $section->title }}</h4>
                        @endif
                        @if ($section->subtitle)
                            <h5 class="topi101__encompass__subtitle">{{ $section->subtitle }}</h5>
                        @endif
                        <hr class="topi101__encompass__line">
                    </div>
                @endif
                {{-- END topi101__encompass --}}
                <div class="topi101__content carousel-topi101 owl-carousel">
                    @foreach ($topics as $topic)
                        <div class="topi101__box">
                            <div class="topi101__box__top">
                                @if ($topic->path_image)
                                    <div class="topi101__box__top__image">
                                        <img src="{{ asset('storage/' . $topic->path_image) }}" loading="lazy"
                                            alt="">
                                    </div>
                                @endif
                            </div>
                            <div class="topi101__box__bottom">
                                <div class="topi101__box__engLine">
                                    <span class="topi101__box__line"></span>
                                    <span class="topi101__box__thickline"></span>
                                </div>
                                <div class="topi101__box__bottom__description">
                                    @if ($topic->description)
                                        <div class="topi101__box__bottom__description__paragraph">
                                            <p>
                                                {!! $topic->description !!}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- END .topi101__box --}}
                    @endforeach
                </div>
                {{-- END .topi101__content --}}
            </div>
            {{-- END .container --}}
        </section>
    @endif
@endif
