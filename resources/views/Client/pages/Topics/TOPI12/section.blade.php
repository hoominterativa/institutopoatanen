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
                    @if ($section->subtitle)
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
        @if ($topics->count())
            <div class="topi12__topics">
                <div class="topi12__topics__swiper-wrapper swiper-wrapper">
                    @foreach ($topics as $topic)
                        <div class="topi12__topics__item swiper-slide">
                            @if ($topic->path_image_icon)
                                <img class="topi12__topics__item__image"
                                    src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                    alt="Imagem do {{ $topic->title }}">
                            @endif
                            <div class="topi12__topics__item__information">
                                @if ($topic->title)
                                    <h4 class="topi12__topics__item__information__title">
                                        {{ $topic->title }}
                                    </h4>
                                @endif
                                @if ($topic->description)
                                    <div class="topi12__topics__item__information__paragraph">
                                        {!! $topic->description !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="topi12__topics__navigation">
                    <div class="topi12__topics__navigation__swiper-button-prev swiper-button-prev"></div>
                    <div class="topi12__topics__navigation__swiper-button-next swiper-button-next"></div>
                </div>
            </div>
        @endif
    </section>
@endif
