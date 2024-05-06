@if ($feedbacks->count())
    <section class="feed05" id="FEED05">

        @if ($section)
            @if ($section->title)
                <header class="feed05__header">
                    <h2 class="feed05__header__title">{{ $section->title }}</h2>
                </header>
            @endif
        @endif

        <main class="feed05__main">

            <div class="feed05__main__swiper-wrapper swiper-wrapper">
                @foreach ($feedbacks as $feedback)
                    <article class="feed05__main__item swiper-slide">
                        <header class="feed05__main__item__header">

                            @if ($feedback->path_image)
                                <img src="{{ asset('storage/' . $feedback->path_image) }}" alt=""
                                    class="feed05__main__item__header__avatar">
                            @endif

                            @if ($feedback->name)
                                <h3 class="feed05__main__item__header__title">{{ $feedback->name }}</h3>
                            @endif

                            @if ($feedback->classification)
                                <ul class="feed05__main__item__header__stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li class="feed05__main__item__header__stars__item">
                                            @if ($i <= $feedback->classification)
                                                <img src="{{ asset('storage/uploads/tmp/star-full.png') }}"
                                                    alt="Estrela cinza">
                                            @else
                                                <img src="{{ asset('storage/uploads/tmp/star-outline.png') }}"
                                                    alt="Contorno de estrela">
                                            @endif
                                        </li>
                                    @endfor
                                </ul>
                            @endif
                        </header>

                        @if ($feedback->testimony)
                            <main class="feed05__main__item__testimony">
                                <p>{!! $feedback->testimony !!}</p>
                            </main>
                        @endif
                    </article>
                @endforeach
            </div>
            <div class="feed05__main__nav">
                <div class="feed05__main__nav__swiper-button-prev swiper-button-prev"></div>
                <div class="feed05__main__nav__swiper-button-next swiper-button-next"></div>
            </div>
        </div>

        </main>

    </section>
@endif
