@if ($section)
    <section id="TOPI102" class="topi102">
        @if ($section->title || $section->subtitle)
            <header class="topi102__header">
                @if ($section->title)
                    <h2 class="topi102__header__title">{{ $section->title }}</h2>
                @endif

                @if ($section->subtitle)
                    <h3 class="topi102__header__subtitle">{{ $section->subtitle }}</h3>
                @endif
            </header>
        @endif
        @if ($featuredtopics->count())
            <div class="topi102__navigation">
                <ul class="topi102__navigation__swiper-wrapper swiper-wrapper">
                    @foreach ($featuredtopics as $featuredtopic)
                        <li class="topi102__navigation__item swiper-slide">

                            @if ($featuredtopic->quantity)
                                <h4 class="topi102__navigation__item__count">{{ $featuredtopic->quantity }}</h4>
                            @endif

                            @if ($featuredtopic->title)
                                <span class="topi102__navigation__item__title">{{ $featuredtopic->title }}</span>
                            @endif

                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($topics->count())
            <div class="topi102__topics">
                <div class="topi102__topics__swiper-wrapper swiper-wrapper">
                    @foreach ($topics as $topic)
                        <article data-fancybox data-src="#lightbox-topi102-{{ $topic->id }}"
                            class="topi102__topics__item swiper-slide">

                            @if ($topic->path_image_box)
                                <img loading="lazy" src="{{ asset('storage/' . $topic->path_image_box) }}"
                                    class="topi102__topics__item__bg"
                                    alt=" Imagem de fundo do tópico {{ $topic->title }}">
                            @endif

                            @if ($topic->title)
                                <h3 class="topi102__topics__item__title">{{ $topic->title }}</h3>
                            @endif

                            @if ($topic->description)
                                <div class="topi102__topics__item__paragraph">
                                    <p>
                                        {!! $topic->description !!}
                                    </p>
                                </div>
                            @endif

                            @include('Client.pages.Topics.TOPI102.show', ['topic' => $topic])
                        </article>
                    @endforeach
                </div>

                <div class="topi102__topics__nav">
                    <div class="topi102__topics__nav__swiper-button-prev swiper-button-prev"></div>
                    <div class="topi102__topics__nav__swiper-button-next swiper-button-next"></div>
                </div>
            </div>

        @endif




    </section>

@endif
