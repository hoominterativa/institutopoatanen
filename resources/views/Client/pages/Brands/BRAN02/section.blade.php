<section class="bran02">
    @if ($content->active)
        <header class="bran02__header">
            @if ($content->title_home)
                <h2 class="bran02__header__title">{{ $content->title_home }}</h2>
            @endif
            @if ($content->subtitle_home)
                <h3 class="bran02__header__subtitle">{{ $content->subtitle_home }}</h3>
            @endif
            @if ($content->description)
                <div class="bran02__header__description">
                    <p>
                        {!! $content->description !!}
                    </p>
                </div>
            @endif
        </header>
        <aside class="bran02__categories">
            <menu class="bran02__categories__swiper-wrapper swiper-wrapper">
                @foreach ($bran02categories as $category)
                    <a href="{{ route('bran02.show', $category->slug) }}" class="bran02__categories__item swiper-slide">{{ $category->category }}</a>
                @endforeach
            </menu>

        </aside>
        <div class="bran02__products">
            <div class="bran02__products__swiper-wrapper swiper-wrapper">
                @foreach ($bran02marcas as $marcas)
                <a href="{{ $marcas->button_link }}" target="{{ $marcas->target_link }}">
                    <img class="bran02__products__item swiper-slide"
                        src="{{ asset('storage/' . $marcas->path_image) }}"
                        alt="Imagem referente a seção {{-- TITLE --}}">
                    </a>
                @endforeach
            </div>
        </div>
        @if ($content->button_text || $content->button_link || $content->target_link)
            <a href="{{ $content->button_link }}" target="{{ $content->target_link }}"
                class="bran02__cta">{{ $content->button_text ?? 'Empty' }}</a>
        @endif
    @endif
</section>
