@if ($topics->count())
    <section id="TOPI04" class="topi04">
        @foreach ($topics as $topic)
            @if ($topic->path_image)
                <section class="topi04__image">
                    <img src="{{ asset('storage/' . $topic->path_image) }}"
                        alt="Imagem que descreve a seção {{ $topic->title }}" class="topi04__image__img">
                </section>
            @endif




            <section class="topi04__information ">
                @if ($topic->title_topic || $topic->title || $topic->subtitle || $topic->description)
                    <header class="topi04__information__header">

                        @if ($topic->title_topic)
                            <h2 class="topi04__information__header__featured-title">{{ $topic->title_topic }}</h2>
                        @endif

                        @if ($topic->title)
                            <h3 class="topi04__information__header__title">{{ $topic->title }}</h3>
                        @endif

                        @if ($topic->subtitle)
                            <h4 class="topi04__information__header__subtitle">{{ $topic->subtitle }}</h4>
                        @endif

                        @if ($topic->title_topic || $topic->title || $topic->subtitle)
                            <hr class="topi04__information__header__line">
                        @endif

                        @if ($topic->description)
                            <div class="topi04__information__header__paragraph">
                                {!! $topic->description !!}
                            </div>
                        @endif

                        @if ($topic->link_button)
                            <a href="{{ getUri($topic->link_button) }}" target="{{ $topic->target_link_button }}"
                                class="topi04__information__header__cta">
                                @if ($topic->title_button)
                                    {{ $topic->title_button }}
                                @endif
                            </a>
                        @endif


                    </header>
                @endif

                <div class="topi04__information__topics">
                    <div class="topi04__information__topics__swiper-wrapper swiper-wrapper">

                        @foreach ($topic->topicSections as $topicSection)
                            <article class="topi04__information__topics__item swiper-slide">
                                @if ($topicSection->path_image_box)
                                    <img src="{{ asset('storage/' . $topicSection->path_image_box) }}"
                                        alt="Imagem de fundo do topico {{ $topicSection->title }}"
                                        class="topi04__information__topics__item__image">
                                @endif

                                @if ($topicSection->path_image_icon)
                                    <img src="{{ asset('storage/' . $topicSection->path_image_icon) }}"
                                        class="topi04__information__topics__item__icon" alt="Ícone do tópico {{ $topicSection->title }}">
                                @endif

                                @if ($topicSection->title)
                                    <h5 class="topi04__information__topics__item__title">
                                        {{ $topicSection->title }}
                                    </h5>
                                @endif

                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- END .row --}}
        @endforeach
    </section>
    {{-- END #ABOU04 --}}
@endif
