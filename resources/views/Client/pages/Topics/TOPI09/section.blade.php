@if ($topics->count())
    <section id="TOPI09" class="topi09">

        <div class="topi09__topics">
            <div class="swiper-wrapper">
                @foreach ($topics as $topic)
                    <article class="topi09__topics__item swiper-slide">

                        @if ($topic->path_image_icon)
                            <div class="topi09__topics__item__icon">
                                <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                loading="lazy"
                                    class="topi09__topics__item__icon__img" alt="Ícone do tópico {{ $topic->title }}">
                            </div>
                        @endif

                        @if ($topic->title || $topic->description)
                            <div class="topi09__topics__item__information">
                                @if ($topic->title)
                                    <h3 class="topi09__topics__item__information__title">{{ $topic->title }}</h3>
                                @endif

                                @if ($topic->description)
                                    <div class="topi09__topics__item__information__paragraph">
                                        <p>{!! $topic->description !!}</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
