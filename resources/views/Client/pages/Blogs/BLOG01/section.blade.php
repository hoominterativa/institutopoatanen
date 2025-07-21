<section id="BLOG01" class="blog01">

    @if ($section)
        @if ($section->title_section || $section->subtitle_section || $section->description_section)
            <header class="blog01__header">
                @if ($section->title_section)
                    <h2 class="blog01__header__title">
                        {{ $section->title_section }}
                    </h2>
                @endif
                {{-- @if ($section->subtitle_section)
                    <h3 class="blog01__header__subtitle">{{ $section->subtitle_section }}</h3>
                @endif

                @if ($section->description_section)
                    <p class="blog01__header__paragraph">{!! $section->description_section !!}</p>
                @endif --}}
            </header>
        @endif
    @endif

    <main class="blog01__main">
        <div class="blog01__main__carousel">
            <div class="blog01__main__carousel__swiper-wrapper swiper-wrapper">
                @foreach ($blogs as $blog)
                    <article itemscope itemtype="http://schema.org/Article" class="blog01__main__item swiper-slide">
                        {{-- <a
                        title="{{ $blog->title }}"
                        class="link-full" itemprop="url"
                            href="{{ route('blog01.show.content', ['BLOG01BlogsCategory' => $blog->category->slug, 'BLOG01Blogs' => $blog->slug]) }}">
                        </a> --}}

                        @if ($blog->path_image_thumbnail)
                            <img loading='lazy' itemprop="image"
                                src="{{ asset('storage/' . $blog->path_image_thumbnail) }}"
                                class="blog01__main__item__image" alt="Imagem do artigo {{ $blog->title }}" />
                        @endif

                        <div class="blog01__main__item__description">
                            <p class="blog01__main__item__description__time">
                                <time class="blog01__main__item__description__time"
                                    datetime='{{ dateFormat($blog->publishing, 'd', 'M', 'Y', '') }}'
                                    itemprop="datePublished">{{ dateFormat($blog->publishing, 'd', 'M', 'Y', '') }}</time>
                            </p>

                            @if ($blog->title)
                                <h4 itemprop="headline" class="blog01__main__item__description__title">{{ $blog->title }}
                                </h4>
                            @endif

                            @if ($blog->description)
                                <p itemprop="description" class="blog01__main__item__description__paragraph">
                                    {!! $blog->description !!}
                                </p>
                            @endif

                            <a href="{{ route('blog01.show.content', ['BLOG01BlogsCategory' => $blog->category->slug, 'BLOG01Blogs' => $blog->slug]) }}" class="blog01__main__item__description__cta">
                                <span>Leia mais</span>
                            </a>

                            {{-- BACKEND: REMOVER ÍCONE DO PAINEL --}}
                            {{-- @if ($blog->path_image_icon)
                                <img loading='lazy' src="{{ asset('storage/' . $blog->path_image_icon) }}"
                                    class="blog01__main__item__description__icon" alt="{{ $blog->title }}" />
                            @endif --}}
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="blog01__main__carousel__swiper-pagination swiper-pagination"></div>
        </div>
    </main>

    {{-- <a rel="next" href="{{ route('blog01.page', ['BLOG01BlogsCategory' => $category->slug]) }}" class="blog01__cta">
        CTA
    </a> --}}

</section>
