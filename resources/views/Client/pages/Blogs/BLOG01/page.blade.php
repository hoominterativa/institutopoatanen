@extends('Client.Core.client')
@section('content')
    <main id="root" class="blog01-page">
        @if ($section)
            @if ($section->title_banner)
                <section class="blog01-page__banner"
                    style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }});">
                    <h1 class="blog01-page__banner__title">{{ $section->title_banner }}</h1>
                </section>
            @endif
        @endif

        <aside class="blog01-page__categories">
            <menu class="blog01-page__categories__swiper-wrapper swiper-wrapper">
                @foreach ($categories as $category)
                    <li class="blog01-page__categories__item {{ isset($category->selected) ? 'active' : '' }} swiper-slide">
                        <a href="{{ route('blog01.category.page', ['BLOG01BlogsCategory' => $category->slug]) }}"
                            class="link-full" title="{{ $category->title }}"></a>

                        {{ $category->title }}
                    </li>
                @endforeach
            </menu>
        </aside>

        <section class="blog01-page__articles">
            @if ($blogsFeatured->count())
                <div class="blog01-page__articles__highlighted">
                    <div class="blog01-page__articles__highlighted__carousel">
                        <div class="blog01-page__articles__highlighted__carousel__swiper-wrapper swiper-wrapper">
                            {{-- FRONTEND: VER COM ANDERSON SOBRE OS CLIQUES DO BLOG --}}
                            @foreach ($blogsFeatured as $blogFeatured)
                                <article class="blog01-page__articles__highlighted__item swiper-slide" itemscope
                                    itemtype="http://schema.org/Article">

                                    <img itemprop="image" src="{{ asset('storage/' . $blogFeatured->path_image) }}"
                                        class="blog01-page__articles__highlighted__item__image"
                                        alt="{{ $blogFeatured->title }}" />


                                    <div class="blog01-page__articles__highlighted__item__information">
                                        <p class="blog01-page__articles__highlighted__item__information__category">
                                            {{ $blogFeatured->category->title }}</p>


                                        <h2 itemprop="headline"
                                            class="blog01-page__articles__highlighted__item__information__title">
                                            {{ $blogFeatured->title }}
                                        </h2>

                                        <p class="blog01-page__articles__highlighted__item__information__time">
                                            Data: <time
                                                datetime="{{ dateFormat($blogFeatured->publishing, 'd', 'M', 'Y', '') }}"
                                                itemprop="datePublished" content="{{ $blogFeatured->publishing }}"
                                                class="blog01-page__articles__highlighted__item__date">{{ dateFormat($blogFeatured->publishing, 'd', 'M', 'Y', '') }}</time>
                                        </p>
                                        <p itemprop="description"
                                            class="blog01-page__articles__highlighted__item__information__paragraph">
                                            {{ $blogFeatured->description }}</p>
                                        <a itemprop="url"
                                            href="{{ route('blog01.show.content', ['BLOG01BlogsCategory' => $blogFeatured->category->slug, 'BLOG01Blogs' => $blogFeatured->slug]) }}"
                                            class="blog01-page__articles__highlighted__item__information__cta">
                                            CTA
                                        </a>
                                    </div>

                                </article>
                            @endforeach
                        </div>
                        <div class="blog01-page__articles__highlighted__carousel__swiper-pagination swiper-pagination">
                        </div>
                    </div>
                </div>
            @endif

            <div class="blog01-page__articles__list">
                @foreach ($blogs as $blog)
                    <article itemscope itemtype="http://schema.org/Article" class="blog01-page__articles__list__item">

                        <a title="{{ $blog->title }}" class="link-full" itemprop="url"
                            href="{{ route('blog01.show.content', ['BLOG01BlogsCategory' => $blog->category->slug, 'BLOG01Blogs' => $blog->slug]) }}"></a>

                        @if ($blog->path_image_thumbnail)
                            <img itemprop="image" src="{{ asset('storage/' . $blog->path_image_thumbnail) }}"
                                class="blog01-page__articles__list__item__image"
                                alt="Imagem do artigo {{ $blog->title }}" />
                        @endif

                        <div class="blog01-page__articles__list__item__description">
                            <p class="blog01-page__articles__list__item__description__time">
                                Data: <time class="blog01-page__articles__list__item__description__time"
                                    itemprop="datePublished"
                                    datetime='{{ dateFormat($blog->publishing, 'd', 'M', 'Y', '') }}'>{{ dateFormat($blog->publishing, 'd', 'M', 'Y', '') }}</time>
                            </p>

                            <h3 itemprop="headline" class="blog01-page__articles__list__item__title">{{ $blog->title }}
                            </h3>

                            <p itemprop="description" class="blog01-page__articles__list__item__paragraph">
                                {!! $blog->description !!}
                            </p>
                        </div>

                    </article>
                @endforeach
                <div class="blog01-page__articles__list__pagination">
                    {{ $blogs->links() }}
                </div>
            </div>
        </section>

        </div>
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
