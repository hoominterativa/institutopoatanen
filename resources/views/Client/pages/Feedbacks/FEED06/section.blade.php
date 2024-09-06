@if ($feedbacks->count())
    <section class="feed06" id="FEED06">

        @if ($section)
            @if ($section->title)
                <header class="feed06__header">
                    <h2 class="feed06__header__title">{{ $section->title }}</h2>
                </header>
            @endif
        @endif

        <div class="feed06__carousel">
            <div class="feed06__carousel__swiper-wrapper swiper-wrapper">
                @foreach ($feedbacks as $feedback)
                    <article class="feed06__carousel__item swiper-slide">
                        <header class="feed06__carousel__item__header">
                            @if ($feedback->name)
                                <h3 class="feed06__carousel__item__header__title">{{ $feedback->name }}</h3>
                            @endif
                            @if ($feedback->classification)
                                <ul class="feed06__carousel__item__header__stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li class="feed06__carousel__item__header__stars__item">
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
                            <div class="feed06__carousel__item__paragraph">
                                {!! $feedback->testimony !!}
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>

        @if ($section && $section->link_button)
            <a href="{{ getUri($section->link_button) }}" target="{{ $section->target_link_button }}"
                class="feed06__cta">
                @if ($section->title_button)
                    {{ $section->title_button }}
                @endif
            </a>
        @endif


    </section>
@endif
