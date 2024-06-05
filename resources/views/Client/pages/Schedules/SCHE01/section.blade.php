@if ($schedules->count() || $section)
    <section class="sche01" id="SCHE01">
        @if ($section)
            <header class="sche01__header">
                @if ($section->title)
                    <h2 class="sche01__header__title">{{ $section->title }}</h2>
                @endif
                @if ($section->subtitle)
                    <h3 class="sche01__header__sutbtitle">{{ $section->subtitle }}</h3>
                @endif
            </header>
        @endif

        @if ($schedules->count())
            <div class="sche01__carousel">
                <div class="sche01__carousel__swiper-wrapper swiper-wrapper">
                    @foreach ($schedules as $schedule)
                        <article class="sche01__carousel__item swiper-slide">
                            <a href="{{ route('sche01.show.content', ['SCHE01Schedules' => $schedule->slug]) }}"
                                class="link-full" title="{{ $schedule->title }}"></a>

                            @if ($schedule->path_image_box)
                                <img loading='lazy' src="{{ asset('storage/' . $schedule->path_image_box) }}"
                                    alt="Imagem do evento: {{ $schedule->title }}"
                                    class="sche01__carousel__item__image">
                            @endif
                            @if ($schedule->title || $schedule->subtitle || $schedule->description_box)
                                <div class="sche01__carousel__item__information">

                                    <div class="sche01__carousel__item__information__date">
                                        <span class="sche01__carousel__item__information__date__day">16</span>
                                        <span class="sche01__carousel__item__information__date__month">Maio</span>
                                        <span class="sche01__carousel__item__information__date__year">2024</span>
                                    </div>

                                    <header class="sche01__carousel__item__information__header">
                                        @if ($schedule->title)
                                            <h4 class="sche01__carousel__item__information__header__title">
                                                {{ $schedule->title }}</h4>
                                        @endif
                                        @if ($schedule->subtitle)
                                            <h5 class="sche01__carousel__item__information__header__subtitle">
                                                {{ $schedule->subtitle }}</h5>
                                        @endif
                                        @if ($schedule->description_box)
                                            <div class="sche01__carousel__item__information__header__paragraph">
                                                {!! $schedule->description_box !!}
                                            </div>
                                        @endif
                                    </header>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
                <div class="sche01__carousel__nav">
                    <div class="sche01__carousel__nav__swiper-button-prev swiper-button-prev"></div>
                    <div class="sche01__carousel__nav__swiper-button-next swiper-button-next"></div>
                </div>
            </div>
        @endif

        <a href="{{ route('sche01.page') }}" class="sche01__cta" title='Ir para página interna de eventos'>CTA</a>
    </section>
@endif
