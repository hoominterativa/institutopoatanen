<section class="port06" id="PORT06">
    <header class="port06__header">
        @if ($section->subtitle_section)
            <h3 class="port06__header__subtitle">Subtítulo</h3>
        @endif
        @if ($section->title_section)
            <h2 class="port06__header__title">{{ $section->title_section }}</h2>
        @endif
        <div class="port06__header__paragraph">
            <p>{!! $section->paragraph_section !!}</p>
        </div>
    </header>

    <div class="port06__main">
        <div class="port06__main__carousel">
            <div class="port06__main__carousel__swiper-wrapper swiper-wrapper">
                @foreach ($portfolios as $portfolio)
                    <article class="port06__main__carousel__item swiper-slide">
                        <a class="link-full" title="{{ $portfolio->title }}"
                            href="{{ route('port06.show', ['PORT06Portfolios' => $portfolio->slug]) }}"></a>

                        @if ($portfolio->path_image_box && $portfolio->title)
                            <img src="{{ asset('storage/' . $portfolio->path_image_box) }}"
                                alt="Imagem do {{ $portfolio->title }}" class="port06__main__carousel__item__image">
                        @endif
                        <span class="port06__main__carousel__item__category">{{ $portfolio->category->title }}</span>
                        @if ($portfolio->title)
                            <h4 class="port06__main__carousel__item__title">{{ $portfolio->title }}</h4>
                        @endif
                        @if ($portfolio->subtitle)
                            <p class="port06__main__carousel__item__paragraph">{{ $portfolio->subtitle }} </p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
        @if ($section->title_button && $section->link_button)
            <a href="{{ $section->link_button }}" target="{{ $section->target_link_button }}"
                class="port06__main__cta">{{ $section_title_button }}</a>
        @endif
    </div>

</section>
