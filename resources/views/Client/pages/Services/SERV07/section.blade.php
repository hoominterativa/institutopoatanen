<!-- TEAM01 -->
<section class="serv07-section__content__product container">
    @if ($section)
        <header class="header-topic">
            <h3 class="container-title">
                @if ($section->title || $section->subtitle)
                    <span class="title">{{ $section->title }}</span>
                    <span class="subtitle">{{ $section->subtitle }}</span>
                    <hr class="line">
                @endif
            </h3>
            @if ($section->description)
                <p class="paragraph">{!! $section->description !!}</p>
            @endif
        </header>
    @endif
    @if ($categories->count())
        <div class="serv07-section__content--row carousel-serv07-section-product">
            @foreach ($categories as $category)
                <article class="serv07-section__content__product__item">
                    <div class="serv07-section__content__product__item__image">
                        @if ($category->path_image)
                            <img src="{{ asset('storage/' . $category->path_image) }}" class="w-100 h-100"
                                alt="Titulo Topico">
                        @endif
                    </div>
                    <div
                        class="serv07-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                        <div class="serv07-section__content__product__item__description__encompass">
                            <div
                                class="flex-column serv07-section__content__product__item__description__encompass__txt">
                                @if ($category->title)
                                    <h2
                                        class="serv07-section__content__product__item__description__encompass__txt__title mx-0 px-0">
                                        {{ $category->title }}</h2>
                                @endif
                            </div>
                        </div>
                        <div class="serv07-section__content__product__item__description_paragraph text-start px-0 ">
                            @if ($category->description)
                                <p>{!! $category->description !!}</p>
                            @endif
                        </div>
                        <div class="serv07-section__content__product__item__description__buttons">
                            <a rel="next"
                                href="{{ route('serv07.category.page', ['SERV07ServicesCategory' => $category->slug]) }}"
                                class="serv07-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="serv07-section__content__product__item__description__buttons__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
    <a href="{{ route('serv07.category.page', ['SERV07ServicesCategory' => $categoryFirst->slug]) }}"
        class="serv07-section__content__cta">
        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
            class="serv07-section__content__cta__icon">
        CTA
    </a>
</section>
