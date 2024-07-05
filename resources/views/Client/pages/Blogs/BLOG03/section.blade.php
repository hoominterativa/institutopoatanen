<section id="BLOG03" class="blog03">
    @if ($section)
        @if ($section->title_section || $section->subtitle_section || $section->description)
            <header class="blog03__header">
                @if ($section->title_section)
                    <h2 class="blog03__header__title">{{ $section->title_section }}</h2>
                @endif
                @if ($section->subtitle_section)
                    <h3 class="blog03__header__subtitle">{{ $section->subtitle_section }}</h3>
                @endif
                @if ($section->description_section)
                    <p class="blog03__header__paragraph">{!! $section->description_section !!}</p>
                @endif
            </header>
        @endif
    @endif

    <div class="blog03__main">
        <div class="blog03__main__swiper-wrapper swiper-wrapper">
            @foreach ($blogs as $blog)
                <article class="blog03__main__item swiper-slide">
                    <a itemprop="url"
                        href="{{ route('blog03.show.content', ['BLOG03BlogsCategory' => $blog->category->slug, 'BLOG03Blogs' => $blog->slug]) }}"
                        class="link-full"></a>

                    @if ($blog->path_image_box)
                        <figure class="blog03__main__item__image">
                            <img itemprop="image" src="{{ asset('storage/' . $blog->path_image_box) }}"
                                class="blog03__main__item__image__img" alt="image" />
                        </figure>
                    @endif
                    @if ($blog->title || $blog->description)
                        <div class="blog03__main__item__information">
                            @if ($blog->title)
                                <h4 class="blog03__main__item__information__title">{{ $blog->title }}
                                </h4>
                            @endif

                            @if ($blog->description)
                                <p class="blog03__main__item__information__paragraph">
                                    {!! $blog->description !!}
                                </p>
                            @endif
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </div>

    <a class="blog03__cta" href="{{ route('blog03.category.page', ['BLOG03BlogsCategory' => $category->slug]) }}">
        Ver todos</a>


</section>
