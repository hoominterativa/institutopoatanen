<section id="BLOG01" class="blog01 container-fluid">
    <div class="container">
        @if ($section)
            <header class="blog01__header">
                @if ($section->title_section || $section->subtitle_section)
                    <h3 class="blog01__header__hypertext">
                        <span class="blog01__header__title">{{ $section->title_section }}</span>
                        <span class="blog01__header__subtitle">{{ $section->subtitle_section }}</span>
                    </h3>
                    <hr class="blog01__header__line">
                @endif
                @if ($section->description_section)
                    <p class="blog01__header__paragraph">{!! $section->description_section !!}</p>
                @endif
            </header>
        @endif
        <div class="blog01__boxs row blog01__boxs__carousel">
            @foreach ($blogs as $blog)
                <article class="blog01__boxs__item">
                    <div itemscope itemtype="http://schema.org/Article" class="blog01__boxs__item__content transition">
                        <a itemprop="url" href="{{ route('blog01.show.content', ['BLOG01BlogsCategory' => $blog->category->slug, 'BLOG01Blogs' => $blog->slug]) }}">
                            @if ($blog->path_image_thumbnail)
                                <figure class="blog01__boxs__item__image">
                                    <img itemprop="image" src="{{ asset('storage/' . $blog->path_image_thumbnail) }}" class="blog01__boxs__item__image__img" width="100%" alt="{{ $blog->title }}" />
                                </figure>
                            @endif
                            <div class="blog01__boxs__item__description d-flex align-items-center justify-content-between">
                                @if ($blog->title)
                                    <h2 itemprop="name" class="blog01__boxs__item__title">{{ $blog->title }}</h2>
                                @endif
                                @if ($blog->description)
                                    <p itemprop="articleBody" class="">
                                        {!! $blog->description !!}
                                    </p>
                                @endif
                                @if ($blog->path_image_icon)
                                    <img src="{{ asset('storage/' . $blog->path_image_icon) }}" width="34" class="blog01__boxs__item__icon" alt="{{ $blog->title }}" />
                                @endif
                            </div>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        <a rel="next" href="{{ route('blog01.page', ['BLOG01BlogsCategory' => $category->slug]) }}" class="blog01__cta transition justify-content-center align-items-center">
            {{-- <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Icone CTA" class="blog01__cta__icon me-3 transition"> --}}
            CTA
        </a>
    </div>
</section>
