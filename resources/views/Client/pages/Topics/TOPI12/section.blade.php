@if ($section || $topics->count())
    <section class="topi12" id="TOPI12">
        @if ($section)
            @if ($section->title || $section->$subtitle || $section->$text)
                <header class="topi12__header">
                    @if ($section->title)
                        <h2 class="topi12__header__title">
                            {{ $section->title }}
                        </h2>
                    @endif

                    @if ($section->subitle)
                        <h3 class="topi12__header__subtitle">
                            {{ $section->subtitle }}
                        </h3>
                    @endif

                    @if ($section->text)
                        <div class="topi12__header__paragraph">
                            {!! $section->text !!}
                        </div>
                    @endif
                </header>
            @endif
        @endif
    </section>

    @if ($topics->count())
        <div class="topi12__topics">
            <div class="topi12__topics__swiper-wrapper swiper-wrapper">
                @foreach ($topics as $topic)
                    <div class="topi12__topics__item swiper-slide">
                        @if ($topic->path_image_icon)
                            <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                alt="Imagem do {{ $topic->title }}">
                        @endif
                        @if ($topic->title)
                            {{ $topic->title }}
                        @endif
                        @if ($topic->description)
                            <div>
                                {!! $topic->description !!}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

        </div>
    @endif
@endif
